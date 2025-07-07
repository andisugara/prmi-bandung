<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberBenefit extends Model
{
    protected $guarded = ['id'];
    protected $table = 'member_benefits';

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function benefit()
    {
        return $this->belongsTo(Benefit::class);
    }
}
