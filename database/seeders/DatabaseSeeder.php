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

        auth()->login($user);

        [$list_1, $list_2] = $user->cards()->createMany([
            ['name' => 'First List'],
            ['name' => 'Second List'],
        ]);

        $list_1->todos()->createMany([
            ['name' => 'First Task'],
            ['name' => 'Second Task'],
        ]);

        $list_2->todos()->createMany([
            ['name' => 'Third Task'],
            ['name' => 'Fourth Task'],
        ]);
    }
}
