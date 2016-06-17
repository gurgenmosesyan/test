<?php

namespace App\Models\Currency;

use App\Core\Image\SaveImage;

class Manager
{
    public function store($data)
    {
        $data = $this->processSave($data);
        $currency = new Currency($data);
        SaveImage::save($data['icon'], $currency, 'icon');
        $currency->show_status = Currency::STATUS_ACTIVE;
        $currency->save();
        $this->updateDefault($currency);
        return true;
    }

    public function update($id, $data)
    {
        $currency = Currency::active()->findOrFail($id);
        SaveImage::save($data['icon'], $currency, 'icon');
        $data = $this->processSave($data);
        $currency->update($data);
        $this->updateDefault($currency);
        return true;
    }

    protected function processSave($data)
    {
        if (!isset($data['default'])) {
            $data['default'] = Currency::IS_NOT_DEFAULT;
        }
        return $data;
    }

    protected function updateDefault(Currency $currency)
    {
        if ($currency->default == Currency::IS_DEFAULT) {
            Currency::active()->where('id', '!=', $currency->id)->update(['default' => Currency::IS_NOT_DEFAULT]);
        } else {
            Currency::active()->where('code', 'usd')->update(['default' => Currency::IS_DEFAULT]);
        }
    }

    public function delete($id)
    {
        Currency::where('id', $id)->update(['show_status' => Currency::STATUS_DELETED]);
        return true;
    }
}