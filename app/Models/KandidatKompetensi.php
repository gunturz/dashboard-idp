<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KandidatKompetensi extends Model
{
    protected $table = 'kandidat_kompetensi';

    protected $fillable = [
        'user_id',
        'integrity',
        'communication',
        'innovation_creativity',
        'customer_orientation',
        'teamwork',
        'leadership',
        'business_acumen',
        'problem_solving',
        'achievement_orientation',
        'strategic_thinking',
    ];

    protected $casts = [
        'integrity'               => 'integer',
        'communication'           => 'integer',
        'innovation_creativity'   => 'integer',
        'customer_orientation'    => 'integer',
        'teamwork'                => 'integer',
        'leadership'              => 'integer',
        'business_acumen'         => 'integer',
        'problem_solving'         => 'integer',
        'achievement_orientation' => 'integer',
        'strategic_thinking'      => 'integer',
    ];

    /**
     * Label tampilan untuk tiap kolom kompetensi.
     */
    public static function labels(): array
    {
        return [
            'integrity'               => 'Integrity',
            'communication'           => 'Communication',
            'innovation_creativity'   => 'Innovation & Creativity',
            'customer_orientation'    => 'Customer Orientation',
            'teamwork'                => 'Teamwork',
            'leadership'              => 'Leadership',
            'business_acumen'         => 'Business Acumen',
            'problem_solving'         => 'Problem Solving & Decision Making',
            'achievement_orientation' => 'Achievement Orientation',
            'strategic_thinking'      => 'Strategic Thinking',
        ];
    }

    /**
     * Opsi level kompetensi.
     */
    public static function levels(): array
    {
        return [
            1 => '1',
            2 => '2',
            3 => '3',
            4 => '4',
            5 => '5',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
