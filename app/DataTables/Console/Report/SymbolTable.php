<?php

namespace App\DataTables\Console\Report;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder;
use App\Models\Console;
use Yajra\DataTables\DataTableAbstract;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SymbolTable extends DataTable
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

    public function query()
    {
        $query = DB::connection('mt4')
                   ->table('MT4_PRICES', 's')->join('MT4_TRADES as mt', 'mt.SYMBOL', '=', 's.SYMBOL')
                   ->select(
                       [
                           's.SYMBOL as symbol',
                           's.BID as bid',
                           's.ASK as ask',
                           DB::raw('COUNT(mt.TICKET) as total_position'),
                           DB::raw('SUM(mt.VOLUME / 100) as total_lot'),
                           DB::raw('SUM(mt.PROFIT) as total_profit'),
                       ])
                   ->whereIn('mt.CMD', [1, 0])
                   ->whereYear('mt.CLOSE_TIME', 1970)
                   ->groupBy('s.SYMBOL');

        $tmpDate = explode(' - ', request()->input('range'));
        if (count($tmpDate) == 2) {
            $dateStart = Carbon::parse($tmpDate[0])->startOfDay();
            $dateEnd = Carbon::parse($tmpDate[1])->endOfDay();
            $query->whereDate('mt.OPEN_TIME', '>=', $dateStart)
                  ->whereDate('mt.OPEN_TIME', '<=', $dateEnd);
        }
        // dd($query->toSql());
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
                    ->setTableId('statistic-symbol-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(0, 'desc')
                    ->dom('Bfrtip')
                    ->stateSave(true)
                    ->ajax([
                        'data' => 'function(d) { 
                                    d.range = $("#reportrange span").html();
                                }'
                    ])
                    ->buttons(
                    // Button::make('create'),
                        Button::make('colvis'),
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
            Column::make('symbol')->name('s.SYMBOL'),
            Column::make('bid')->searchable(false),
            Column::make('ask')->searchable(false),
            Column::make('total_position')->searchable(false),
            Column::make('total_lot')->searchable(false),
            Column::make('total_profit')->searchable(false),

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
