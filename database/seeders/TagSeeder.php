<?php

namespace Database\Seeders;

use App\Models\Resource;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::factory(count: 10)
            ->hasAttached(factory: Resource::factory())
            ->create();
    }
}
