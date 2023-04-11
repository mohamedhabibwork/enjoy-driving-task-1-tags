<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function resources(): MorphToMany
    {
        return $this->morphedByMany(related: Resource::class, name: 'taggable')
            ->withTimestamps();
    }

    public function tags(): MorphToMany
    {
        return $this->morphedByMany(related: Tag::class, name: 'taggable')
            ->withTimestamps();
    }

    public function posts(): MorphToMany
    {
        return $this->morphedByMany(related: Post::class, name: 'taggable')
            ->withTimestamps();
    }
}
