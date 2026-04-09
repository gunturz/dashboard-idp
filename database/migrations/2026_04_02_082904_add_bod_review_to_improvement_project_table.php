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
        Schema::table('improvement_project', function (Blueprint $table) {
            $table->integer('bod_score')->nullable();
            $table->json('bod_scores_json')->nullable();
            $table->text('bod_komentar')->nullable();
            $table->text('bod_rekomendasi')->nullable();
            $table->string('bod_dinilai_oleh')->nullable();
            $table->date('bod_tanggal_penilaian')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('improvement_project', function (Blueprint $table) {
            $cols = ['bod_score', 'bod_scores_json', 'bod_komentar', 'bod_rekomendasi', 'bod_dinilai_oleh', 'bod_tanggal_penilaian'];
            foreach ($cols as $col) {
                if (Schema::hasColumn('improvement_project', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
