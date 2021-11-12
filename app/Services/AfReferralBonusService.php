<?php


namespace App\Services;


use Carbon\Carbon;
use App\Models\Af;
use Illuminate\Support\Facades\DB;
use App\Models\ReferralBonus;

class AfReferralBonusService
{
    protected $calculateDate;

    public function calculateCommissionFor(Carbon $date)
    {
        // $table->date('comm_date');
        // $table->integer('af_id');
        // $table->integer('login');
        // $table->string('client_name');
        // $table->string('af_name');
        // $table->integer('af_level');
        // $table->float('af_percentage');
        // $table->float('comm_rebate');
        // $table->float('lot');
        // $table->double('total_commission');
        // $table->dateTime('paid_at')->nullable();
        $this->calculateDate = $date;
        $data = collect();
        // Get all affiliates from 4 to 8
        $affiliates = Af::where('level_on_group', '>=', 4)
                        ->where('id', 44)
                        ->get();
        foreach ($affiliates as $affiliate) {
            // Get all children
            $accounts = $this->getAccountByAfIds($affiliate->children);

            foreach ($accounts->get() as $account) {
                $data->push([
                    'comm_date'     => $date->format('Y-m-d'),
                    'af_id'         => $affiliate->id,
                    'login'         => $account->accountid,
                    'client_name'   => $account->name,
                    'af_name'       => $affiliate->agentname,
                    'af_level'      => $affiliate->level_on_group,
                    'af_percentage' => $account->referral_bonus_percentage,
                    'comm_rebate'   => $account->max_rebate,
                    'lot'     => $account->total_lot,
                    'total_commission' => (floatval($account->max_rebate) * $account->referral_bonus_percentage / 100) * $account->total_lot
                ]);
            }
        }

        ReferralBonus::insert($data->toArray());



    }

    protected function getAccountByAfIds($child)
    {
        $queryAccounts = DB::connection('crm')->table('accounts', 'a')
                           ->select(['a.accountid', 'c.nama as name', 'cm.max_rebate', 'al.referral_bonus_percentage', 'al.affiliate_max_bonus', DB::raw('IFNULL(SUM(mt.VOLUME / 100), 0) as total_lot')])
                           ->join('fix_rates as r', 'r.id', '=', 'a.currencyid')
                           ->join('clients as c', 'c.id', '=', 'a.userid')
                           ->join('agents_code as ac', 'ac.id', '=', 'a.comm_id')
                           ->join('agents as ag', 'ag.id', '=', 'ac.ref_id')
                           ->join('account_groups as g', 'g.id', '=', 'a.account_group_id')
                           ->join('commissions as cm', 'cm.id', '=', 'g.commission_id')
                           ->join(DB::connection('mysql')
                                    ->getDatabaseName().".af_levels as al", 'al.id', '=', 'ag.level_on_group')
                           ->leftJoin(DB::connection('mt4')
                                        ->getDatabaseName().".MT4_TRADES as mt", function ($join) {
                               $join->on('mt.LOGIN', '=', 'a.accountid')->whereDate('CLOSE_TIME', $this->calculateDate);
                           })
                           ->whereIn('ag.id', $child->pluck('id'))
                           ->groupBy('a.accountid');

        return $queryAccounts;
    }
}
