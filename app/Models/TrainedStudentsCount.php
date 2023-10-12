<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class TrainedStudentsCount extends Model
{
    //
    use SoftDeletes;
protected $table = 'trained_students_count';
}
