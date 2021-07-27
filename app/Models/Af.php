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

    public function getParentIdName()
    {
        return 'parentid';
    }

    public function getNameAttribute()
    {
        return $this->agentname;
    }

}
