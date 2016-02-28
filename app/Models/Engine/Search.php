<?php

namespace App\Models\Engine;

use App\Models\DataTable;

class Search extends DataTable
{
    public function totalCount()
    {
        return Engine::count();
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
        $query = Engine::select('engines.id', 'ml.name')
            ->join('engines_ml AS ml', function($query) {
                $query->on('ml.id', '=', 'engines.id')->where('ml.lng_id', '=', cLng('id'))->where('ml.show_status', '=', Engine::STATUS_ACTIVE);
            })
            ->where('engines.show_status', Engine::STATUS_ACTIVE);
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
                $orderCol = 'engines.id';
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