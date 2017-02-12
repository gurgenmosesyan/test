<?php

namespace App\Models\Payment;

use App\Models\Config\Manager as ConfManager;
use App\Core\Image\SaveImage;
use App\Models\Ad\Ad;
use App\Models\Auto\Auto;
use App\Models\TopCar\TopCar;
use App\Models\UrgentCar\UrgentCar;
use GuzzleHttp\Client;
use Auth;

class PaymentManager
{

    private $config = null;
    private $userId = null;
    private $type;
    private $objectId;
    private $day;
    private $amount;
    private $payment;
    private $orderId;

    public function __construct()
    {
        $this->config = config('payment.acba');
        $this->userId = Auth::guard('user')->user()->id;
    }

    public function setTopCar($data)
    {
        $auto = Auto::active()->notBlocked()->term()->where('id', $data['auto_id'])->where('user_id', $this->userId)->firstOrFail();

        $topCar = TopCar::active()->where('auto_id', $auto->id)->where('user_id', $this->userId)->first();
        if ($topCar == null) {
            $topCar = new TopCar();
            $topCar->auto_id = $auto->id;
            $topCar->user_id = $this->userId;
            $topCar->deadline = date('Y-m-d', time() + ($data['day'] * 86400));
            $topCar->show_status = TopCar::STATUS_DELETED;
            $topCar->save();
        }

        $this->type = Payment::TYPE_TOP_CAR;
        $this->objectId = $topCar->id;
        $this->day = $data['day'];
        $pricePerDay = ConfManager::getPaymentPrices();
        $this->amount = $data['day'] * $pricePerDay['price_top_per_day']->value;
    }

    public function setUrgentCar($data)
    {
        $auto = Auto::active()->notBlocked()->term()->where('id', $data['auto_id'])->where('user_id', $this->userId)->firstOrFail();

        $urgentCar = UrgentCar::active()->where('auto_id', $auto->id)->where('user_id', $this->userId)->first();
        if ($urgentCar == null) {
            $urgentCar = new UrgentCar();
            $urgentCar->auto_id = $auto->id;
            $urgentCar->user_id = $this->userId;
            $urgentCar->deadline = date('Y-m-d', time() + ($data['day'] * 86400));
            $urgentCar->show_status = UrgentCar::STATUS_DELETED;
            $urgentCar->save();
        }

        $this->type = Payment::TYPE_URGENT_CAR;
        $this->objectId = $urgentCar->id;
        $this->day = $data['day'];
        $pricePerDay = ConfManager::getPaymentPrices();
        $this->amount = $data['day'] * $pricePerDay['price_urgent_per_day']->value;
    }

    public function setAd($data)
    {
        $ad = new Ad();
        SaveImage::save($data['image'], $ad);
        $ad->key = $data['key'];
        $ad->user_id = $this->userId;
        $ad->link = $data['link'];
        $ad->deadline = date('Y-m-d', time() + ($data['day'] * 86400));
        $ad->status = Ad::STATUS_PENDING;
        $ad->show_status = Ad::STATUS_DELETED;
        $ad->save();

        $this->type = Payment::TYPE_AD;
        $this->objectId = $ad->id;
        $this->day = $data['day'];
        $pricePerDay = ConfManager::getPriceAdPerDay();
        $this->amount = $data['day'] * $pricePerDay->value;
    }

    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
    }

    public function setPayment()
    {
        $this->payment = new Payment([
            'type' => $this->type,
            'object_id' => $this->objectId,
            'user_id' => $this->userId,
            'day' => $this->day,
            'amount' => $this->amount,
            'status' => Payment::STATUS_NOT_PAYED,
            'refund' => Payment::NOT_REFUND
        ]);
        $this->payment->save();
    }

    public function register()
    {
        $client = new Client();
        $result = $client->request('POST', $this->config['url'].$this->config['register'], [
            'verify' => false, //FIXME
            'form_params' => [
                'userName' => $this->config['username'],
                'password' => $this->config['password'],
                //'orderNumber' => $this->payment->id, //FIXME
                'orderNumber' => 14138740 + $this->payment->id,
                'amount' => $this->amount * 100,
                'returnUrl' => url_with_lng('/payment/back'),
                'language' => cLng('code'),
                'description' => 'Payment'
            ]
        ]);
        $status = 'INVALID_DATA';
        $data = null;
        $errors = ['day' => [trans('www.payment.register.error')]];
        if ($result->getStatusCode() == 200) {
            $result = json_decode($result->getBody()->getContents());
            if (!isset($result->errorCode) || $result->errorCode == '0') {
                $this->payment->order_id = $result->orderId;
                $this->payment->save();
                $status = 'OK';
                $data = ['url' => $result->formUrl];
            }
        }
        return ['status' => $status, 'data' => $data, 'errors' => $errors];
    }

    public function status()
    {
        $client = new Client();
        $result = $client->request('POST', $this->config['url'].$this->config['status'], [
            'verify' => false, //FIXME
            'form_params' => [
                'userName' => $this->config['username'],
                'password' => $this->config['password'],
                'orderId' => $this->orderId,
                'language' => cLng('code')
            ]
        ]);
        return $result;
    }

    public function refund($payment)
    {
        $client = new Client();
        $result = $client->request('POST', $this->config['url'].$this->config['refund'], [
            'verify' => false, //FIXME
            'form_params' => [
                'userName' => $this->config['username'],
                'password' => $this->config['password'],
                'orderId' => $payment->order_id,
                'amount' => $payment->amount,
                'language' => cLng('code')
            ]
        ]);

        if ($result->getStatusCode() == 200) {
            $result = json_decode($result->getBody()->getContents());
            if (!isset($result->ErrorCode) || $result->ErrorCode == '0') {
                $payment->refund = Payment::REFUND;
                $payment->save();
            }
        }
    }

    public function deleteNotConfirmedData()
    {
        $time = date('Y-m-d H:i:s', time() - (60*60*24*3));

        TopCar::where('show_status', TopCar::STATUS_DELETED)->where('created_at', '<', $time)->delete();
        UrgentCar::where('show_status', TopCar::STATUS_DELETED)->where('created_at', '<', $time)->delete();
        Ad::where('show_status', TopCar::STATUS_DELETED)->where('created_at', '<', $time)->delete();
    }
}