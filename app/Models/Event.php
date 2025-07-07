<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $guarded = ['id'];

    protected $table = 'events';

    function event_transactions()
    {
        return $this->hasMany(EventTransaction::class, 'event_id');
    }
}
