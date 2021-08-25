<?php

namespace App\DataTables\Console;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use App\Models\AccountType;
use Yajra\DataTables\Html\Builder;
use App\Models\Console;
use Yajra\DataTables\DataTableAbstract;
use App\Models\Transaction;

class CommissionTable extends DataTable
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
            ->eloquent($query)
            ->addColumn('action', 'console.account_type.action')
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param Console/User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Transaction $model)
    {
        return $model->newQuery();
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
                    );
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
            Column::make('transaction_date'),
            Column::make('login'),
            Column::make('client_name'),
            Column::make('rate'),
            Column::make('af_name'),
            Column::make('lot'),
            Column::make('comm'),
            Column::make('comm_idr'),
            Column::make('or'),
            Column::make('or_idr'),
            Column::make('bop'),
            Column::make('bop_idr'),
            Column::make('total_rebate'),
            Column::make('prev_equity'),
            Column::make('net_margin_in_out'),
            Column::make('current_equity'),
            Column::make('credit'),
            Column::make('net_equity'),
            Column::make('profit_loss'),
            Column::make('net_profit_loss'),
            Column::make('agent_percentage'),
            Column::make('agent_pl'),
            Column::make('holding_pl'),
            Column::make('registration_date'),
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
