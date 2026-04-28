<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Competence;
use App\Models\Position;
use App\Models\PositionTargetCompetence;
use App\Models\Question;
use Illuminate\Support\Facades\DB;

class PdcAdminKompetensiManager extends Component
{
    public $topTab = 'questions'; // 'questions', 'target'
    public $subTabQuestion = 'core'; // 'core', 'managerial'
    public $activePositionId = null;
    public $scrollToCompetenceId = null;
    public $scrollToTargetSection = null;

    // Untuk edit mode (Questions)
    public $editingCompetenceId = null;
    public $editingQuestions = []; // [level => text]

    // Untuk edit mode (Target Score)
    public $editingTargetScoreMode = false;
    public $editingTargetScores = []; // [competence_id => target_level]

    public function mount()
    {
        $firstPos = Position::whereNotIn('position_name', ['Super Admin', 'panelis'])->orderBy('grade_level')->first();
        if ($firstPos) {
            $this->activePositionId = $firstPos->id;
        }
    }

    public function setTopTab($tab)
    {
        $this->topTab = $tab;
        $this->cancelEdit();
    }

    public function setSubTabQuestion($tab)
    {
        $this->subTabQuestion = $tab;
        $this->cancelEdit();
    }

    public function setActivePosition($id)
    {
        $this->activePositionId = $id;
        $this->cancelEdit();
    }

    public function cancelEdit()
    {
        $this->editingCompetenceId = null;
        $this->editingQuestions = [];
        $this->editingTargetScoreMode = false;
        $this->editingTargetScores = [];
    }

    // --- LOGIC QUESTIONS ---
    public function editQuestions($compId)
    {
        $this->editingCompetenceId = $compId;
        $this->scrollToCompetenceId = $compId;
        // Load existing questions
        $comp = Competence::with('questions')->find($compId);
        $this->editingQuestions = [];
        for ($i = 1; $i <= 5; $i++) {
            $q = $comp->questions->firstWhere('level', $i);
            $this->editingQuestions[$i] = $q ? $q->question_text : '';
        }

        $this->dispatch('scroll-to-competence', competenceId: $compId);
    }

    public function saveQuestions()
    {
        foreach ($this->editingQuestions as $lvl => $text) {
            $q = Question::where('competence_id', $this->editingCompetenceId)
                ->where('level', $lvl)
                ->first();

            if ($q && $text) {
                $q->update(['question_text' => $text]);
            }
            elseif ($q && !$text) {
                // If text is emptied, delete Question
                $q->delete();
            }
            elseif (!$q && $text) {
                Question::create([
                    'competence_id' => $this->editingCompetenceId,
                    'level' => $lvl,
                    'question_text' => $text
                ]);
            }
        }
        $this->cancelEdit();
        session()->flash('success_top', 'Pertanyaan kompetensi berhasil diperbarui!');
    }

    // --- LOGIC TARGET SCORE ---
    public function editTargetScore($section = 'core')
    {
        $this->editingTargetScoreMode = true;
        $this->scrollToTargetSection = $section;

        $competencies = Competence::pluck('id');
        $targets = PositionTargetCompetence::where('position_id', $this->activePositionId)
            ->pluck('target_level', 'competence_id');

        $this->editingTargetScores = [];
        foreach ($competencies as $competenceId) {
            $this->editingTargetScores[$competenceId] = isset($targets[$competenceId])
                ? (int) $targets[$competenceId]
                : null;
        }

        $this->dispatch('scroll-to-target-section', section: $section);
    }

    public function saveTargetScores()
    {
        foreach ($this->editingTargetScores as $compId => $level) {
            if ($level) {
                PositionTargetCompetence::updateOrCreate(
                ['position_id' => $this->activePositionId, 'competence_id' => $compId],
                ['target_level' => (int)$level]
                );
            }
        }
        $this->cancelEdit();
        session()->flash('success_top', 'Target Score Posisi berhasil diperbarui!');
    }

    public function render()
    {
        // View Optimization!
        // We only load what's active.
        $coreCompetencies = collect();
        $managerialCompetencies = collect();
        $positions = collect();

        $targetScoresLookup = collect();

        if ($this->topTab === 'questions') {
            if ($this->subTabQuestion === 'core') {
                $coreCompetencies = Competence::with('questions')->whereBetween('id', [1, 5])->get();
            }
            else {
                $managerialCompetencies = Competence::with('questions')->where('id', '>', 5)->get();
            }
        }
        else {
            // Target Scorse Top Tab
            $coreCompetencies = Competence::whereBetween('id', [1, 5])->get();
            $managerialCompetencies = Competence::where('id', '>', 5)->get();
            $positions = Position::whereNotIn('position_name', ['Super Admin', 'panelis'])->orderBy('grade_level')->get();

            // Only load details for active Position
            if ($this->activePositionId) {
                $targetScoresLookup = collect(PositionTargetCompetence::where('position_id', $this->activePositionId)
                    ->pluck('target_level', 'competence_id'));
            }
        }

        return view('livewire.pdc-admin-kompetensi-manager', compact(
            'coreCompetencies',
            'managerialCompetencies',
            'positions',
            'targetScoresLookup'
        ));
    }
}
