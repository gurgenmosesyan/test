<?php

namespace App\Models\Auto;

use App\Core\Model;
use App\Models\Body\BodyMl;
use App\Models\Color\ColorMl;
use App\Models\Country\CountryMl;
use App\Models\InteriorColor\ColorMl as InteriorColorMl;
use App\Models\Engine\EngineMl;
use App\Models\Mark\Mark;
use App\Models\Model\Model as AutoModel;
use App\Models\Rudder\RudderMl;
use App\Models\Train\TrainMl;
use App\Models\Transmission\TransmissionMl;

class Auto extends Model
{
    const IMAGES_PATH = 'images/auto';
    const MILEAGE_MEASUREMENT_KM = 'km';
    const MILEAGE_MEASUREMENT_MILE = 'mile';
    const CONTRACT = '1';
    const NOT_CONTRACT = '0';
    const EXCHANGE = '1';
    const AUCTION = '1';
    const NOT_AUCTION = '0';
    const BANK = '1';
    const NOT_BANK = '0';
    const NOT_EXCHANGE = '0';
    const PARTIAL_PAY = '1';
    const NOT_PARTIAL_PAY = '0';
    const CUSTOM_CLEARED = '1';
    const NOT_CUSTOM_CLEARED = '0';
    const DAMAGED = '1';
    const NOT_DAMAGED = '0';
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_BLOCKED = 'blocked';

    protected $table = 'autos';

    protected $fillable = [
        'user_id',
        'image',
        'mark_id',
        'model_category_id',
        'model_id',
        'body_id',
        'transmission_id',
        'rudder_id',
        'color_id',
        'interior_color_id',
        'engine_id',
        'cylinders',
        'train_id',
        'doors',
        'wheels',
        'country_id',
        'region_id',
        'tuning',
        'year',
        'mileage_km',
        'mileage_mile',
        'mileage_measurement',
        'volume',
        'horsepower',
        'place',
        'currency_id',
        'price',
        'contract',
        'auction',
        'bank',
        'exchange',
        'partial_pay',
        'custom_cleared',
        'damaged',
        'vin',
        'description',
        'additional_phone',
        'term',
        'status'
    ];

    public function getImage()
    {
        return empty($this->image) ? url('/images/auto_empty.jpg') : url('/'.self::IMAGES_PATH.'/'.$this->image);
    }

    public function mileageInfo()
    {
        $mileage = $this->mileage_measurement == self::MILEAGE_MEASUREMENT_KM ? $this->mileage_km : $this->mileage_mile;
        return $mileage.' '.trans('www.mileage.measurement.'.$this->mileage_measurement);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    public function scopeTerm($query)
    {
        return $query->where('term', '>=', date('Y-m-d'));
    }

    public function mark()
    {
        return $this->belongsTo(Mark::class, 'mark_id', 'id')->active();
    }

    public function model()
    {
        return $this->belongsTo(AutoModel::class, 'model_id', 'id')->active();
    }

    public function country_ml()
    {
        return $this->belongsTo(CountryMl::class, 'country_id', 'id')->active()->current();
    }

    public function engine_ml()
    {
        return $this->belongsTo(EngineMl::class, 'engine_id', 'id')->active()->current();
    }

    public function transmission_ml()
    {
        return $this->belongsTo(TransmissionMl::class, 'transmission_id', 'id')->active()->current();
    }

    public function rudder_ml()
    {
        return $this->belongsTo(RudderMl::class, 'rudder_id', 'id')->active()->current();
    }

    public function train_ml()
    {
        return $this->belongsTo(TrainMl::class, 'train_id', 'id')->active()->current();
    }

    public function body_ml()
    {
        return $this->belongsTo(BodyMl::class, 'body_id', 'id')->active()->current();
    }

    public function color_ml()
    {
        return $this->belongsTo(ColorMl::class, 'color_id', 'id')->active()->current();
    }

    public function interior_color_ml()
    {
        return $this->belongsTo(InteriorColorMl::class, 'color_id', 'id')->active()->current();
    }

    public function options()
    {
        return $this->hasMany(AutoOption::class, 'auto_id', 'id');
    }

    public function images()
    {
        return $this->hasMany(AutoImage::class, 'auto_id', 'id');
    }
}