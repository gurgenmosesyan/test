<?php

namespace App\Models\Ad;

use App\Core\DataTable;

class Search extends DataTable
{
    public function totalCount()
    {
        return Ad::active()->count();
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
        $data = $query->get();
        foreach ($data as $value) {
            $value->user = $value->first_name.' '.$value->last_name;
            if ($value->key == Ad::KEY_TOP) {
                $attr = 'width="400"';
            } else if ($value->key == Ad::KEY_THIN) {
                $attr = 'width="300"';
            } else if ($value->key == Ad::KEY_RIGHT) {
                $attr = 'height="100"';
            } else {
                $attr = 'height="95"';
            }
            $value->image = '<img src="'.$value->getImage().'" '.$attr.'>';
            $value->key = trans('admin.ad.key.'.$value->key);
        }
        return $data;
    }

    protected function constructQuery()
    {
        $query = Ad::select('ads.*', 'users.first_name', 'users.last_name')
            ->leftJoin('users', function($query) {
                $query->on('users.id', '=', 'ads.user_id')->where('users.show_status', '=', Ad::STATUS_ACTIVE);
            })
            ->active()
            ->where('ads.show_status', Ad::STATUS_ACTIVE);

        if ($this->search != null) {
            $query->where('ads.key', 'LIKE', '%'.$this->search.'%');
        }
        return $query;
    }

    protected function constructOrder($query)
    {
        switch ($this->orderCol) {
            case 'user':
                $orderCol = 'users.first_name';
                break;
            case 'deadline':
                $orderCol = 'ads.deadline';
                break;
            default:
                $orderCol = 'ads.id';
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