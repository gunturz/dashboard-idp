<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdpType extends Model
{
    protected $table = 'idp_type';
    protected $fillable = ['type_name'];
}
