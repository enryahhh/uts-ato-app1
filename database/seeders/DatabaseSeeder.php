<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Facades\Hash;

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
                ->unverified()
                ->state(new Sequence(
                    ['role' => 'admin','username'=>'admin','password'=>Hash::make('admin')],
                    ['role' => 'kasir','username'=>'kasir','password'=>Hash::make('kasir')],
                ))
                ->create();
    }
}
