<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    //
    protected $table = 'mentor';
    protected $casts = [
        'course_id' => 'array'
    ];
}
