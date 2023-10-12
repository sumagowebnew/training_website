<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class PopularCoursesDetails extends Model
{
    //
    use SoftDeletes;
protected $table = 'popularcourses_details';
}
