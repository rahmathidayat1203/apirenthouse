<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Codes extends Model
{
    protected $fillable = [
        'code_activate',
        'user_email',
        'expired'
    ];
}
