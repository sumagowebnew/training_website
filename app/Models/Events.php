<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use HasFactory;
class Events extends Model
{
    //
    
    use SoftDeletes;
protected $table = 'events';
}
