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
        \App\Models\User::factory()
                ->count(1)
                ->unverified()
                ->state(new Sequence(
                    ['username'=>'admin','password'=>Hash::make('admin')],
                ))
                ->create();
    }
}
