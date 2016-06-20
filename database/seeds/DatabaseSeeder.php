<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Permission;
use App\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionsTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        $user = User::create([
            'name'      => 'IPPI Admin',
            'email'     => 'admin@localhost.null',
            'password'  => bcrypt('ippiadmin'),
        ]);

        $roles = Role::where('name', 'Administrator')
            ->get();
        $user->assign_role($roles);
    }
}

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->delete();

        foreach ([
            'ip_range_edit','ip_range_create','ip_range_delete',
            'ip_owner_edit','ip_owner_create','ip_owner_delete',
            'user_edit','user_create','user_delete'] as $permission_name) {

            Permission::create([
                'name'      => $permission_name,
            ]);
        };
    }
}

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();

        $admin_role = Role::create([
                'name'          => 'Administrator',
                'description'   => 'IPPI Administrator Role',
        ]);

        $permissions = Permission::all();
        $admin_role->assign_permissions($permissions);
    }
}
