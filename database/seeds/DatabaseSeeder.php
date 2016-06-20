<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Permission;
use App\Role;
use App\Owner;
use App\IpRange;

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
        $this->call(OwnersTableSeeder::class);
        $this->call(IpRangesTableSeeder::class);
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

class OwnersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('owners')->delete();

        $admin_role = Owner::create([
                'name'          => 'Default',
                'description'   => 'Default IP owner',
        ]);
    }
}


class IpRangesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ip_ranges')->delete();

        $default_owner = Owner::where('name', 'Default')->first();

        $ip_range = IpRange::create([
            'network'       => '192.168.0.0',
            'cidr'          => '24',
            'ip_version'    => '4',
            'owner_id'      => $default_owner->id,
        ]);
    }
}
