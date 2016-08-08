<?php

namespace App\Models\TopCar;

use App\Core\DataTable;

class Search extends DataTable
{
    public function totalCount()
    {
        return TopCar::active()->count();
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
            $value->auto = $value->mark_name.' '.$value->model_name.' ('.$value->year.')';
            $value->user = $value->first_name.' '.$value->last_name;
        }
        return $data;
    }

    protected function constructQuery()
    {
        $query = TopCar::select('top_cars.id', 'top_cars.deadline', 'marks.name as mark_name', 'models.name as model_name', 'autos.year', 'users.first_name', 'users.last_name')
            ->join('autos', function($query) {
                $query->on('autos.id', '=', 'top_cars.auto_id')->where('autos.show_status', '=', TopCar::STATUS_ACTIVE);
            })
            ->leftJoin('marks', function($query) {
                $query->on('marks.id', '=', 'autos.mark_id')->where('marks.show_status', '=', TopCar::STATUS_ACTIVE);
            })
            ->leftJoin('models', function($query) {
                $query->on('models.id', '=', 'autos.model_id')->where('models.show_status', '=', TopCar::STATUS_ACTIVE);
            })
            ->leftJoin('users', function($query) {
                $query->on('users.id', '=', 'top_cars.user_id')->where('users.show_status', '=', TopCar::STATUS_ACTIVE);
            })
            ->active()
            ->where('top_cars.show_status', TopCar::STATUS_ACTIVE);

        if ($this->search != null) {
            $parts = explode(' ', $this->search);
            foreach ($parts as $key => $part) {
                if (empty($part)) {
                    unset($parts[$key]);
                }
            }
            $parts = array_values($parts);

            $query->where(function($query) use($parts) {
                if (count($parts) == 1) {
                    $query->where('marks.name', 'LIKE', '%'.$parts[0].'%')
                        ->orWhere('models.name', 'LIKE', '%'.$parts[0].'%');
                } else if (count($parts) == 2) {
                    $query->where(function($query) use($parts) {
                        $query->where('marks.name', 'LIKE', '%'.$parts[0].'%')
                            ->where('models.name', 'LIKE', '%'.$parts[1].'%');
                    })->orWhere(function($query) use($parts) {
                        $query->where('marks.name', 'LIKE', '%'.$parts[1].'%')
                            ->where('models.name', 'LIKE', '%'.$parts[0].'%');
                    });
                } else if (count($parts) == 3) {
                    $query->where(function($query) use($parts) {
                        $query->where('marks.name', 'LIKE', '%'.$parts[0].'%')
                            ->where('models.name', 'LIKE', '%'.$parts[1].'%')
                            ->where('autos.year', 'LIKE', '%'.$parts[2].'%');
                    })->orWhere(function($query) use($parts) {
                        $query->where('marks.name', 'LIKE', '%'.$parts[1].'%')
                            ->where('models.name', 'LIKE', '%'.$parts[0].'%')
                            ->where('autos.year', 'LIKE', '%'.$parts[2].'%');
                    });
                }
            });
        }
        return $query;
    }

    protected function constructOrder($query)
    {
        switch ($this->orderCol) {
            case 'auto':
                $orderCol = 'marks.name';
                break;
            case 'user':
                $orderCol = 'users.first_name';
                break;
            case 'deadline':
                $orderCol = 'top_cars.deadline';
                break;
            default:
                $orderCol = 'top_cars.id';
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