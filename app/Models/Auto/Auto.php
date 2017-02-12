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
use App\Models\Region\RegionMl;
use App\Models\Rudder\RudderMl;
use App\Models\Train\TrainMl;
use App\Models\Transmission\TransmissionMl;
use App\Image\Image;
use App\Models\User\User;
use Auth;

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
    const IMAGE_DEFAULT = '1';
    const IMAGE_NOT_DEFAULT = '0';
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_BLOCKED = 'blocked';
    const HIDE_MAIN_PHONE = '1';
    const NOT_HIDE_MAIN_PHONE = '0';

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
        'additional_phone2',
        'additional_phone3',
        'hide_main_phone',
        'term',
        'status'
    ];

    public function getThumb($autoEmpty)
    {
        return empty($this->image) ? url(Image::show($autoEmpty->value, 'config.auto_empty_thumb')) : url(Image::show($this->image, 'auto.thumb'));
    }

    public function getImage($autoEmpty)
    {
        return empty($this->image) ? url('/images/config/'.$autoEmpty->value) : url('/'.self::IMAGES_PATH.'/'.$this->image);
    }

    public function mileageInfo($measurement = true)
    {
        $mileage = $this->mileage_measurement == self::MILEAGE_MEASUREMENT_KM ? $this->mileage_km : $this->mileage_mile;
        if ($measurement) {
            $mileage .= ' '.trans('www.mileage.measurement.'.$this->mileage_measurement);
        }
        return $mileage;
    }

    public function isApproved()
    {
        return $this->status == self::STATUS_APPROVED;
    }

    public function isBlocked()
    {
        return $this->status == self::STATUS_BLOCKED;
    }

    public function isInTerm()
    {
        return $this->term >= date('Y-m-d');
    }

    public function isContract()
    {
        return $this->contract == self::CONTRACT;
    }

    public function isAuction()
    {
        return $this->auction == self::AUCTION;
    }

    public function isBank()
    {
        return $this->bank == self::BANK;
    }

    public function isExchange()
    {
        return $this->exchange == self::EXCHANGE;
    }

    public function isPartialPay()
    {
        return $this->partial_pay == self::PARTIAL_PAY;
    }

    public function isCustomCleared()
    {
        return $this->custom_cleared == self::CUSTOM_CLEARED;
    }

    public function isDamaged()
    {
        return $this->damaged == self::DAMAGED;
    }

    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    public function scopeNotBlocked($query)
    {
        return $query->where('status', '!=', self::STATUS_BLOCKED);
    }

    public function scopeTerm($query)
    {
        return $query->where('term', '>=', date('Y-m-d'));
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->active();
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

    public function region_ml()
    {
        return $this->belongsTo(RegionMl::class, 'region_id', 'id')->active()->current();
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
        return $this->belongsTo(InteriorColorMl::class, 'interior_color_id', 'id')->active()->current();
    }

    public function options()
    {
        return $this->hasMany(AutoOption::class, 'auto_id', 'id');
    }

    public function images()
    {
        return $this->hasMany(AutoImage::class, 'auto_id', 'id')->active();
    }
}