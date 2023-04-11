<?php

use App\Models\Resource;
use App\Models\Tag;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('resource_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Resource::class, 'resource_id')
                ->constrained()
                ->CascadeonDelete();
            $table->foreignIdFor(Tag::class, 'tag_id')
                ->constrained()
                ->CascadeonDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('resource_tag');
    }
};
