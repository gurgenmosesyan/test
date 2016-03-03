<?php

namespace App\Models\Country;

use App\Core\DataTable;

class Search extends DataTable
{
    public function totalCount()
    {
        return Country::count();
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
        $query = Country::select('countries.id', 'ml.name')
            ->join('countries_ml AS ml', function($query) {
                $query->on('ml.id', '=', 'countries.id')->where('ml.lng_id', '=', cLng('id'))->where('ml.show_status', '=', Country::STATUS_ACTIVE);
            })
            ->where('countries.show_status', Country::STATUS_ACTIVE);
        if ($this->search != null) {
            $query->where('ml.name', 'LIKE', '%'.$this->search.'%');
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
                $orderCol = 'countries.id';
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