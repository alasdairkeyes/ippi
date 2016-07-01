<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function userRoles()
    {
        return $this->HasMany(UserRole::class);
    }


    public function assignRole($roles = [])
    {
        foreach ($roles as $role) {
            $this->user_roles()->create([
                'user_id'     => $this->id,
                'role_id'     => $role->id,
            ]);
        };
    }
}
