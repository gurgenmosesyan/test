<?php

namespace App\Models\Tax;

use App\Core\DataTable;

class Search extends DataTable
{
    public function totalCount()
    {
        return Tax::count();
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
            $value->price .= ' '.strtoupper($value->currency_code);
        }
        return $data;
    }

    protected function constructQuery()
    {
        $query = Tax::select('tax.id', 'tax.year', 'tax.volume', 'tax.price', 'marks.name as mark_name', 'models.name as model_name', 'engine.name as engine_name', 'currencies.code as currency_code')
            ->leftJoin('marks', function($query) {
                $query->on('marks.id', '=', 'tax.mark_id')->where('marks.show_status', '=', Tax::STATUS_ACTIVE);
            })
            ->leftJoin('models', function($query) {
                $query->on('models.id', '=', 'tax.model_id')->where('models.show_status', '=', Tax::STATUS_ACTIVE);
            })
            ->leftJoin('engines_ml as engine', function($query) {
                $query->on('engine.id', '=', 'tax.engine_id')->where('engine.lng_id', '=', cLng('id'))->where('engine.show_status', '=', Tax::STATUS_ACTIVE);
            })
            ->leftJoin('currencies', function($query) {
                $query->on('currencies.id', '=', 'tax.currency_id')->where('currencies.show_status', '=', Tax::STATUS_ACTIVE);
            });

        if ($this->search != null) {
            $query->where('tax.year', $this->search)
                ->orWhere('tax.year', $this->search)
                ->orWhere('tax.volume', $this->search)
                ->orWhere('marks.name', 'LIKE', '%'.$this->search.'%')
                ->orWhere('models.name', 'LIKE', '%'.$this->search.'%');
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
            case 'engine_name':
                $orderCol = 'engine.name';
                break;
            case 'year':
                $orderCol = 'tax.year';
                break;
            case 'volume':
                $orderCol = 'tax.volume';
                break;
            default:
                $orderCol = 'tax.id';
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