<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model
{
    protected $connection = "crm";
    protected $table = "transaction_type";

    public function transactions()
    {
        return $this->hasMany(TransactionCRM::class, 'id', 'transaction_type');
    }
}
