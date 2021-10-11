<?php

namespace App\DataTables\Console\Report;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\DataTableAbstract;
use App\Services\AfCommissionService;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\AfCommission;
use Illuminate\Support\Facades\Auth;

class AffiliateCommissionTable extends DataTable
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
            ->eloquent($query)
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param Console/User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(AfCommission $model)
    {
        $query = $model->newQuery();

        $tmpDate = explode(' - ', request()->input('range'));
        if (count($tmpDate) == 2) {
            $dateStart = Carbon::parse($tmpDate[0])->startOfDay();
            $dateEnd = Carbon::parse($tmpDate[1])->endOfDay();
            $query->whereBetween('comm_date', [$dateStart, $dateEnd]);
        }

        return $query;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('affiliate-commission-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(0, 'desc')
                    ->dom('Bfrtip')
                    ->buttons(
                    // Button::make('create'),
                        Button::make('colvis'),
                        Button::make('pageLength'),
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
            Column::make('DT_RowIndex')->title(__('No'))->orderable(false)->searchable(false),
            Column::make('comm_date')->title(__('Date')),
            Column::make('login')->title('Login'),
            Column::make('client_name')->title('Client Name'),
            Column::make('af_name')->title('Af Name'),
            Column::make('af_percentage')->title('Af Percentage (%)'),
            Column::make('max_rebate')->title('Max Rebate (USD)'),
            Column::make('lot')->orderable(false)->searchable(false)->title('Lot'),
            Column::make('total_commission')->orderable(false)->searchable(false)->title('Total Commission'),

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
