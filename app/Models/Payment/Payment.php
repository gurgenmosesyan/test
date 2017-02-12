<?php

namespace App\Models\Payment;

use App\Core\Model;

class Payment extends Model
{
    const TYPE_TOP_CAR = 'top_car';
    const TYPE_URGENT_CAR = 'urgent_car';
    const TYPE_AD = 'ad';
    const STATUS_PAYED = 'payed';
    const STATUS_NOT_PAYED = 'not_payed';
    const REFUND = '1';
    const NOT_REFUND = '0';

    protected $table = 'payments';

    protected $fillable = [
        'type',
        'object_id',
        'user_id',
        'day',
        'order_id',
        'amount',
        'data',
        'status',
        'refund'
    ];
}