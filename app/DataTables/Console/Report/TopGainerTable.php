<?php

namespace App\DataTables\Console\Report;

use App\Models\Af;
use Carbon\Carbon;
use App\Models\MetaTrade;
use App\Models\TransactionType;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class TopGainerTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
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
     * @param \App\Models\Console/TradingAccount $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {

        $query = DB::connection('mt4')->table('MT4_TRADES', 'mt')
                   ->join('MT4_USERS as u', 'u.LOGIN', '=', 'mt.LOGIN')
                   ->select(['mt.LOGIN', DB::raw('SUM(PROFIT) as TOTAL'), 'u.EMAIL', 'u.NAME'])
                   ->whereIn('CMD', [1, 0])
                   ->groupBy('u.LOGIN')
                   ->orderByRaw('SUM(PROFIT) DESC');

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
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('top-gainer-table')
                    ->columns($this->getColumns())
                    ->fixedHeader(true)
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->ajax([
                        'data' => 'function(d) {
                            d.range = $("#reportrange span").html();
                        }'
                    ])
                    ->buttons(
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
            Column::make('DT_RowIndex')->title(__('No'))->orderable(false)->searchable(false),
            Column::make('LOGIN')->title('Login'),
            Column::make('NAME')->title('Name'),
            Column::make('EMAIL')->title('Email'),
            Column::make('TOTAL')->title('Total Profit'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'TopGainer_' . date('YmdHis');
    }
}
