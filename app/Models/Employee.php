<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'age',
        'gender',
        'address',
        'contact_num',
        'birthdate',
        'date_hired',
        'position_id',
        'div_sec_unit_id',
        'employment_status_id',
    ];

    protected $dates = [
        'birthdate',
        'date_hired',
    ];

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function divSecUnit(): BelongsTo
    {
        return $this->belongsTo(DivSecUnit::class, 'div_sec_unit_id');
    }

    public function employmentStatus(): BelongsTo
    {
        return $this->belongsTo(EmploymentStatus::class);
    }

    public function travelOrders(): HasMany
    {
        return $this->hasMany(TravelOrder::class);
    }
    
    /**
     * Get the user associated with the employee.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getFullNameAttribute(): string
    {
        $name = "{$this->first_name} ";
        if ($this->middle_name) {
            $name .= "{$this->middle_name} ";
        }
        $name .= $this->last_name;
        if ($this->suffix) {
            $name .= " {$this->suffix}";
        }
        return $name;
    }
}
