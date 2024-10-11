<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'institution', // This should be included
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function institution()
{
    return $this->belongsTo(Institution::class);
}

    protected static function booted()
    {
        static::addGlobalScope('institution', function (Builder $builder) {
            $institution = request()->attributes->get('institution');
    
            if ($institution) {
                // Assuming 'institution' is the name of the field in the users table
                $builder->where('institution', $institution->institution); 
            }
        });
    }
    
}
