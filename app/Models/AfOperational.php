<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AfOperational extends Model
{
    use HasFactory;

    protected $connection = "mysql";

    protected $guarded = [];

    function agent(){
        return $this->belongsTo(Af::class,'af_id');
    }

    function agentApproval(){
        return $this->belongsTo(Af::class,'approval_af_id');
    }

    function items(){
        return $this->hasMany(AfOperationalItem::class,'af_operational_id');
    }
}
