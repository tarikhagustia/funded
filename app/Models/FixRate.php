<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixRate extends Model
{
    use HasFactory;

    protected $connection = "crm";
    protected $table = "fix_rates";
}
