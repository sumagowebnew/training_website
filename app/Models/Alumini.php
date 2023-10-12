<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alumini extends Model
{
    use SoftDeletes;
    protected $table = 'alumini';
}
