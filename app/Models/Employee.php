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
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    /**
     * The "booting" method of the model.
     */
    protected static function booted()
    {
        static::updating(function ($employee) {
            if ($employee->isDirty('user_id')) {
                $originalUserId = $employee->getOriginal('user_id');
                $newUserId = $employee->user_id;
                
                // If user_id is being set to null, remove the user_id from the user
                if ($originalUserId && $newUserId === null) {
                    User::where('id', $originalUserId)->update(['employee_id' => null]);
                }
                
                // If user_id is being changed to a new user, update the relationship
                if ($newUserId) {
                    // Remove the employee_id from the previous user if it exists
                    if ($originalUserId) {
                        User::where('id', $originalUserId)->update(['employee_id' => null]);
                    }
                    // Set the new user's employee_id
                    User::where('id', $newUserId)->update(['employee_id' => $employee->id]);
                }
            }
        });
        
        static::deleting(function ($employee) {
            // When an employee is deleted, remove their user_id from the users table
            if ($employee->user_id) {
                User::where('id', $employee->user_id)->update(['employee_id' => null]);
            }
        });
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
