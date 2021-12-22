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
use App\Models\AfTarget;
use Illuminate\Support\Facades\Auth;

class AffiliatePerformanceTable extends DataTable
{

    public function __construct()
    {
        
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
            ->addColumn('status', function($row){
                return $row->is_passed ? "<span class='badge badge-success'>Passed</span>" : "<span class='badge badge-danger'>Failed</span>";
            })
            ->rawColumns(['status'])
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param Console/User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(AfTarget $model)
    {
        $query = $model->newQuery();

        $tmpDate = explode(' - ', request()->input('range'));
        if (count($tmpDate) == 2) {
            $dateStart = Carbon::parse($tmpDate[0])->startOfDay();
            $dateEnd = Carbon::parse($tmpDate[1])->endOfDay();
            $query->whereDate('date_from', '>=', $dateStart);
            $query->whereDate('date_to', '<=', $dateEnd);
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
                    ->setTableId('data-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(0, 'desc')
                    ->dom('Bfrtip')
                    ->fixedHeader(true)
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
            Column::make('date_from')->title(__('Date From')),
            Column::make('date_to')->title(__('Date To')),
            Column::make('af_id')->title(__('Af ID')),
            Column::make('af_name')->title(__('Af Name')),
            Column::make('new_member')->title(__('New Member')),
            Column::make('net_margin')->title(__('Total Net Margin')),
            Column::make('maintain_downline')->title(__('Maintain Downline')),
            Column::make('status')->title(__('Status'))->orderable(false)->searchable('false'),
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
        return 'PerformanceReport'.date('YmdHis');
    }
}
