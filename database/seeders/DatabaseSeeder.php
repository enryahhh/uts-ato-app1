<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory()->create();
        \App\Models\User::factory()
                ->count(2)
                ->state(new Sequence(
                    ['role' => 'kasir','email'=>'kasir@email.com'],
                    ['role' => 'admin','email'=>'admin@email.com'],
                ))
                ->create();
    }
}
