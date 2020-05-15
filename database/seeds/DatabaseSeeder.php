<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\User;
use App\Roles;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);

        $this->createUser();
        $this->createRole();
        
    }

    public function createUser(){
        User::insert([
            [
                'name' => "Khenneth Alaiza",
                'email' => "khenneth.alaiza@gmail.com",
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role_id' => 1,
                'remember_token' => Str::random(10),
                'api_token' => Str::random(60),
            ]
        ]);
    }

    public function createRole(){
        Roles::insert([
            [
                'name' => "Administrator",
                'Description' => "Super User",
            ],
            [
                'name' => "User",
                'Description' => "Can add expenses"
            ]
        ]);
    }
}
