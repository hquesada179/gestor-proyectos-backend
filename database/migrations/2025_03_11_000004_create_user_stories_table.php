<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_stories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('requirement_id')->constrained('requirements')->onDelete('cascade');
            $table->string('titulo');
            $table->text('como_usuario')->nullable();
            $table->text('quiero')->nullable();
            $table->text('para_poder')->nullable();
            $table->text('criterios_aceptacion')->nullable();
            $table->string('prioridad')->default('media');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_stories');
    }
};
