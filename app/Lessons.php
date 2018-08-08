<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Lessons extends Model
{
    use Notifiable;

    protected $table = 'lessons';

    protected $fillable = [
       'course',
        'class',
        'teacher',
        'start_lesson',
        'duration',
        'room',
        'start',
        'end',
        'week'
    ];


    const UPDATED_AT = null;
    const CREATED_AT = null;
}
