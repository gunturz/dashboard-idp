<?php

// database/seeders/AssessmentSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssessmentSeeder extends Seeder
{
    public function run(): void
    {
        // Kompetensi Master
        DB::table('competencies')->insert([
            ['id' => 1, 'name' => 'Integrity'],
            ['id' => 2, 'name' => 'Communication'],
            ['id' => 3, 'name' => 'Innovation & Creativity'],
            ['id' => 4, 'name' => 'Customer Orientation'],
            ['id' => 5, 'name' => 'Teamwork'],
            ['id' => 6, 'name' => 'Leadership'],
            ['id' => 7, 'name' => 'Business Acumen'],
            ['id' => 8, 'name' => 'Problem Solving & Decission Making'],
            ['id' => 9, 'name' => 'Acievement Orientation'],
            ['id' => 10, 'name' => 'Strategic Thinking'],
        ]);

        // Assessment Utama
        DB::table('assessment_session')->insert([
            'id' => 1,
            'user_id_talent' => 2,
            'user_id_atasan' => 1,
            'period' => '2026',
        ]);

        // Detail Assessment (Gap Analysis)
        DB::table('detail_assessment')->insert([
            [
                'assessment_id' => 1,
                'competence_id' => 1,
                'score_atasan' => 4,
                'score_talent' => 5,
                'gap_score' => -1.0,
                'notes' => 'Initial assessment notes',
            ]
        ]);

        // Standar Kompetensi per Posisi (Contoh untuk Position 2/Manager)
        DB::table('position_target_competence')->insert([
            ['position_id' => 2, 'competence_id' => 1, 'target_level' => 5],
            ['position_id' => 2, 'competence_id' => 2, 'target_level' => 4],
            ['position_id' => 2, 'competence_id' => 3, 'target_level' => 3],
            ['position_id' => 2, 'competence_id' => 4, 'target_level' => 3],
            ['position_id' => 2, 'competence_id' => 5, 'target_level' => 4],
            ['position_id' => 2, 'competence_id' => 6, 'target_level' => 4],
            ['position_id' => 2, 'competence_id' => 7, 'target_level' => 4],
            ['position_id' => 2, 'competence_id' => 8, 'target_level' => 4],
            ['position_id' => 2, 'competence_id' => 9, 'target_level' => 4],
            ['position_id' => 2, 'competence_id' => 10, 'target_level' => 4],
        ]);
    }
}
