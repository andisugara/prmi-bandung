<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventTransaction extends Model
{
    protected $guarded = ['id'];
    protected $table = 'event_transactions';

    function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
