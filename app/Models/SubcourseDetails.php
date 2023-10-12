<?php

namespace App\Models;
use HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class SubcourseDetails extends Model
{
    //
    use SoftDeletes;
protected $table = 'sub_course_details';
}
