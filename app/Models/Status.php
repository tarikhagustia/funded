<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionCrm extends Model
{
    protected $connection = "crm";
    protected $table = "status";
}
