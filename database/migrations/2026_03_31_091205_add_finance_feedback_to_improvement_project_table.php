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
            // finance_feedback: feedback yang diisi oleh role Finance setelah memvalidasi
            $table->text('finance_feedback')->nullable()->after('feedback');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('improvement_project', function (Blueprint $table) {
            $table->dropColumn('finance_feedback');
        });
    }
};
