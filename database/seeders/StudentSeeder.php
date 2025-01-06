<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Import the User model

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create student records
        User::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => bcrypt('password123'),
            'role' => 'student',
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'janesmith@example.com',
            'password' => bcrypt('password123'),
            'role' => 'student',
        ]);

        User::create([
            'name' => 'Alice Johnson',
            'email' => 'alicejohnson@example.com',
            'password' => bcrypt('password123'),
            'role' => 'student',
        ]);
    }
}
