<?php

declare(strict_types=1);

namespace App\Http\Filters\V1;

use Illuminate\Database\Eloquent\Builder;

class EventFilter extends QueryFilter
{
    public function name($value): Builder
    {
        $likeString = str_replace('*','%', $value);

        return $this->builder->where('name', 'LIKE', $likeString);
    }

    public function participant_count($value): Builder
    {
        $participant_count = explode(',', $value);

        if (count($participant_count) > 1) {
            return $this->builder->whereBetween('max_participant_count', $participant_count);
        }

        return $this->builder->whereDate('max_participant_count', $participant_count[0]);
    }

    public function created_by($value): Builder
    {
        return $this->builder->where('created_by', $value);
    }

    public function start_date($value): Builder
    {
        $start_date = explode(',', $value);

        if (count($start_date) > 1) {
            return $this->builder->whereBetween('start_date', $start_date);
        }

        return $this->builder->whereDate('start_date', $start_date[0]);
    }

    public function end_date($value): Builder
    {
        $end_date = explode(',', $value);

        if (count($end_date) > 1) {
            return $this->builder->whereBetween('start_date', $end_date);
        }

        return $this->builder->whereDate('start_date', $end_date[0]);
    }

}