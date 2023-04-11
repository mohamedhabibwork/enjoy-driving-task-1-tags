<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * @return BelongsToMany|Resource[]
     */
    public function resources(): BelongsToMany
    {
        return $this->belongsToMany(
            related: Resource::class,
            table: 'resource_tag',
            foreignPivotKey: 'tag_id',
            relatedPivotKey: 'resource_id'
        )->withTimestamps();
    }
}
