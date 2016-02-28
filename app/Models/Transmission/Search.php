<?php

namespace App\Models\Transmission;

use App\Models\DataTable;

class Search extends DataTable
{
    public function totalCount()
    {
        return Transmission::count();
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
        $query = Transmission::select('transmissions.id', 'ml.name')
            ->join('transmissions_ml AS ml', function($query) {
                $query->on('ml.id', '=', 'transmissions.id')->where('ml.lng_id', '=', cLng('id'))->where('ml.show_status', '=', Transmission::STATUS_ACTIVE);
            })
            ->where('transmissions.show_status', Transmission::STATUS_ACTIVE);
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
                $orderCol = 'transmissions.id';
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