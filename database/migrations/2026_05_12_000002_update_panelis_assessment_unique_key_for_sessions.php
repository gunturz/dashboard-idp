<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('panelis_assessments')) {
            return;
        }

        Schema::table('panelis_assessments', function (Blueprint $table) {
            if (! $this->indexExists('panelis_assessments', 'panelis_assessments_user_id_talent_index')) {
                $table->index('user_id_talent', 'panelis_assessments_user_id_talent_index');
            }

            if (! $this->indexExists('panelis_assessments', 'panelis_assessments_panelis_id_index')) {
                $table->index('panelis_id', 'panelis_assessments_panelis_id_index');
            }
        });

        if ($this->indexExists('panelis_assessments', 'panelis_assessments_user_id_talent_panelis_id_unique')) {
            Schema::table('panelis_assessments', function (Blueprint $table) {
                $table->dropUnique('panelis_assessments_user_id_talent_panelis_id_unique');
            });
        }

        if (
            Schema::hasColumn('panelis_assessments', 'development_session_id')
            && ! $this->indexExists('panelis_assessments', 'panelis_assessments_session_panelis_unique')
        ) {
            Schema::table('panelis_assessments', function (Blueprint $table) {
                $table->unique(
                    ['development_session_id', 'panelis_id'],
                    'panelis_assessments_session_panelis_unique'
                );
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('panelis_assessments')) {
            return;
        }

        if (
            Schema::hasColumn('panelis_assessments', 'development_session_id')
            && $this->indexExists('panelis_assessments', 'panelis_assessments_session_panelis_unique')
        ) {
            Schema::table('panelis_assessments', function (Blueprint $table) {
                $table->dropUnique('panelis_assessments_session_panelis_unique');
            });
        }

        if (! $this->indexExists('panelis_assessments', 'panelis_assessments_user_id_talent_panelis_id_unique')) {
            Schema::table('panelis_assessments', function (Blueprint $table) {
                $table->unique(['user_id_talent', 'panelis_id']);
            });
        }
    }

    private function indexExists(string $table, string $index): bool
    {
        $database = DB::getDatabaseName();

        return ! empty(DB::select(
            'select 1 from information_schema.statistics where table_schema = ? and table_name = ? and index_name = ? limit 1',
            [$database, $table, $index]
        ));
    }
};
