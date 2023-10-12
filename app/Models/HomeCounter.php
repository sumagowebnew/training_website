<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class HomeCounter extends Model
{
    //
    use SoftDeletes;
protected $table = 'home_counter';
}
