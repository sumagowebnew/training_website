<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OurOffice extends Model
{
    //
    use SoftDeletes;
    protected $table = 'our_office';
}
