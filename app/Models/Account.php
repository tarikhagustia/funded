<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $connection = "crm";
    protected $table = "accounts";

    public function group()
    {
        return $this->hasOne(AccountGroup::class,'id','account_group_id');
    }

    public function currency()
    {
        return $this->hasOne(FixRate::class,'id','currencyid');
    }
}
