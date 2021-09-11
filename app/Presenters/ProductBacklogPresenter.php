<?php

namespace App\Presenters;

trait ProductBacklogPresenter
{
    public function getVisibilityAttribute()
    {
        return $this->attributes['is_private'] ? trans('Private') : trans('Public');
    }
}
