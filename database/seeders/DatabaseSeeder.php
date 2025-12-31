<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Project;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->withoutTwoFactor()->create([
            'email' => 'demo@example.com',
        ]);

        $project = Project::factory()
            ->for($user, 'owner')
            ->hasTasks(3)
            ->create();
    }
}
