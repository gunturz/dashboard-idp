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
        Schema::create('kandidat_kompetensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('integrity')->nullable();
            $table->integer('communication')->nullable();
            $table->integer('innovation_creativity')->nullable();
            $table->integer('customer_orientation')->nullable();
            $table->integer('teamwork')->nullable();
            $table->integer('leadership')->nullable();
            $table->integer('business_acumen')->nullable();
            $table->integer('problem_solving')->nullable();
            $table->integer('achievement_orientation')->nullable();
            $table->integer('strategic_thinking')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kandidat_kompetensi');
    }
};
