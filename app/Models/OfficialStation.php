<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Region;

class OfficialStation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'region_id',
        'name',
        'code',
        'address',
        'contact_number',
        'email',
        'officer_in_charge',
        'officer_position',
        'is_active',
        'description'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
