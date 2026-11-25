<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seo_pages', function (Blueprint $table) {
            $table->id();
            $table->string('page_key', 60)->unique();        // home, about, contact, services, gallery...
            $table->string('page_name', 100);
            $table->string('path', 150);
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 320)->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('og_image')->nullable();
            $table->boolean('noindex')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_pages');
    }
};
