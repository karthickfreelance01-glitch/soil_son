<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('mobile', 30);
            $table->string('email', 150)->nullable();
            $table->string('address')->nullable();
            $table->string('service', 120)->nullable();
            $table->text('message')->nullable();
            $table->string('source', 30)->default('contact');   // contact | sidebar
            $table->string('page_url')->nullable();
            $table->string('status', 20)->default('new');       // new | contacted | admitted | closed
            $table->text('notes')->nullable();
            $table->integer('handled_by')->nullable();   // user.id (gh.hms `user` table)
            $table->string('ip', 45)->nullable();
            $table->timestamps();
            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enquiries');
    }
};
