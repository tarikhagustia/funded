<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Client extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $connection = "crm";
    protected $table = "clients";

    public function accounts()
    {
        return $this->hasMany(Account::class,'userid');
    }

    public function get_country()
    {
        return $this->hasOne(Country::class,'countrycode','country');
    }

    
}
