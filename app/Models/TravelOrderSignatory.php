<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TravelOrderSignatory extends Model
{
    protected $fillable = [
        'travel_order_id',
        'employee_id',
        'user_type_id',
        'is_signed',
        'signed_at',
        'signature_path',
    ];

    protected $casts = [
        'is_signed' => 'boolean',
        'signed_at' => 'datetime',
    ];

    public function travelOrder(): BelongsTo
    {
        return $this->belongsTo(TravelOrder::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function userType(): BelongsTo
    {
        return $this->belongsTo(TravelOrderUserType::class, 'user_type_id');
    }
}
