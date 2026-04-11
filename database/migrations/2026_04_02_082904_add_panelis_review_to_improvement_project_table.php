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
            $table->integer('panelis_score')->nullable();
            $table->json('panelis_scores_json')->nullable();
            $table->text('panelis_komentar')->nullable();
            $table->text('panelis_rekomendasi')->nullable();
            $table->string('panelis_dinilai_oleh')->nullable();
            $table->date('panelis_tanggal_penilaian')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('improvement_project', function (Blueprint $table) {
            $cols = ['panelis_score', 'panelis_scores_json', 'panelis_komentar', 'panelis_rekomendasi', 'panelis_dinilai_oleh', 'panelis_tanggal_penilaian'];
            foreach ($cols as $col) {
                if (Schema::hasColumn('improvement_project', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
