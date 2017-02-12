<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdRequest;
use App\Http\Requests\TopCarRequest;
use App\Http\Requests\UrgentCarRequest;
use App\Models\Ad\Ad;
use App\Models\Payment\Payment;
use App\Models\Payment\PaymentManager;
use App\Models\TopCar\TopCar;
use App\Models\UrgentCar\UrgentCar;
use Illuminate\Http\Request;
use Session;

class PaymentController extends Controller
{
    private $manager = null;

    public function __construct(PaymentManager $manager)
    {
        $this->manager = $manager;
    }

    public function topCar(TopCarRequest $request)
    {
        $data = $request->all();
        $this->manager->setTopCar($data);
        $this->manager->setPayment();
        $result = $this->manager->register();
        return $this->api($result['status'], $result['data'], $result['errors']);
    }

    public function urgentCar(UrgentCarRequest $request)
    {
        $data = $request->all();
        $this->manager->setUrgentCar($data);
        $this->manager->setPayment();
        $result = $this->manager->register();
        return $this->api($result['status'], $result['data'], $result['errors']);
    }

    public function ad(AdRequest $request)
    {
        $data = $request->all();
        $this->manager->setAd($data);
        $this->manager->setPayment();
        $result = $this->manager->register();
        return $this->api($result['status'], $result['data'], $result['errors']);
    }

    public function back(Request $request)
    {
        $orderId = $request->input('orderId');
        $this->manager->setOrderId($orderId);

        $success = false;
        $error = '';
        $type = null;
        $autoId = null;

        $payment = Payment::where('order_id', $orderId)->where('status', Payment::STATUS_NOT_PAYED)->first();
        if ($payment != null) {

            $type = $payment->type;
            $autoId = $payment->type != Payment::TYPE_AD ? $payment->object_id : null;

            $result = $this->manager->status();

            if ($result->getStatusCode() == 200) {
                $result = json_decode($result->getBody()->getContents());
                if (!isset($result->ErrorCode) || $result->ErrorCode == '0') {
                    if ($result->OrderStatus == '2') {
                        $payment->status = Payment::STATUS_PAYED;
                        $payment->data = json_encode($result);
                        $payment->save();
                        if ($payment->type == Payment::TYPE_AD) {
                            Ad::where('id', $payment->object_id)->where('user_id', $payment->user_id)->update(['show_status' => Ad::STATUS_ACTIVE]);
                        } else {
                            if ($payment->type == Payment::TYPE_TOP_CAR) {
                                $object = TopCar::where('id', $payment->object_id)->where('user_id', $payment->user_id)->firstOrFail();
                            } else {
                                $object = UrgentCar::where('id', $payment->object_id)->where('user_id', $payment->user_id)->firstOrFail();
                            }
                            if ($object->show_status == TopCar::STATUS_DELETED) {
                                $object->show_status = TopCar::STATUS_ACTIVE;
                            } else {
                                if ($object->deadline >= date('Y-m-d')) {
                                    $object->deadline = date('Y-m-d', strtotime($object->deadline) + ($payment->day * 86400));
                                } else {
                                    $object->deadline = date('Y-m-d', time() + ($payment->day * 86400));
                                }
                            }
                            $object->save();
                        }
                        $success = true;
                    }
                } else {
                    $error = $result->ErrorCode;
                }
            }
        }

        $request->session()->flash('payment_success', $success);
        $request->session()->flash('payment_error', $error);
        $request->session()->flash('payment_type', $type);
        $request->session()->flash('payment_auto_id', $autoId);

        return redirect(url_with_lng('/payment/result', false));
    }

    public function result()
    {
        if (!Session::get('payment_type')) {
            return redirect()->route('homepage', cLng('code'));
        }
        return view('payment.result')->with([
            'success' => Session::get('payment_success'),
            'error' => Session::get('payment_error'),
            'autoId' => Session::get('payment_auto_id'),
            'type' => Session::get('payment_type'),
        ]);
    }
}