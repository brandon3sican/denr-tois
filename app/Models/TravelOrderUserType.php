<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TravelOrderUserType extends Model
{
    protected $fillable = ['name', 'description'];

    public function signatories(): HasMany
    {
        return $this->hasMany(TravelOrderSignatory::class, 'user_type_id');
    }
}
