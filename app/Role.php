<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    public function role_permissions()
    {
        return $this->hasMany(RolePermission::class);
    }

    public function roles()
    {
        return $this->HasMany(Permission::class);
    }

    public function assign_permissions($permissions = [])
    {
        foreach ($permissions as $permission) {
            $this->role_permissions()->create([
                'permission_id'     => $permission->id,
                'role_id'           => $this->id,
            ]);
        }
    }
}
