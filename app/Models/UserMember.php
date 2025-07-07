<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMember extends Model
{
    protected $guarded = ['id'];
    protected $table = 'user_member';

    public function user()
    {
        return $this->belongsTo(User::class, 'no_member', 'no_member');
    }

    public function member()
    {
        // di table user member itu plan,di table member id
        return $this->belongsTo(Member::class, 'plan', 'id');
    }
}
