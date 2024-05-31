<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BootcampApplyNow extends Model
{
    use SoftDeletes;
    protected $table = 'bootcamp_apply_now';
}
