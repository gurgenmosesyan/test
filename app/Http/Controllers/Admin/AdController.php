<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\BaseController;
use App\Models\Ad\Ad;
use App\Models\Ad\Manager;
use App\Models\Ad\Search;
use App\Http\Requests\Admin\AdRequest;
use App\Models\Payment\Payment;
use App\Models\Payment\PaymentManager;
use Illuminate\Http\Request;
use DB;

class AdController extends BaseController
{
    protected $manager = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function table()
    {
        return view('admin.ad.index');
    }

    public function index(Search $search)
    {
        $result = $this->processDataTable($search);
        return $this->toDataTable($result);
    }

    public function create()
    {
        $ad = new Ad();

        return view('admin.ad.edit')->with([
            'ad' => $ad,
            'saveMode' => 'add'
        ]);
    }

    public function store(AdRequest $request)
    {
        $this->manager->store($request->all());
        return $this->api('OK');
    }

    public function edit($id)
    {
        $ad = Ad::active()->findOrFail($id);

        return view('admin.ad.edit')->with([
            'ad' => $ad,
            'saveMode' => 'edit'
        ]);
    }

    public function update(AdRequest $request, $id)
    {
        $this->manager->update($id, $request->all());
        return $this->api('OK');
    }

    public function delete($id)
    {
        $this->manager->delete($id);
        return $this->api('OK');
    }

    public function changeStatus(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');
        if ($status != Ad::STATUS_CONFIRMED && $status != Ad::STATUS_DECLINED) {
            return $this->api('INVALID_DATA');
        }

        $ad = Ad::active()->where('id', $id)->firstOrFail();

        if ($status == Ad::STATUS_DECLINED) {
            $payment = Payment::where('type', Payment::TYPE_AD)->where('object_id', $ad->id)->where('refund', Payment::NOT_REFUND)->first();
            if ($payment != null) {
                $paymentManager = new PaymentManager();
                $paymentManager->refund($payment);
            }
        }

        $ad->status = $status;
        DB::transaction(function() use($ad) {
            $ad->save();
            $this->manager->removeCache($ad->key);
        });

        return $this->api('OK');
    }
}