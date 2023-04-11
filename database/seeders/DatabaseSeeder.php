<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create(attributes: [
            'name' => 'Admin',
            'email' => 'admin@app.com',
            'password' => bcrypt('123456789')
        ]);

        $this->call(class: [TagSeeder::class]);

    }
}
