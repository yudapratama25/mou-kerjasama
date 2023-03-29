<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            'Akhmad Purwanto' => 'purwanto@gmail.com',
            'Yuda Pratama' => 'yuda@gmail.com'
        ];

        foreach ($users as $name => $email) {
            User::create(['name' => $name, 'email' => $email, 'password' => Hash::make('12345678'), 'role' => 'administrator']);
        }
    }
}
