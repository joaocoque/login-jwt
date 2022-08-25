<?php

namespace App\Traits\Actived;

trait ActiveTrait
{
    public function scopeActived($query, $status = true)
    {
        return $query->where('active', $status);
    }

    public function getActiveStatusAttribute()
    {
        switch ($this->active):
            case 0:
                $activeStatus = 'danger';
                break;
            case 1:
                $activeStatus = 'success';
                break;
        endswitch;

        return $activeStatus ?? null;
    }
}
