<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event_types extends Model
{
    protected $table = 'event_types';

    protected $fillable = [
        'type'
    ];


    const UPDATED_AT = null;
    const CREATED_AT = null;
}
