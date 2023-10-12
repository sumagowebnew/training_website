<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class OurProgramCities extends Model
{
    //
    use SoftDeletes;
    protected $table = 'our_program_cities';
}
