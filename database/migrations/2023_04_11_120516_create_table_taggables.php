<?php

use App\Models\Resource;
use App\Models\Tag;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('taggables', function (Blueprint $table) {
            $table->id();
            $table->morphs('taggable');
            $table->foreignIdFor(Tag::class, 'tag_id')
                ->constrained()
                ->CascadeonDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('taggables');
    }
};
