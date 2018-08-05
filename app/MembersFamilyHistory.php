<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MembersFamilyHistory extends Model
{
     protected $guarded=[];
     public $timestamps = false;
     protected $table ="members_family_history";

     public function member()
    {
        return $this->belongsTo('App\Member');
    }


}
