<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $guarded = ['id'];
    protected $table = 'members';

    function memberBenefits()
    {
        return $this->hasMany(MemberBenefit::class);
    }
}
