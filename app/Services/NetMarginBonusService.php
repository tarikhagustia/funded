<?php

namespace App\Services;

use App\Models\NetMarginBonus;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class NetMarginBonusService
{
    private $dateFrom;
    private $dateTo;
    public function generate(Carbon $dateFrom, Carbon $dateTo)
    {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        DB::beginTransaction();
        // AF8 -> A.1
        $this->generateAf8A();
        // AF7 TYPE (A) 100 New Members or Net Margin 20,000 USD. | A bonus of 0.25 % Bonus of Net Margin will be given if the monthly target of Net Margin is achieved.
        $this->generateAf7();
        // AF6 TYPE (A) 200 New Members or Net Margin 40,000 USD. | A Bonus of 0.25% of Net Margin will be given if the monthly target of Net Margin is achieved.
        $this->generateAf6();
        // AF5 Net Margin 160,000 USD. TYPE (A) | A Bonus of 0.25% of Net Margin will be given if the monthly target of Net Margin is achieved.
        $this->generateAf5();
        // AF4 Net Margin 320,000 USD. TYPE (A) | A Bonus of 0.25% of Net Margin will be given if the monthly target of Net Margin is achieved.
        $this->generateAf4();
        DB::commit();
    }

    public function generateAf4()
    {
        $commissionData = collect();
        $hasGetCommission = [];
       
        $agents = DB::table('transactions', 't')
            ->selectRaw('t.af_id, t.af_name, SUM(net_margin_in_out) as total_net_margin')
            ->join(DB::connection('crm')->getDatabaseName() . '.agents as a', 'a.id', '=', 't.af_id')
            ->where('a.level_on_group', 4)
            ->having(DB::raw('SUM(net_margin_in_out)'), '>=', 320000)
            ->whereBetween('transaction_date', [$this->dateFrom, $this->dateTo])->groupBy('af_id');

        foreach ($agents->get() as $row) {
            $hasGetCommission[] = $row->af_id;
            $commissionData->push([
                'comm_from_date' => $this->dateFrom->format('Y-m-d H:i:s'),
                'comm_to_date' => $this->dateTo->format('Y-m-d H:i:s'),
                'af_id' => $row->af_id,
                'af_name' => $row->af_name,
                'total_net_margin' => $row->total_net_margin,
                'total_lot' => 0,
                'total_member' => 0,
                'total_commission' => $row->total_net_margin * 0.25 / 100,
                'addendum' => 'D.1.',
                'status' => 'Unpaid',
                'created_at' => now()
            ]);
        }

        $this->insertIntoDatabase($commissionData);
    }

    public function generateAf5()
    {
        $commissionData = collect();
        $hasGetCommission = [];
     

        $agents = DB::table('transactions', 't')
            ->selectRaw('t.af_id, t.af_name, SUM(net_margin_in_out) as total_net_margin')
            ->join(DB::connection('crm')->getDatabaseName() . '.agents as a', 'a.id', '=', 't.af_id')
            ->where('a.level_on_group', 5)
            ->having(DB::raw('SUM(net_margin_in_out)'), '>=', 160000)
            ->whereBetween('transaction_date', [$this->dateFrom, $this->dateTo])->groupBy('af_id');

        foreach ($agents->get() as $row) {
            $hasGetCommission[] = $row->af_id;
            $commissionData->push([
                'comm_from_date' => $this->dateFrom->format('Y-m-d H:i:s'),
                'comm_to_date' => $this->dateTo->format('Y-m-d H:i:s'),
                'af_id' => $row->af_id,
                'af_name' => $row->af_name,
                'total_net_margin' => $row->total_net_margin,
                'total_lot' => 0,
                'total_member' => 0,
                'total_commission' => $row->total_net_margin * 0.25 / 100,
                'addendum' => 'E.1.',
                'status' => 'Unpaid',
                'created_at' => now()
            ]);
        }

        $this->insertIntoDatabase($commissionData);
    }

    public function generateAf6()
    {
        $commissionData = collect();
        $hasGetCommission = [];
        $subQuery = DB::table('transactions', 't')
            ->selectRaw('t.af_id, COUNT(login) as new_member')
            ->whereBetween('registration_date', [$this->dateFrom, $this->dateTo])->groupBy(['t.af_id', 't.login']);

        $agents = DB::table('transactions', 't')
            ->selectRaw('t.af_id, t.af_name, SUM(net_margin_in_out) as total_net_margin, initial.new_member')
            ->joinSub($subQuery, 'initial', function ($join) {
                $join->on('t.af_id', '=', 'initial.af_id');
            })
            ->join(DB::connection('crm')->getDatabaseName() . '.agents as a', 'a.id', '=', 't.af_id')
            ->where('a.level_on_group', 6)
            ->having(DB::raw('SUM(net_margin_in_out)'), '>=', 40000)
            ->orWhere('initial.new_member', '>=', 200)
            ->whereBetween('transaction_date', [$this->dateFrom, $this->dateTo])->groupBy('af_id');

        foreach ($agents->get() as $row) {
            $hasGetCommission[] = $row->af_id;
            $commissionData->push([
                'comm_from_date' => $this->dateFrom->format('Y-m-d H:i:s'),
                'comm_to_date' => $this->dateTo->format('Y-m-d H:i:s'),
                'af_id' => $row->af_id,
                'af_name' => $row->af_name,
                'total_net_margin' => $row->total_net_margin,
                'total_lot' => 0,
                'total_member' => $row->new_member,
                'total_commission' => $row->total_net_margin * 0.25 / 100,
                'addendum' => 'E.1.',
                'status' => 'Unpaid',
                'created_at' => now()
            ]);
        }

        $this->insertIntoDatabase($commissionData);
    }

    public function generateAf7()
    {
        $commissionData = collect();
        $hasGetCommission = [];
        $subQuery = DB::table('transactions', 't')
            ->selectRaw('t.af_id, COUNT(login) as new_member')
            ->whereBetween('registration_date', [$this->dateFrom, $this->dateTo])->groupBy(['t.af_id', 't.login']);

        $agents = DB::table('transactions', 't')
            ->selectRaw('t.af_id, t.af_name, SUM(net_margin_in_out) as total_net_margin, initial.new_member')
            ->joinSub($subQuery, 'initial', function ($join) {
                $join->on('t.af_id', '=', 'initial.af_id');
            })
            ->join(DB::connection('crm')->getDatabaseName() . '.agents as a', 'a.id', '=', 't.af_id')
            ->where('a.level_on_group', 7)
            ->having(DB::raw('SUM(net_margin_in_out)'), '>=', 20000)
            ->orWhere('initial.new_member', '>=', 100)
            ->whereBetween('transaction_date', [$this->dateFrom, $this->dateTo])->groupBy('af_id');

        foreach ($agents->get() as $row) {
            $hasGetCommission[] = $row->af_id;
            $commissionData->push([
                'comm_from_date' => $this->dateFrom->format('Y-m-d H:i:s'),
                'comm_to_date' => $this->dateTo->format('Y-m-d H:i:s'),
                'af_id' => $row->af_id,
                'af_name' => $row->af_name,
                'total_net_margin' => $row->total_net_margin,
                'total_lot' => 0,
                'total_member' => $row->new_member,
                'total_commission' => $row->total_net_margin * 0.25 / 100,
                'addendum' => 'C.1.',
                'status' => 'Unpaid',
                'created_at' => now()
            ]);
        }

        $this->insertIntoDatabase($commissionData);
    }

    public function generateAf8A()
    {
        $commissionData = collect();
        $hasGetCommission = [];
        $dbName = DB::connection('crm')->getDatabaseName();
        $subQuery = DB::table('transactions', 't')
            ->selectRaw('t.af_id, COUNT(login) as new_member, SUM(initial.initial_margin) as initial_margin')
            ->join(DB::raw("(SELECT
                a.accountid,
                sum(t.amount) as initial_margin
            FROM
                {$dbName}.transactions t
            INNER JOIN {$dbName}.accounts a ON
                a.id = t.accid
            WHERE
                t.transaction_type = 1 AND t.amount >= 150
            group by
                a.accountid) as initial"), function ($join) {
                $join->on('t.login', '=', 'initial.accountid');
            })
            ->whereBetween('registration_date', [$this->dateFrom, $this->dateTo])->groupBy(['t.af_id', 't.login']);

        $agents = DB::table('transactions', 't')
            ->selectRaw('t.af_id, t.af_name, SUM(net_margin_in_out) as total_net_margin, SUM(lot) as total_lot, initial.new_member, initial.initial_margin')
            ->joinSub($subQuery, 'initial', function ($join) {
                $join->on('t.af_id', '=', 'initial.af_id');
            })
            ->join(DB::connection('crm')->getDatabaseName() . '.agents as a', 'a.id', '=', 't.af_id')
            ->where('a.level_on_group', 8)
            ->having(DB::raw('SUM(net_margin_in_out)'), '>=', 10000)
            ->having(DB::raw('SUM(lot)'), '>=', 10)
            ->whereBetween('transaction_date', [$this->dateFrom, $this->dateTo])->groupBy('af_id');

        foreach ($agents->get() as $row) {
            $hasGetCommission[] = $row->af_id;
            $commissionData->push([
                'comm_from_date' => $this->dateFrom->format('Y-m-d H:i:s'),
                'comm_to_date' => $this->dateTo->format('Y-m-d H:i:s'),
                'af_id' => $row->af_id,
                'af_name' => $row->af_name,
                'total_net_margin' => $row->total_net_margin,
                'total_lot' => $row->total_lot,
                'total_member' => $row->new_member,
                'total_commission' => 200,
                'addendum' => 'A.1.',
                'status' => 'Unpaid',
                'created_at' => now()
            ]);
        }

        // Calculate for TYPE A.2

        // A.2.3. 80 USD > If reach new Member, at least 5 people with the condition that the 
        // Net Margin per month from each new Member is 200 USD.
        $subQuery = DB::table('transactions', 't')
            ->selectRaw('t.af_id, COUNT(login) as new_member, SUM(net_margin_in_out) as member_nmi')
            ->having(DB::raw('SUM(net_margin_in_out)'), '>=', 200) // Net Margin per month from each new Member is 200 USD.
            ->whereBetween('registration_date', [$this->dateFrom, $this->dateTo])->groupBy(['t.af_id', 't.login']);
        $agents = DB::table('transactions', 't')
            ->selectRaw('t.af_id, t.af_name, initial.member_nmi, initial.new_member')
            ->joinSub($subQuery, 'initial', function ($join) {
                $join->on('t.af_id', '=', 'initial.af_id');
            })
            ->join(DB::connection('crm')->getDatabaseName() . '.agents as a', 'a.id', '=', 't.af_id')
            ->where('a.level_on_group', 8)
            ->whereNotIn('t.af_id', $hasGetCommission)
            ->whereBetween('transaction_date', [$this->dateFrom, $this->dateTo])->groupBy('af_id');

        foreach ($agents->get() as $row) {
            $hasGetCommission[] = $row->af_id;
            $commissionData->push([
                'comm_from_date' => $this->dateFrom->format('Y-m-d H:i:s'),
                'comm_to_date' => $this->dateTo->format('Y-m-d H:i:s'),
                'af_id' => $row->af_id,
                'af_name' => $row->af_name,
                'total_net_margin' => $row->member_nmi,
                'total_lot' => 0,
                'total_member' => $row->new_member,
                'total_commission' => 80,
                'addendum' => 'A.2.3.',
                'status' => 'Unpaid',
                'created_at' => now()
            ]);
        }

        // A.2.2. 80 USD > If the total of the Net Margin per month from the Referred Affiliate
        // achieves 1,000 USD.
        $subQuery = DB::table('transactions', 't')
            ->join(DB::connection('crm')->getDatabaseName() . '.agents as a', 'a.id', '=', 't.af_id')
            ->selectRaw('a.parentid, SUM(t.net_margin_in_out) as nmi')
            ->whereBetween('transaction_date', [$this->dateFrom, $this->dateTo])->groupBy(['t.af_id', 't.login'])
            ->groupBy('a.parentid');

        $agents = DB::table('transactions', 't')
            ->selectRaw('t.af_id, t.af_name, initial.nmi')
            ->joinSub($subQuery, 'initial', function ($join) {
                $join->on('t.af_id', '=', 'initial.parentid');
            })
            ->join(DB::connection('crm')->getDatabaseName() . '.agents as a', 'a.id', '=', 't.af_id')
            ->where('a.level_on_group', 8)
            ->whereNotIn('t.af_id', $hasGetCommission)
            ->where('initial.nmi', '>=', 1000)
            ->whereBetween('transaction_date', [$this->dateFrom, $this->dateTo])->groupBy('af_id');

        foreach ($agents->get() as $row) {
            $hasGetCommission[] = $row->af_id;
            $commissionData->push([
                'comm_from_date' => $this->dateFrom->format('Y-m-d H:i:s'),
                'comm_to_date' => $this->dateTo->format('Y-m-d H:i:s'),
                'af_id' => $row->af_id,
                'af_name' => $row->af_name,
                'total_net_margin' => $row->nmi,
                'total_lot' => 0,
                'total_member' => 0,
                'total_commission' => 80,
                'addendum' => 'A.2.2.',
                'status' => 'Unpaid',
                'created_at' => now()
            ]);
        }

        // A.2.1. 40 USD > If the total of the Net Margin per month from the Direct Member 
        // achieves 5,000 USD.

        $agents = DB::table('transactions', 't')
            ->selectRaw('t.af_id, t.af_name, SUM(net_margin_in_out) as nmi')
            ->join(DB::connection('crm')->getDatabaseName() . '.agents as a', 'a.id', '=', 't.af_id')
            ->where('a.level_on_group', 8)
            ->having(DB::raw('SUM(net_margin_in_out)'), '>=', 5000)
            ->whereNotIn('t.af_id', $hasGetCommission)
            ->whereBetween('transaction_date', [$this->dateFrom, $this->dateTo])->groupBy('af_id');

        foreach ($agents->get() as $row) {
            $hasGetCommission[] = $row->af_id;
            $commissionData->push([
                'comm_from_date' => $this->dateFrom->format('Y-m-d H:i:s'),
                'comm_to_date' => $this->dateTo->format('Y-m-d H:i:s'),
                'af_id' => $row->af_id,
                'af_name' => $row->af_name,
                'total_net_margin' => $row->nmi,
                'total_lot' => 0,
                'total_member' => 0,
                'total_commission' => 80,
                'addendum' => 'A.2.1.',
                'status' => 'Unpaid',
                'created_at' => now()
            ]);
        }

        $this->insertIntoDatabase($commissionData);
    }

    protected function insertIntoDatabase($data)
    {
        NetMarginBonus::insert($data->toArray());
    }
}
