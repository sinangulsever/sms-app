<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;

class ModelObserve
{


    public function creating(Model $model): void
    {
        // custoner_id auto set model
        if (in_array('customer_id', array_merge($model->getFillable(), $model->getHidden()))) {
            $model->customer_id = user()->customer_id;
        }
    }

}
