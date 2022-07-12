<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //protected table fill
    protected $fillable = [
        'name',
        'address',
        'jobs',
        'email',
        'password',
        'gender',
        'age',
        'no_telp',
        'parents_name',
        'parents_no_telp',
        'photo'
    ];
}
