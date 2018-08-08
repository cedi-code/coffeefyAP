<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;


class Classes extends Model
{
    use Notifiable;

    protected $table = 'classes';

    protected $fillable = [
        'school', 'teacher', 'title',
    ];
}
