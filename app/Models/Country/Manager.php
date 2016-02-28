<?php

namespace App\Models\Country;

use DB;

class Manager
{
    public function store($data)
    {
        $country = new Country($data);
        $country->show_status = Country::STATUS_ACTIVE;
        DB::transaction(function() use($data, $country) {
            $country->save();
            $this->storeMl($data['ml'], $country);
        });
        return true;
    }

    public function update($id, $data)
    {
        $country = Country::active()->findOrFail($id);
        $data['show_status'] = Country::STATUS_ACTIVE;
        DB::transaction(function() use($data, $country) {
            $country->update($data);
            $this->updateMl($data['ml'], $country);
        });
        return true;
    }

    protected function storeMl($data, Country $country)
    {
        $ml = [];
        $i = 0;
        foreach ($data as $lngId => $mlData) {
            $mlData['lng_id'] = $lngId;
            $ml[$i] = new countryMl($mlData);
            $ml[$i]->show_status = Country::STATUS_ACTIVE;
            $i++;
        }
        $country->ml()->saveMany($ml);
    }

    protected function updateMl($data, Country $country)
    {
        CountryMl::active()->where('id', $country->id)->update(['show_status' => Country::STATUS_DELETED]);

        $newMl = [];
        foreach ($data as $lngId => $mlData) {
            $ml = CountryMl::where('id', $country->id)->where('lng_id', $lngId)->first();
            if ($ml == null) {
                $newMl[$lngId] = $mlData;
            } else {
                $mlData['show_status'] = Country::STATUS_ACTIVE;
                CountryMl::where('id', $country->id)->where('lng_id', $lngId)->update($mlData);
            }
        }
        if (!empty($newMl)) {
            $this->storeMl($newMl, $country);
        }
    }

    public function delete($id)
    {
        DB::transaction(function() use($id) {
            Country::active()->where('id', $id)->update(['show_status' => Country::STATUS_DELETED]);
            CountryMl::active()->where('id', $id)->update(['show_status' => Country::STATUS_DELETED]);
        });
        return true;
    }
}