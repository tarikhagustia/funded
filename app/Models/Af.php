<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Af extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $connection = "crm";
    protected $table = "agents";

    public function getNameAttribute()
    {
        return $this->agentname;
    }

}
