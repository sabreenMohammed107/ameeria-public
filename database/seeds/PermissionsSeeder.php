<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$permissions = [
            'logactivities-list',
            
            'roles-list',
            'roles-create',
            'roles-edit',
            'roles-delete',
            
            'users-list',
            'users-create',
            'users-edit',
            'users-delete',

            'units-list',
            'units-create',
            'units-edit',
            'units-delete',

            'cities-list',
            'cities-create',
            'cities-edit',
            'cities-delete',

            'clients-list',
            'clients-create',
            'clients-edit',
            'clients-delete',

            'items-list',
            'items-create',
            'items-edit',
            'items-delete',
            
            'invoices-list',
            'invoices-create',
            'invoices-edit',
            'invoices-delete',

            'invoicesTransfer-list',
            'invoicesTransfer-create',
            'invoicesTransfer-edit',
            'invoicesTransfer-delete',

            'invoicesTypes-list',
            'invoicesTypes-create',
            'invoicesTypes-edit',
            'invoicesTypes-delete',

            'settings-list',
            'settings-create',
            'settings-edit',
            'settings-delete',
        ];

        foreach ($permissions as $permission)
        {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }
    }
}
