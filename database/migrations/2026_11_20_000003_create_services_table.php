<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150);
            $table->string('slug', 160)->unique();
            $table->string('icon', 60)->nullable();          // Font Awesome class, e.g. fa-hand-holding-heart
            $table->string('image')->nullable();             // path relative to public/
            $table->string('short_description', 300)->nullable();
            $table->longText('content')->nullable();
            $table->string('link_url')->nullable();          // optional: an existing page, e.g. /de-addiction
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 320)->nullable();
            $table->string('meta_keywords')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
