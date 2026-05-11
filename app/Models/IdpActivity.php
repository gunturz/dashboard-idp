<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IdpActivity extends Model
{
    use SoftDeletes;
    protected $table = 'idp_activity';

    protected $fillable = [
        'user_id_talent',
        'type_idp',
        'verify_by',
        'theme',
        'activity_date',
        'location',
        'activity',
        'description',
        'action_plan',
        'document_path',
        'file_name',
        'status',
        'platform',
    ];

    public function type()
    {
        return $this->belongsTo(IdpType::class, 'type_idp');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verify_by');
    }

    public function talent()
    {
        return $this->belongsTo(User::class, 'user_id_talent');
    }
}
