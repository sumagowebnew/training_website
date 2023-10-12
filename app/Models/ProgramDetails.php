<?php

namespace App\Models;
use HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ProgramDetails extends Model
{
    //
    use SoftDeletes;
    protected $table = 'programdetails';
}
