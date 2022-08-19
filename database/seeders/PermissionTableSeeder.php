<?php

namespace Database\Seeders;

use App\Models\Auth\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [

            //Users
            ['name' => 'view_users', 'details' => 'Usuários [view]', 'guard' => 'api'],
            ['name' => 'add_users', 'details' => 'Usuários [add]', 'guard' => 'api'],
            ['name' => 'edit_users', 'details' => 'Usuários [edit]', 'guard' => 'api'],
            ['name' => 'delete_users', 'details' => 'Usuários [delete]', 'guard' => 'api'],

            //Permissions
            ['name' => 'view_permissions', 'details' => 'Permissões [view]', 'guard' => 'api'],
            ['name' => 'add_permissions', 'details' => 'Permissões [add]', 'guard' => 'api'],
            ['name' => 'edit_permissions', 'details' => 'Permissões [edit]', 'guard' => 'api'],
            ['name' => 'delete_permissions', 'details' => 'Permissões [delete]', 'guard' => 'api'],

            //Roles
            ['name' => 'view_roles', 'details' => 'Grupos [view]', 'guard' => 'api'],
            ['name' => 'add_roles', 'details' => 'Grupos [add]', 'guard' => 'api'],
            ['name' => 'edit_roles', 'details' => 'Grupos [edit]', 'guard' => 'api'],
            ['name' => 'delete_roles', 'details' => 'Grupos [delete]', 'guard' => 'api'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name'       => $permission['name'],
                'details'    => $permission['details'],
                'guard_name' => $permission['guard']
            ]);
        }
    }
}
