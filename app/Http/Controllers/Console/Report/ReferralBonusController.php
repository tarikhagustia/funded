<?php

namespace App\Http\Controllers\Console\Report;

use App\Http\Controllers\Controller;
use App\DataTables\Console\Report\ReferralBonusTable;
use App\DataTables\Console\Report\ReferralBonusAffiliateSummaryTable;
use Illuminate\Http\Request;

class ReferralBonusController extends Controller
{
    /**
     * @var ReferralBonusTable
     */
    private $referralBonusTable;
    /**
     * @var ReferralBonusAffiliateSummaryTable
     */
    private $referralBonusAffiliateSummaryTable;

    public function __construct(ReferralBonusTable $referralBonusTable, ReferralBonusAffiliateSummaryTable $referralBonusAffiliateSummaryTable)
    {
        $this->referralBonusTable = $referralBonusTable;
        $this->referralBonusAffiliateSummaryTable = $referralBonusAffiliateSummaryTable;
    }

    public function index(Request $request)
    {
        $dataTable = $this->referralBonusAffiliateSummaryTable;
        if ($request->get('report_type') == 'detail') {
            $dataTable = $this->referralBonusTable;
        }
        return $dataTable->render('console.report.referral_bonus.index');
    }
}
