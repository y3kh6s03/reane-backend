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
        if (!Schema::hasTable('reaches')) {
            Schema::create('reaches', function (Blueprint $table) {
                $table->id();
                $table->string('name', 255);
                $table->string('user_email', 255);
                $table->string('user_name', 255);
                $table->text('user_image');
                $table->unsignedInteger('total_views')->default(0);
                $table->unsignedInteger('total_citations')->default(0);
                $table->timestamps();
                $table->unique(['user_email', 'name']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reaches');
    }
};
