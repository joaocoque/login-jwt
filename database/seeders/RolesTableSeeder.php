<?php

namespace Database\Seeders;

use App\Models\Auth\Permission;
use App\Models\Auth\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Create Root role
         */
        $api = Role::firstOrCreate([
            'name' => 'api',
            'details' => 'api',
            'guard_name' => 'api'
        ]);

        $api->syncPermissions(Permission::all());
    }
}
