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

    public function role_permissions()
    {
        return $this->hasMany(RolePermission::class);
    }
}
