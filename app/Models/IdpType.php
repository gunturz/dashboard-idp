<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IdpType extends Model
{
    use SoftDeletes;
    protected $table = 'idp_type';
    protected $fillable = ['type_name'];
}
