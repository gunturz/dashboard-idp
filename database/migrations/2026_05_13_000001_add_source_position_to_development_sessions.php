<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('development_sessions')) {
            return;
        }

        if (!Schema::hasColumn('development_sessions', 'source_position_id')) {
            Schema::table('development_sessions', function (Blueprint $table) {
                $table->foreignId('source_position_id')
                    ->nullable()
                    ->after('user_id_talent')
                    ->constrained('position')
                    ->nullOnDelete();
            });
        }

        $sessions = DB::table('development_sessions as ds')
            ->leftJoin('promotion_plan as pp', 'pp.development_session_id', '=', 'ds.id')
            ->leftJoin('users as u', 'u.id', '=', 'ds.user_id_talent')
            ->leftJoin('position as tp', 'tp.id', '=', 'ds.target_position_id')
            ->whereNull('ds.source_position_id')
            ->select(
                'ds.id',
                'ds.target_position_id',
                'ds.status',
                'u.position_id as current_position_id',
                'tp.position_name as target_position_name'
            )
            ->get();

        foreach ($sessions as $session) {
            $sourcePositionId = $session->current_position_id;

            if (
                in_array($session->status, ['Promoted', 'Ready Now'], true)
                && (int) $session->current_position_id === (int) $session->target_position_id
            ) {
                $sourcePositionId = $this->inferPreviousPositionId($session->target_position_name)
                    ?? $session->current_position_id;
            }

            DB::table('development_sessions')
                ->where('id', $session->id)
                ->update(['source_position_id' => $sourcePositionId]);
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('development_sessions') || !Schema::hasColumn('development_sessions', 'source_position_id')) {
            return;
        }

        Schema::table('development_sessions', function (Blueprint $table) {
            $table->dropConstrainedForeignId('source_position_id');
        });
    }

    private function inferPreviousPositionId(?string $targetPositionName): ?int
    {
        $target = $this->normalizePositionName($targetPositionName);

        $sourceNames = match ($target) {
            'supervisor', 'officer' => ['staff'],
            'manager' => ['supervisor', 'officer'],
            'general manager' => ['manager'],
            default => [],
        };

        if (empty($sourceNames)) {
            return null;
        }

        return DB::table('position')
            ->get(['id', 'position_name', 'grade_level'])
            ->filter(fn($position) => in_array($this->normalizePositionName($position->position_name), $sourceNames, true))
            ->sortByDesc('grade_level')
            ->first()
            ?->id;
    }

    private function normalizePositionName(?string $name): string
    {
        $name = strtolower(trim((string) $name));
        $name = str_replace(['mgr', 'manajer', 'manager'], 'manager', $name);
        $name = str_replace(['gm', 'general manager'], 'general manager', $name);
        return preg_replace('/\s+/', ' ', $name);
    }
};
