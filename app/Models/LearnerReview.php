<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class LearnerReview extends Model
{
    //
    use SoftDeletes;
protected $table = 'learner_review';
}
