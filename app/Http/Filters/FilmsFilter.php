<?php

namespace App\Http\Filters;

use Carbon\Carbon;

class FilmsFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'title',
        'category',
        'date'
    ];

    /**
     * Filter the query by a given title.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function title($value)
    {
        if ($value) {
            return $this->builder->where('title', 'like', "%$value%");
        }

        return $this->builder;
    }


    /**
     * Filter the query by a given name.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function category($value)
    {
        if ($value) {
            return $this->builder->where('category_id', $value);
        }

        return $this->builder;
    }


    /**
     * Filter the query by a given name.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function date($value)
    {
        if ($value) {
            $date = Carbon::parse($value)->format('Y-m-d H:i:s');
            return $this->builder->where('show_date', $date);
        }

        return $this->builder;
    }


}
