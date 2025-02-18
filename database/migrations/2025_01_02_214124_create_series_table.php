<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('series', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('type');
            $table->string('status');
            $table->string('author')->nullable();
            $table->timestamps();
            $table->string('cover_image_url')->nullable();
            $table->string('banner_image_url')->nullable();
            $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete();
        });

        Schema::create('favorites', function(Blueprint $table){
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('series_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['user_id', 'series_id']);
        });

        Schema::create('chapters', function(Blueprint $table){
            $table->id();
            $table->integer('order_number');
            $table->string('image_url')->nullable();
            $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('serie_id')->constrained('series')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('images', function(Blueprint $table){
            $table->id();
            $table->integer('order_number');
            $table->string('image_url');
            $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('chapter_id')->constrained('chapters')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('series');
        Schema::dropIfExists('favorites');
        Schema::dropIfExists('chapters');
        Schema::dropIfExists('images');

    }
};
