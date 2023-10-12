<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use HasFactory;
class CourseCategory extends Model
{
    //
    
    use SoftDeletes;
protected $table = 'coursecategory';
}
