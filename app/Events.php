<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use Notifiable;

    protected $table = 'events';

    protected $fillable = [
        'type',
        'lesson',
        'creator',
        'title',
        'description'
    ];


    const UPDATED_AT = null;
    const CREATED_AT = null;
}
