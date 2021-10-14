<?php

use Illuminate\Database\Seeder;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'f_name' => 'Admin',
            'l_name' => 'Account',
            'email' => 'admin@system.com',
            'username' => 'admin',
            'phone' => '01093347242',
        	'password' => Hash::make('12345678'),
            'status' => 1,
            'avatar' => 'avatar.jpg',
        ]);

        $role = Role::create(['name' => 'مدير النظام', 'guard_name' => 'web']);
        $permissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($permissions);
        $admin->assignRole([$role->id]);
    }
}
