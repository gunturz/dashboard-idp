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
        Schema::create('panelis_assessments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id_talent');
            $table->unsignedBigInteger('panelis_id');
            $table->integer('panelis_score')->nullable();
            $table->json('panelis_scores_json')->nullable();
            $table->text('panelis_komentar')->nullable();
            $table->text('panelis_rekomendasi')->nullable();
            $table->date('panelis_tanggal_penilaian')->nullable();
            $table->timestamps();

            $table->foreign('user_id_talent')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('panelis_id')->references('id')->on('users')->onDelete('cascade');

            // Satu panelis hanya bisa menilai satu talent satu kali
            $table->unique(['user_id_talent', 'panelis_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('panelis_assessments');
    }
};
