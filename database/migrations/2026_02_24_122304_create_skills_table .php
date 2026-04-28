<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('owner_id');
            $table->string('title');
            $table->text('description');
            $table->integer('price');
            $table->string('category');
            $table->string('area');
            $table->string('image_url')->nullable();
            $table->timestamps();

            $table->foreign('owner_id')->references('id')->on('users')->cascadeOnDelete();
            $table->index(['category', 'area']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};
