<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['employer', 'worker']);
            $table->string('title');
            $table->text('description');
            $table->string('slug')->default('');
            $table->json('skills')->nullable();
            $table->string('experience')->nullable();
            // Campos específicos para anuncios de empleador
            $table->string('schedule')->nullable();
            $table->string('contract_type')->nullable();
            $table->decimal('salary', 10, 2)->nullable();
            // Campos específicos para anuncios de trabajador
            $table->string('availability')->nullable();
            $table->decimal('salary_expectation', 10, 2)->nullable();
            // Campos comunes
            $table->string('location');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('advertisements');
    }
};
