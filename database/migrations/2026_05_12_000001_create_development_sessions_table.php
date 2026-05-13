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
            Schema::create('development_sessions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id_talent')->constrained('users');
                $table->foreignId('target_position_id')->nullable()->constrained('position')->nullOnDelete();
                $table->foreignId('atasan_id')->nullable()->constrained('users')->nullOnDelete();
                $table->json('mentor_ids')->nullable();
                $table->string('status')->default('In Progress');
                $table->date('start_date')->nullable();
                $table->date('target_date')->nullable();
                $table->timestamp('completed_at')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
                $table->softDeletes();

                $table->index(['user_id_talent', 'is_active']);
                $table->index(['target_position_id', 'is_active']);
            });
        }

        $this->addSessionColumn('promotion_plan', 'target_date');
        $this->addSessionColumn('assessment_session', 'user_id_talent');
        $this->addSessionColumn('idp_activity', 'user_id_talent');
        $this->addSessionColumn('improvement_project', 'user_id_talent');
        $this->addSessionColumn('panelis_assessments', 'user_id_talent');

        $this->backfillSessions();
    }

    public function down(): void
    {
        foreach (['panelis_assessments', 'improvement_project', 'idp_activity', 'assessment_session', 'promotion_plan'] as $table) {
            if (Schema::hasColumn($table, 'development_session_id')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->dropConstrainedForeignId('development_session_id');
                });
            }
        }

        Schema::dropIfExists('development_sessions');
    }

    private function addSessionColumn(string $table, string $after): void
    {
        if (!Schema::hasTable($table) || Schema::hasColumn($table, 'development_session_id')) {
            return;
        }

        Schema::table($table, function (Blueprint $blueprint) use ($after) {
            $blueprint->foreignId('development_session_id')
                ->nullable()
                ->after($after)
                ->constrained('development_sessions')
                ->nullOnDelete();
        });
    }

    private function backfillSessions(): void
    {
        if (!Schema::hasTable('promotion_plan') || !Schema::hasColumn('promotion_plan', 'development_session_id')) {
            return;
        }

        $plans = DB::table('promotion_plan')
            ->whereNull('development_session_id')
            ->orderBy('created_at')
            ->orderBy('id')
            ->get();

        foreach ($plans as $plan) {
            $talent = DB::table('users')->where('id', $plan->user_id_talent)->first();
            $sessionId = DB::table('development_sessions')->insertGetId([
                'user_id_talent' => $plan->user_id_talent,
                'target_position_id' => $plan->target_position_id,
                'atasan_id' => $talent?->atasan_id,
                'mentor_ids' => $plan->mentor_ids,
                'status' => $plan->status_promotion ?? 'In Progress',
                'start_date' => $plan->start_date,
                'target_date' => $plan->target_date,
                'completed_at' => ($plan->is_active ?? true) ? null : ($plan->updated_at ?? now()),
                'is_active' => $plan->is_active ?? true,
                'created_at' => $plan->created_at ?? now(),
                'updated_at' => $plan->updated_at ?? now(),
            ]);

            DB::table('promotion_plan')->where('id', $plan->id)->update([
                'development_session_id' => $sessionId,
            ]);
        }

        foreach (['assessment_session', 'idp_activity', 'improvement_project', 'panelis_assessments'] as $table) {
            if (!Schema::hasColumn($table, 'development_session_id')) {
                continue;
            }

            DB::table($table)
                ->whereNull('development_session_id')
                ->orderBy('created_at')
                ->orderBy('id')
                ->get()
                ->each(function ($row) use ($table) {
                    $session = DB::table('development_sessions')
                        ->where('user_id_talent', $row->user_id_talent)
                        ->where('is_active', $row->is_active ?? true)
                        ->orderByDesc('created_at')
                        ->first()
                        ?? DB::table('development_sessions')
                            ->where('user_id_talent', $row->user_id_talent)
                            ->orderByDesc('created_at')
                            ->first();

                    if ($session) {
                        DB::table($table)->where('id', $row->id)->update([
                            'development_session_id' => $session->id,
                        ]);
                    }
                });
        }
    }
};
