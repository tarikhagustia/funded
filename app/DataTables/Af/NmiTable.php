<?php

namespace App\DataTables\Af;

use App\Models\NetMarginBonus;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\DataTableAbstract;
use Carbon\Carbon;
use App\Models\ReferralBonus;
use App\Models\Transaction;
use App\Repositories\NetMarginInOutRepository;
use Illuminate\Support\Facades\Auth;

class NmiTable extends DataTable
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
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param Console/User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(NetMarginInOutRepository $netMarginInOutRepository)
    {
        $query = $netMarginInOutRepository->getNetMarginInOutQuery(auth()->user());
        $tmpDate = explode(' - ', request()->input('range'));
        if (count($tmpDate) == 2) {
            $dateStart = Carbon::parse($tmpDate[0])->startOfDay();
            $dateEnd = Carbon::parse($tmpDate[1])->endOfDay();
            $query->where('transaction_date', '>=', $dateStart);
            $query->where('transaction_date', '<=', $dateEnd);
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
            ->setTableId('commission-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1, 'desc')
            ->dom('Bfrtip')
            ->fixedHeader(true)
            ->lengthMenu([10, 25, 50, 100, -1])
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
            ])->footerCallback("
                    function ( row, data, start, end, display ) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            let sum_columns  = [6,7];
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

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('DT_RowIndex')->title(__('No'))->orderable(false)->searchable(false),
            Column::make('transaction_date'),
            Column::make('af_id')->title('Af ID'),
            Column::make('af_name')->title('Af Name'),
            Column::make('login'),
            Column::make('client_name')->title(__('Member Name')),
            Column::make('net_margin_in_out')->title(__('Net Margin In Out')),
            Column::make('lot')->title('Lot'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'ReferralBonus' . date('YmdHis');
    }
}
