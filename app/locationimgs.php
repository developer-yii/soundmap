<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class locationimgs extends Model
{
    use Notifiable;
    use SoftDeletes;

    protected $table = 'location_image';

    protected $fillable = [
        'location_id', 'image_path','deleted_at'
    ];

    public $timestamps = false;
}
