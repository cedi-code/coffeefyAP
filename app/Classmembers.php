<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\User;

class Classmembers extends Model
{
    use Notifiable;

    protected $table = 'classmembers';

    protected $fillable = [
        'class', 'pupil'
    ];

    const UPDATED_AT = null;
    const CREATED_AT = null;

    public function user()
    {
        return $this->belongsTo(User::class,  'pupil');
    }
    public function classTo() {
        return $this->belongsTo(Classes::class,  'class');
    }
}
