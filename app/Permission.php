<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{

    /**
     * Attributes
     *
     * @var array
     */

    public $timestamps = false;

    public function rolePermissions()
    {
        return $this->hasMany(RolePermission::class);
    }
}
