<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class Courses extends Model
{
    use Notifiable;

    protected $table = 'courses';

    protected $fillable = [
         'title', 'short'
    ];


    const UPDATED_AT = null;
    const CREATED_AT = null;
}
