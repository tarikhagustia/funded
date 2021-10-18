<?php


namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Af;

/**
 * This class to handle wallet transaction service on CRM
 * Class WalletService
 * @package App\Services
 */
class WalletService
{
    const OPERATIONAL = 'Operational Cost';

    private $databaseInstance;

    public function __construct()
    {
        $this->databaseInstance = DB::connection('crm');
    }

    public function credit(Af $af, $amount, $type, $remark)
    {
        $this->databaseInstance->table('wallets')->insert([
            'agent_id'         => $af->id,
            'agent_code'       => $af->codes->first()->code,
            'transaction_type' => $type,
            'in'               => $amount,
            'out'              => 0,
            'fix_rate_id'      => 'IDR',
            'amount'           => 0,
            // 'remark' => null,
            'notes'            => $remark,
            'line'             => 0,
            'source'           => 'api',
            'status'           => 1,
        ]);
        return true;
    }
}
