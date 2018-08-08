<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schools extends Model
{
    protected $table = 'schools';

    protected $fillable = [
        'location', 'title'
    ];


    const UPDATED_AT = null;
    const CREATED_AT = null;
}
