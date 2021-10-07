<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AfCommission extends Model
{
    use HasFactory;

    function agent(){
        return $this->belongsTo(Af::class,'af_id');
    }
}
