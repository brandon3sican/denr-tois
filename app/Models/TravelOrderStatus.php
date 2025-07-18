<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TravelOrderStatus extends Model
{
    protected $fillable = ['name', 'description'];

    public function travelOrders(): HasMany
    {
        return $this->hasMany(TravelOrder::class, 'status_id');
    }
}
