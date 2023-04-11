<?php

namespace Database\Seeders;

use App\Models\Post;
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
        $count = 10;
        Tag::factory(count: $count)
            ->hasAttached(factory: Resource::factory($count)->hasAttached(
                factory: Tag::factory(),
                relationship: 'tags'
            ),relationship: 'resources')
            ->hasAttached(factory: Tag::factory($count),relationship: 'tags')
            ->hasAttached(factory: Post::factory($count)->hasAttached(
                factory: Tag::factory(),
                relationship: 'tags'
            ),relationship: 'posts')
            ->create();
    }
}
