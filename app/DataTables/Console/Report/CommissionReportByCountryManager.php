<?php

namespace App\DataTables\Console\Report;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder;
use App\Models\Console;
use Yajra\DataTables\DataTableAbstract;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Repositories\CommissionReportRepository;

class CommissionReportByCountryManager extends DataTable
{
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
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param Console/User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(CommissionReportRepository $commissionReportRepository)
    {

        $query = $commissionReportRepository->getQueryByCountryManager();
        $tmpDate = explode(' - ', request()->input('range'));
        if (count($tmpDate) == 2) {
            $dateStart = Carbon::parse($tmpDate[0])->startOfDay();
            $dateEnd = Carbon::parse($tmpDate[1])->endOfDay();
            $query->whereBetween('t.transaction_date', [$dateStart, $dateEnd]);
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
        $builder = $this->builder()
            ->setTableId('commission-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->stateSave(true)
            ->ajax([
                'data' => 'function(d) { 
                                    d.range = $("#reportrange span").html();
                                    d.report_type = "' . $this->report_type . '";
                                }'
            ])
            ->fixedHeader(true)
            ->lengthMenu([10, 25, 50, 100, -1])
            ->buttons(
                // Button::make('create'),
                Button::make('colvis'),
                Button::make('pageLength'),
                Button::make('export'),
                Button::make('print')
            );

        return $builder;
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id', 'a.id')->title(__('Af ID')),
            Column::make('agentname', 'a.agentname')->title(__('Af Name')),
            Column::make('level_on_group', 'a.level_on_group')->title(__('Af Level')),
            Column::make('lot')->title(__('Lot')),
            Column::make('comm')->title(__('comm')),
            Column::make('comm_idr')->title(__('comm_idr')),
            Column::make('or')->title(__('or')),
            Column::make('bop')->title(__('bop')),
            Column::make('bop_idr')->title(__('bop_idr')),
            Column::make('net_margin_in_out')->title(__('net_margin_in_out')),
            Column::make('profit_loss')->title(__('profit_loss')),
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
        return 'AccountType_' . date('YmdHis');
    }
}
