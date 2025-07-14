<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->text('url');
            $table->text('image');
            $table->string('name');
            $table->text('description');
            $table->string('author');
            $table->integer('ratings');
            $table->json('ingredients');
            $table->json('steps');
            $table->json('nutrients')->nullable();
            $table->json('times');
            $table->integer('serves');
            $table->string('difficult');
            $table->integer('vote_count');
            $table->string('subcategory');
            $table->string('dish_type');
            $table->string('maincategory');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
