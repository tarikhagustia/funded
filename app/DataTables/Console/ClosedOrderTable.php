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

class ClosedOrderTable extends DataTable
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
            ->addColumn('TYPE', function ($row) {
                return $row->CMD == 1 ? "Buy" : "Sell";
            })
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param Console/User $model
     * @return \Illuminate\Database\Query\Builder
     */
    public function query(Transaction $model)
    {
        $query = DB::connection('mt4')
                   ->table('MT4_TRADES', 'mt')
                   ->select([
                       'TICKET', 'mt.CMD', 'mt.LOGIN', 'mt.SYMBOL', 'mt.OPEN_TIME', 'mt.CLOSE_TIME', 'mt.VOLUME', DB::raw('(TIME_TO_SEC(TIMEDIFF(mt.CLOSE_TIME, mt.OPEN_TIME)) / 60) as LQ_TIME')
                   ])
                   ->whereYear('mt.CLOSE_TIME', '!=', 1970)
                   ->where(DB::raw('(TIME_TO_SEC(TIMEDIFF(mt.CLOSE_TIME, mt.OPEN_TIME)) / 60)'), '<', 3)
                   ->whereIn('mt.CMD', [1, 0]);
        $tmpDate = explode(' - ', request()->input('range'));
        if (count($tmpDate) == 2) {
            $dateStart = Carbon::parse($tmpDate[0])->startOfDay();
            $dateEnd = Carbon::parse($tmpDate[1])->endOfDay();
            $query->whereBetween('mt.CLOSE_TIME', [$dateStart, $dateEnd]);
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
                    ->orderBy(0, 'desc')
                    ->dom('Bfrtip')
                    ->ajax([
                        'data' => 'function(d) { 
                                    d.range = $("#reportrange span").html();
                                }'
                    ])
            //         ->parameters([
            //     'lengthMenu' => [10, 25, 50, 75, 100, "All"],
            // ])
                    ->buttons(
                        Button::make('pageLength'),
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
            Column::make('TICKET')->name('mt.TICKET'),
            Column::make('LOGIN')->name('mt.LOGIN'),
            Column::make('SYMBOL')->name('mt.SYMBOL'),
            Column::make('VOLUME')->name('mt.VOLUME'),
            Column::make('TYPE')->searchable(false)->orderable(false),
            Column::make('OPEN_TIME')->name('mt.OPEN_TIME'),
            Column::make('CLOSE_TIME')->name('mt.CLOSE_TIME'),
            Column::make('LQ_TIME')->searchable(false)->orderable(false),


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
