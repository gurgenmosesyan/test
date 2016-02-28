<?php

namespace App\Models\Model;

use App\Models\DataTable;

class Search extends DataTable
{
    public function totalCount()
    {
        return Model::count();
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
        $query = Model::select('models.id', 'models.name', 'marks.name AS mark_name', 'category.name AS category_name')
            ->leftJoin('marks', function($query) {
                $query->on('marks.id', '=', 'models.mark_id')->where('marks.show_status', '=', Model::STATUS_ACTIVE);
            })
            ->leftJoin('model_categories AS category', function($query) {
                $query->on('category.id', '=', 'models.category_id')->where('category.show_status', '=', Model::STATUS_ACTIVE);
            })
            ->where('models.show_status', Model::STATUS_ACTIVE);
        if ($this->search != null) {
            $query->where('models.name', 'LIKE', '%'.$this->search.'%')
                ->orWhere('marks.name', 'LIKE', '%'.$this->search.'%')
                ->orWhere('category.name', 'LIKE', '%'.$this->search.'%');
        }
        return $query;
    }

    protected function constructOrder($query)
    {
        switch ($this->orderCol) {
            case 'mark_name':
                $orderCol = 'marks.name';
                break;
            case 'category_name':
                $orderCol = 'category.name';
                break;
            case 'name':
                $orderCol = 'models.name';
                break;
            default:
                $orderCol = 'models.id';
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