<?php

namespace App\Models\ModelCategory;

use App\Core\DataTable;

class Search extends DataTable
{
    public function totalCount()
    {
        return Category::active()->count();
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
        $query = Category::select('model_categories.id', 'model_categories.name', 'marks.name AS mark_name')
            ->leftJoin('marks', function($query) {
                $query->on('marks.id', '=', 'model_categories.mark_id')->where('marks.show_status', '=', Category::STATUS_ACTIVE);
            })
            ->where('model_categories.show_status', Category::STATUS_ACTIVE);
        if ($this->search != null) {
            $query->where('model_category.name', 'LIKE', '%'.$this->search.'%')
                ->orWhere('marks.name', 'LIKE', '%'.$this->search.'%');
        }
        return $query;
    }

    protected function constructOrder($query)
    {
        switch ($this->orderCol) {
            case 'mark_name':
                $orderCol = 'marks.name';
                break;
            case 'name':
                $orderCol = 'model_categories.name';
                break;
            default:
                $orderCol = 'model_categories.id';
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