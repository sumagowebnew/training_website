<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mentor extends Model
{
    //
    use SoftDeletes;
protected $table = 'mentor';
    protected $casts = [
        'course_id' => 'array'
    ];
}
