<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('advertisement_id')->constrained()->onDelete('cascade');
            $table->text('notes')->nullable();
            $table->enum('priority', ['high', 'medium', 'low'])->default('medium');
            $table->unique(['user_id', 'advertisement_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
