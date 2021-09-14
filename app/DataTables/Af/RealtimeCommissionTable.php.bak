<?php

namespace App\DataTables\Af;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\DataTableAbstract;
use App\Services\AfCommissionService;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RealtimeCommissionTable extends DataTable
{
    /**
     * @var AfCommissionService
     */
    private $afCommissionService;

    private $user;

    public function __construct(AfCommissionService $afCommissionService)
    {
        $this->afCommissionService = $afCommissionService;
        $this->user = auth()->user();
    }

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->query($query)
            ->addColumn('lot', function ($row) {
                $query = DB::connection('mt4')->table('MT4_TRADES')->where('LOGIN', $row->accountid)
                           ->whereIn('CMD', [1, 0]);

                $tmpDate = explode(' - ', request()->input('range'));
                if (count($tmpDate) == 2) {
                    $dateStart = Carbon::parse($tmpDate[0])->startOfDay();
                    $dateEnd = Carbon::parse($tmpDate[1])->endOfDay();
                    $query->whereBetween('CLOSE_TIME', [$dateStart, $dateEnd]);
                }

                return $query->sum(DB::raw('VOLUME/100'));
            })
            ->addColumn('percent', function ($row) {
                return $row->{'af'.$this->user->level_on_group};
            })
            ->addColumn('total_comm', 'af.commissions.total_comm')
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param Console/User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return $this->afCommissionService->getRealtimeCommissionQuery();;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('commission-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(0, 'desc')
                    ->dom('Bfrtip')
                    ->buttons(
                    // Button::make('create'),
                        Button::make('export'),
                        Button::make('print')
                    )
                    ->ajax([
                        'data' => 'function(d) { 
                            d.range = $("#reportrange span").html();
                        }'
                    ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            // Column::make('DT_RowIndex')->title(__('No'))->orderable(false)->searchable(false),
            Column::make('accountid')->name('a.accountid')->title('Login'),
            Column::make('account_type')->name('g.account_type')->title('Account Type'),
            Column::make('nama')->name('c.nama')->title('Client Name'),
            Column::make('agentname')->name('ag.agentname')->title('Af Name'),
            Column::make('af'.$this->user->level_on_group)->searchable(false)->orderable(false)->title('Af Percentage (%)'),
            Column::make('max_rebate')->name('g.max_rebate')->title('Max Rebate (USD)'),
            Column::make('lot')->orderable(false)->searchable(false)->title('Lot'),
            Column::make('total_comm')->orderable(false)->searchable(false)->title('Total Commission'),

            // Column::computed('action')
            //       ->exportable(false)
            //       ->printable(false)
            //       ->width(60)
            //       ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'AccountType_'.date('YmdHis');
    }
}
