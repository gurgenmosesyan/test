<?php

namespace App\Models\Train;

use App\Core\DataTable;

class Search extends DataTable
{
    public function totalCount()
    {
        return Train::active()->count();
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
        $query = Train::select('trains.id', 'ml.name')
            ->join('trains_ml AS ml', function($query) {
                $query->on('ml.id', '=', 'trains.id')->where('ml.lng_id', '=', cLng('id'))->where('ml.show_status', '=', Train::STATUS_ACTIVE);
            })
            ->where('trains.show_status', Train::STATUS_ACTIVE);
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
                $orderCol = 'trains.id';
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