<?php

namespace App\DataTables\Console;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder;
use App\Models\Console;
use Yajra\DataTables\DataTableAbstract;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
            ->query($query)
            // ->addColumn('action', 'console.account_type.action')
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


        if ($this->report_type == "af") {
            $query = DB::table($model->getTable())
                       ->select(
                           [
                               'af_id',
                               'af_name',
                               DB::raw('SUM(new_account) as new_account'),
                               DB::raw('SUM(lot) as total_lot'),
                               DB::raw('SUM(comm_idr) as comm_idr'),
                               DB::raw('SUM(or_idr) as or_idr'),
                               DB::raw('SUM(bop_idr) as bop_idr'),
                               DB::raw('SUM(total_rebate) as total_rebate'),
                               DB::raw('SUM(prev_equity) as prev_equity'),
                               DB::raw('SUM(net_margin_in_out) as net_margin_in_out'),
                               DB::raw('SUM(current_equity) as current_equity'),
                               DB::raw('SUM(credit) as credit'),
                               DB::raw('SUM(profit_loss) as profit_loss'),
                               DB::raw('SUM(net_profit_loss) as net_profit_loss'),
                               DB::raw('SUM(agent_pl) as agent_pl'),
                               DB::raw('SUM(holding_pl) as holding_pl'),
                           ])
                       ->groupBy('af_name');
            $tmpDate = explode(' - ', request()->input('range'));
            if (count($tmpDate) == 2) {
                $dateStart = Carbon::parse($tmpDate[0])->startOfDay();
                $dateEnd = Carbon::parse($tmpDate[1])->endOfDay();
                $query->whereBetween('transaction_date', [$dateStart, $dateEnd]);
            }
        } elseif($this->report_type == "member") {
            $query = DB::table($model->getTable())
                       ->select(
                           [
                               'login',
                               DB::raw('SUM(new_account) as new_account'),
                               DB::raw('SUM(lot) as total_lot'),
                               DB::raw('SUM(comm_idr) as comm_idr'),
                               DB::raw('SUM(or_idr) as or_idr'),
                               DB::raw('SUM(bop_idr) as bop_idr'),
                               DB::raw('SUM(total_rebate) as total_rebate'),
                               DB::raw('SUM(prev_equity) as prev_equity'),
                               DB::raw('SUM(net_margin_in_out) as net_margin_in_out'),
                               DB::raw('SUM(current_equity) as current_equity'),
                               DB::raw('SUM(credit) as credit'),
                               DB::raw('SUM(profit_loss) as profit_loss'),
                               DB::raw('SUM(net_profit_loss) as net_profit_loss'),
                               DB::raw('SUM(agent_pl) as agent_pl'),
                               DB::raw('SUM(holding_pl) as holding_pl'),
                           ])
                       ->groupBy('login');
            $tmpDate = explode(' - ', request()->input('range'));
            if (count($tmpDate) == 2) {
                $dateStart = Carbon::parse($tmpDate[0])->startOfDay();
                $dateEnd = Carbon::parse($tmpDate[1])->endOfDay();
                $query->whereBetween('transaction_date', [$dateStart, $dateEnd]);
            }
        }else{
            $query = DB::table($model->getTable());
            $tmpDate = explode(' - ', request()->input('range'));
            if (count($tmpDate) == 2) {
                $dateStart = Carbon::parse($tmpDate[0])->startOfDay();
                $dateEnd = Carbon::parse($tmpDate[1])->endOfDay();
                $query->whereBetween('transaction_date', [$dateStart, $dateEnd]);
            }
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
                        ->orderBy(0, 'desc')
                        ->dom('Bfrtip')
                        ->stateSave(true)
                        ->ajax([
                            'data' => 'function(d) { 
                                    d.range = $("#reportrange span").html();
                                    d.report_type = "'.$this->report_type.'";
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

        if ($this->report_type == "af" || $this->report_type == "member") {
            $builder
                ->footerCallback("
                        function ( row, data, start, end, display ) {
                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };

                let sum_columns  = [2,3,4,5,6,7,8,9,10,11,12,13,14,15];
                sum_columns.forEach(function(val, index){
                    // Total over all pages
                    total = api
                        .column(val)
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    // Total over this page
                    pageTotal = api
                        .column(val, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    // Update footer
                    $( api.column(val).footer() ).html(
                       total.toFixed(2)
                    );
                })

            }
                        ");
        }else{
            $builder
                ->footerCallback("
                        function ( row, data, start, end, display ) {
                var api = this.api(), data;
            
                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };
            
                let sum_columns  = [8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25];
                sum_columns.forEach(function(val, index){
                    // Total over all pages
                    total = api
                        .column(val)
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
            
                    // Total over this page
                    pageTotal = api
                        .column(val, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    // Update footer
                    $( api.column(val).footer() ).html(
                       total.toFixed(2)
                    );
                })
            
            }
                        ");
        }
        return $builder;
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        if ($this->report_type == "af") {
            return $this->getAfColumns();
        }

        if ($this->report_type == "member") {
            return $this->getMemberColumns();
        }
        return [
            // Column::make('DT_RowIndex')->title(__('No'))->orderable(false)->searchable(false),
            Column::make('transaction_date'),
            Column::make('login'),
            Column::make('client_name'),
            Column::make('rate'),
            Column::make('ac_type'),
            Column::make('max_rebate'),
            Column::make('af_id'),
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

    protected function getAfColumns()
    {
        return [
            // Column::make('DT_RowIndex')->title(__('No'))->orderable(false)->searchable(false),
            Column::make('af_id'),
            Column::make('af_name'),
            Column::make('new_account'),
            Column::make('total_lot'),
            Column::make('comm_idr'),
            Column::make('or_idr'),
            Column::make('bop_idr'),
            Column::make('total_rebate'),
            Column::make('prev_equity'),
            Column::make('net_margin_in_out'),
            Column::make('current_equity'),
            Column::make('credit'),
            Column::make('profit_loss'),
            Column::make('net_profit_loss'),
            Column::make('agent_pl'),
            Column::make('holding_pl'),
            // Column::make('login'),
            // Column::make('client_name'),
            // Column::make('rate'),
            // Column::make('ac_type'),
            // Column::make('max_rebate'),
            // Column::make('af_name'),
            // Column::make('lot'),
            // Column::make('comm'),
            // Column::make('comm_idr'),
            // Column::make('or'),
            // Column::make('or_idr'),
            // Column::make('bop'),
            // Column::make('bop_idr'),
            // Column::make('total_rebate'),
            // Column::make('prev_equity'),
            // Column::make('net_margin_in_out'),
            // Column::make('current_equity'),
            // Column::make('credit'),
            // Column::make('net_equity'),
            // Column::make('profit_loss'),
            // Column::make('net_profit_loss'),
            // Column::make('agent_percentage'),
            // Column::make('agent_pl'),
            // Column::make('holding_pl'),
            // Column::make('registration_date'),
            // Column::computed('action')
            //       ->exportable(false)
            //       ->printable(false)
            //       ->width(60)
            //       ->addClass('text-center'),
        ];
    }

    protected function getMemberColumns()
    {
        return [
            // Column::make('DT_RowIndex')->title(__('No'))->orderable(false)->searchable(false),
            Column::make('login'),
            Column::make('new_account'),
            Column::make('total_lot'),
            Column::make('comm_idr'),
            Column::make('or_idr'),
            Column::make('bop_idr'),
            Column::make('total_rebate'),
            Column::make('prev_equity'),
            Column::make('net_margin_in_out'),
            Column::make('current_equity'),
            Column::make('credit'),
            Column::make('profit_loss'),
            Column::make('net_profit_loss'),
            Column::make('agent_pl'),
            Column::make('holding_pl'),
            // Column::make('login'),
            // Column::make('client_name'),
            // Column::make('rate'),
            // Column::make('ac_type'),
            // Column::make('max_rebate'),
            // Column::make('af_name'),
            // Column::make('lot'),
            // Column::make('comm'),
            // Column::make('comm_idr'),
            // Column::make('or'),
            // Column::make('or_idr'),
            // Column::make('bop'),
            // Column::make('bop_idr'),
            // Column::make('total_rebate'),
            // Column::make('prev_equity'),
            // Column::make('net_margin_in_out'),
            // Column::make('current_equity'),
            // Column::make('credit'),
            // Column::make('net_equity'),
            // Column::make('profit_loss'),
            // Column::make('net_profit_loss'),
            // Column::make('agent_percentage'),
            // Column::make('agent_pl'),
            // Column::make('holding_pl'),
            // Column::make('registration_date'),
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
