<?php

namespace App\Repositories;

use App\Models\Af;
use App\Models\Transaction;

class NetMarginInOutRepository
{
    /**
     * Generate query for searching NMI By Affiliate model
     */
    public function getNetMarginInOutQuery(Af $af)
    {
        $afs = $af->descendants->pluck('id');
        $query = Transaction::query()->whereIN('af_id', $afs);

        return $query;
    }
}
