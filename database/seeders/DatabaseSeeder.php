<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        if (!User::where('email', 'admin@admin.com')->first()) {
            User::create([
                'email' => 'admin@admin.com',
                'password' => bcrypt('admin@123')
            ]);
        }
        $this->call(MenuSeeder::class);
    }
}
