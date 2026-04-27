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
        if (!Schema::hasColumn('promotion_plan', 'is_active')) {
            Schema::table('promotion_plan', function (Blueprint $table) {
                $table->boolean('is_active')->default(true)->after('is_locked');
            });
        }

        if (!Schema::hasColumn('assessment_session', 'is_active')) {
            Schema::table('assessment_session', function (Blueprint $table) {
                $table->boolean('is_active')->default(true)->after('user_id_talent');
            });
        }

        if (!Schema::hasColumn('idp_activity', 'is_active')) {
            Schema::table('idp_activity', function (Blueprint $table) {
                $table->boolean('is_active')->default(true)->after('status');
            });
        }

        if (!Schema::hasColumn('improvement_project', 'is_active')) {
            Schema::table('improvement_project', function (Blueprint $table) {
                $table->boolean('is_active')->default(true)->after('status');
            });
        }

        if (!Schema::hasColumn('panelis_assessments', 'is_active')) {
            Schema::table('panelis_assessments', function (Blueprint $table) {
                $table->boolean('is_active')->default(true);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promotion_plan', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });

        Schema::table('assessment_session', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });

        Schema::table('idp_activity', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });

        Schema::table('improvement_project', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });

        Schema::table('panelis_assessments', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
};
