<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use HasFactory;
class Funatwork extends Model
{
    //
    
    use SoftDeletes;
    protected $table = 'funatworkcategory';
}
