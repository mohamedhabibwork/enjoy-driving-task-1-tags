<?php

namespace App\Models\Traits;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait Taggables
{
    public function tags(): MorphToMany
    {
        return $this->morphToMany(related: Tag::class, name:'taggable')
            ->withTimestamps(
                createdAt: 'created_at',
                updatedAt: 'updated_at'
            );
    }
}
