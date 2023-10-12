<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use HasFactory;
class NextCohortsDates extends Model
{
    //
    
    use SoftDeletes;
    protected $table = 'next_cohorts_dates';
}
