<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TravelOrder extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'region_id',
        'address',
        'contact_number',
        'email',
        'date',
        'travel_order_no',
        'employee_id',
        'full_name',
        'salary',
        'position',
        'div_sec_unit',
        'departure_date',
        'official_station',
        'destination',
        'arrival_date',
        'purpose_of_travel',
        'per_diem_expenses',
        'assistant_or_laborers_allowed',
        'appropriations',
        'remarks',
        'status_id',
    ];

    protected $dates = [
        'date',
        'departure_date',
        'arrival_date',
        'deleted_at',
    ];

    protected $casts = [
        'assistant_or_laborers_allowed' => 'boolean',
        'per_diem_expenses' => 'decimal:2',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
    
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(TravelOrderStatus::class, 'status_id');
    }

    public function signatories(): HasMany
    {
        return $this->hasMany(TravelOrderSignatory::class);
    }
}
