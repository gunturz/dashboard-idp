<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kandidat_kompetensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // 10 Kompetensi — skala 1 (Sangat Kurang) s/d 5 (Sangat Baik)
            $table->tinyInteger('integrity')->nullable();
            $table->tinyInteger('communication')->nullable();
            $table->tinyInteger('innovation_creativity')->nullable();
            $table->tinyInteger('customer_orientation')->nullable();
            $table->tinyInteger('teamwork')->nullable();
            $table->tinyInteger('leadership')->nullable();
            $table->tinyInteger('business_acumen')->nullable();
            $table->tinyInteger('problem_solving')->nullable();
            $table->tinyInteger('achievement_orientation')->nullable();
            $table->tinyInteger('strategic_thinking')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kandidat_kompetensi');
    }
};
