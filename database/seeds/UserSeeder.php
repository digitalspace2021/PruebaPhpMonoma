<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'manager',
            'password' => bcrypt('password'),
            'role' => 'manager',
            'is_active' => true,
        ]);

        User::create([
            'username' => 'agent',
            'password' => bcrypt('password'),
            'role' => 'agent',
            'is_active' => true,
        ]);
    }
}
