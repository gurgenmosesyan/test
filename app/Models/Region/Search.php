<?php

namespace App\Models\Region;

use App\Core\DataTable;

class Search extends DataTable
{
    public function totalCount()
    {
        return Region::active()->count();
    }

    public function filteredCount()
    {
        $query = $this->constructQuery();
        return $query->count();
    }

    public function search()
    {
        $query = $this->constructQuery();
        $this->constructOrder($query);
        $this->constructLimit($query);
        return $query->get();
    }

    protected function constructQuery()
    {
        $query = Region::select('regions.id', 'ml.name', 'country.name AS country_name')
            ->join('regions_ml AS ml', function($query) {
                $query->on('ml.id', '=', 'regions.id')->where('ml.lng_id', '=', cLng('id'))->where('ml.show_status', '=', Region::STATUS_ACTIVE);
            })
            ->leftJoin('countries_ml AS country', function($query) {
                $query->on('country.id', '=', 'regions.country_id')->where('country.lng_id', '=', cLng('id'));
            })
            ->where('regions.show_status', Region::STATUS_ACTIVE);
        if ($this->search != null) {
            $query->where('ml.name', 'LIKE', '%'.$this->search.'%')
                ->orWhere('country.name', 'LIKE', '%'.$this->search.'%');
        }
        return $query;
    }

    protected function constructOrder($query)
    {
        switch ($this->orderCol) {
            case 'name':
                $orderCol = 'ml.name';
                break;
            default:
                $orderCol = 'regions.id';
        }
        $orderType = 'desc';
        if ($this->orderType == 'asc') {
            $orderType = 'asc';
        }
        $query->orderBy($orderCol, $orderType);
    }

    protected function constructLimit($query)
    {
        $query->skip($this->start)->take($this->length);
    }
}