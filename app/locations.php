<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class locations extends Model
{

    use Notifiable;
    use SoftDeletes;

    protected $table = 'location_details';

    protected $fillable = [
        'location_name', 'latitude','longitude','description','audio_file','video_file','created_at','updated_at','deleted_at'
    ];
}
