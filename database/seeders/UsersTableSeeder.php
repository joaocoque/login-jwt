<?php

namespace Database\Seeders;

use App\Models\Auth\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $coque = User::create([
            'name' => 'João Victor Pinheiro',
            'email' => 'joaocoque@gmail.com',
            'password' => bcrypt('12345678'),
            'email_verified_at'=> now(),
        ]);

        $coque->assignRole('api');

        $emille = User::create([
            'name' => 'Emille Martins Costa',
            'email' => 'emillemcosta@gmail.com',
            'password' => bcrypt('12345678'),
            'email_verified_at'=> now(),
        ]);

        $emille->assignRole('api');


    }

}
