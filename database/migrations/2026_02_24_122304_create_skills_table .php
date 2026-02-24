<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('owner_id'); // 認証導入後にusers.idへFKでもOK
            $table->string('title');
            $table->text('description');
            $table->integer('price');
            $table->string('category'); // enum化は後でOK
            $table->string('area');
            $table->string('image_url')->nullable();
            $table->timestamps();
            $table->index(['category', 'area']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};