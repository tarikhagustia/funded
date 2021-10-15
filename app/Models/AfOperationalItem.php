<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AfOperationalItem extends Model
{
    use HasFactory;

    protected $connection = "mysql";

    protected $guarded = [];

    function operational(){
        return $this->belongsTo(AfOperational::class,'af_operational_id');
    }
}
