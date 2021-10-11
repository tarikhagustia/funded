<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Kalnoy\Nestedset\NodeTrait;

class Af extends Authenticatable
{
    use HasFactory, Notifiable, NodeTrait;

    protected $connection = "crm";
    protected $table = "agents";
    public $timestamps = false;

    public function getParentIdName()
    {
        return 'parentid';
    }

    public function getNameAttribute()
    {
        return $this->agentname;
    }

    public function clients()
    {
        return $this->hasMany(Client::class,'agentid');
    }

    public function childs(){
        return $this->hasMany(Af::class,'parentid');
    }

    public function commissions(){
        return $this->hasMany(AfCommission::class,'af_id');
    }

}
