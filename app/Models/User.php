<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'password',
        'is_admin',
        'employee_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
        'is_admin' => 'boolean',
    ];

    /**
     * Get the employee associated with the user.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class)->withDefault();
    }
    
    /**
     * The "booting" method of the model.
     */
    protected static function booted()
    {
        static::creating(function ($user) {
            if ($user->employee_id && User::where('employee_id', $user->employee_id)->exists()) {
                throw new \Exception('This employee already has a user account.');
            }
        });
        
        static::updating(function ($user) {
            if ($user->isDirty('employee_id') && $user->employee_id && 
                User::where('employee_id', $user->employee_id)
                    ->where('id', '!=', $user->id)
                    ->exists()) {
                throw new \Exception('This employee already has a user account.');
            }
        });
    }

    /**
     * Get the username for the user.
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }
}
