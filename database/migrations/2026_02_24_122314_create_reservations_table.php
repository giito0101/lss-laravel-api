<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('owner_id');
            $table->ulid('skill_id');
            $table->dateTime('date');
            $table->string('status')->default('PENDING'); // PENDING/CONFIRMED/CANCELED
            $table->text('message')->nullable();
            $table->timestamps();

            $table->foreign('skill_id')->references('id')->on('skills')->cascadeOnDelete();
            $table->index(['skill_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};