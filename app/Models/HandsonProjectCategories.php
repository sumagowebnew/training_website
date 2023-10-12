<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class HandsonProjectCategories extends Model
{
    //
    use SoftDeletes;
protected $table = 'handson_project_cateories';
}
