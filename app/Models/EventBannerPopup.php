<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use HasFactory;
class EventBannerPopup extends Model
{
    //
    
    use SoftDeletes;
protected $table = 'event_banner_popup';
}
