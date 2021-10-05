<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionCrm extends Model
{
    protected $connection = "crm";
    protected $table = "transactions";

    public function type()
    {
        return $this->belongsTo(TransactionType::class, 'id', 'transaction_type');
    }

    
    public function user()
    {
        return $this->belongsTo(Client::class, 'userid');
    }

    
    public function get_status()
    {
        return $this->belongsTo(Status::class, 'status');
    }
}
