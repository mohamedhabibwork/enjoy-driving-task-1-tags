<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Taggable extends Pivot
{
    protected $table = 'taggables';

    protected $fillable = [
        'tag_id',
        'taggable_id',
        'taggable_type',
    ];

    /**
     * @return BelongsTo|Tag
     */
    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class);
    }

    /**
     * @return MorphTo
     */
    public function taggable(): MorphTo
    {
        return $this->morphTo();
    }
}
