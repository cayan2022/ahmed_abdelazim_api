<?php

namespace App\Http\Filters;

class JobOrderFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'name',
        'email',
        'phone',
    ];


    protected function name($value)
    {
        if ($value) {
            return $this->builder
                ->when(
                    $this->request->filled('name'),
                    function ($query) use ($value) {
                        $query->where('name', 'like', '%' . $value . '%');
                    }
                );
        }

        return $this->builder;
    }


    protected function email($value)
    {
        if ($value) {
            return $this->builder
                ->when(
                    $this->request->filled('email'),
                    function ($query) use ($value) {
                        $query->where('email', 'like', '%' . $value . '%');
                    }
                );
        }

        return $this->builder;
    }


    protected function phone($value)
    {
        if ($value) {
            return $this->builder
                ->when(
                    $this->request->filled('phone'),
                    function ($query) use ($value) {
                        $query->where('phone', 'like', '%' . $value . '%');
                    }
                );
        }
    }

}
