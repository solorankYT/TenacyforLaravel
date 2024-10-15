<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    use HasRoles;
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'institution', 
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
                $builder->where('institution', $institution->institution); 
            }
        });
    }
    
    public function hasAnyRole($roles)
    {
        return $this->roles()->whereIn('name', $roles)->exists();
    }
}