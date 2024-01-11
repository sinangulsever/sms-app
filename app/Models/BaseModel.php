<?php

namespace App\Models;

use App\Observers\ModelObserve;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{

    protected static function boot(): void
    {
        parent::boot();
        self::observe(ModelObserve::class);
    }


    public function scopeCustomers($query)
    {
        return $query->where('customer_id', user()->customer_id);
    }


}
