<?php

namespace App\DataTables\Console\Report;

use Carbon\Carbon;
use App\Models\AfCommission;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class TopCommissionTable extends DataTable
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
            ->eloquent($query)
            ->editColumn('email',function($af){
                return $af->agent->agentemail;
            })
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Console/TradingAccount $model
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
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('top-commission-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->fixedHeader(true)
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
            Column::make('af_name')->title('Name'),
            Column::make('email')->title('Email'),
            Column::make('af_level')->title('Level'),
            Column::make('total_commission')->title('Total Commission'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'TopCommission_' . date('YmdHis');
    }
}
