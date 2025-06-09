<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        User::create([
            'fname'                 => 'System',
            'lname'                 => 'Admin',
            'gender'                => 'not_specified',
            'email'                 => "admin@example.com",
            'password'              => bcrypt('@default_123'),
            'email_verified_at'     => now(),
        ]);
       
    }
}
