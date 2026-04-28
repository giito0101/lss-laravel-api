<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('owner_id');
            $table->unsignedTinyInteger('rating');
            $table->text('comment')->nullable();
            $table->string('skill_id');
            $table->dateTime('created_at');

            $table->foreign('owner_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('skill_id')->references('id')->on('skills')->cascadeOnDelete();
            $table->index('skill_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
