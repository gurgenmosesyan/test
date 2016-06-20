<?php

namespace App\Models\Part;

use App\Core\DataTable;

class Search extends DataTable
{
    public function totalCount()
    {
        return Part::count();
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
        $query = Part::select('parts.id', 'marks.name as mark_name', 'models.name as model_name')
            ->leftJoin('marks', function($query) {
                $query->on('marks.id', '=', 'parts.mark_id')->where('marks.show_status', '=', Part::STATUS_ACTIVE);
            })
            ->leftJoin('models', function($query) {
                $query->on('models.id', '=', 'parts.model_id')->where('models.show_status', '=', Part::STATUS_ACTIVE);
            });

        if (!empty($this->columns[1]['search']['value'])) {
            $query->where('parts.mark_id', $this->columns[0]['search']['value']);
        }
        if (!empty($this->columns[2]['search']['value'])) {
            $query->where('parts.model_id', $this->columns[4]['search']['value']);
        }
        return $query;
    }

    protected function constructOrder($query)
    {
        switch ($this->orderCol) {
            case 'mark_name':
                $orderCol = 'marks.name';
                break;
            case 'model_name':
                $orderCol = 'models.name';
                break;
            default:
                $orderCol = 'parts.id';
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