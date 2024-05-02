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

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $user->todos()->createMany([
            ['name' => 'First todo', 'position' => 0,],
            ['name' => 'Second todo', 'position' => 1,],
            ['name' => 'Third todo', 'position' => 2,]
        ]);
    }
}
