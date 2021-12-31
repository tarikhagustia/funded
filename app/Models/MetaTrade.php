<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetaTrade extends Model
{
    protected $connection = "mt4";
    protected $primaryKey = "TICKET";
    public $timestamps = false;
    protected $table = "MT4_TRADES";

    protected $dates = [
        'CLOSE_TIME'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'LOGIN', 'accountid');
    }
}
