<?php

namespace App\Models\Rudder;

use App\Models\DataTable;

class Search extends DataTable
{
    public function totalCount()
    {
        return Rudder::count();
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
        $query = Rudder::select('rudders.id', 'ml.name')
            ->join('rudders_ml AS ml', function($query) {
                $query->on('ml.id', '=', 'rudders.id')->where('ml.lng_id', '=', cLng('id'))->where('ml.show_status', '=', Rudder::STATUS_ACTIVE);
            })
            ->where('rudders.show_status', Rudder::STATUS_ACTIVE);
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
                $orderCol = 'rudders.id';
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