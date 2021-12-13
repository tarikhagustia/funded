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
use Illuminate\Support\Facades\Auth;

class NetMarginBonusTable extends DataTable
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
    public function query(NetMarginBonus $model)
    {
        $query = $model->newQuery()->where('af_id', Auth::id());
        $tmpDate = explode(' - ', request()->input('range'));
        if (count($tmpDate) == 2) {
            $dateStart = Carbon::parse($tmpDate[0])->startOfDay();
            $dateEnd = Carbon::parse($tmpDate[1])->endOfDay();
            $query->where('comm_from_date', '>=', $dateStart);
            $query->where('comm_to_date', '<=', $dateEnd);
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
            Column::make('comm_from_date')->title(__('Date From')),
            Column::make('comm_to_date')->title(__('Date To')),
            Column::make('af_id')->title('Af ID'),
            Column::make('af_name')->title('Af Name'),
            Column::make('addendum')->title('Addendum Rules'),
            Column::make('total_net_margin')->title('Total Net Margin'),
            Column::make('total_commission')->title('Total Commission'),
            Column::make('status')->title('Status'),
            // Column::make('lot')->orderable(false)->searchable(false)->title('Lot'),
            // Column::make('total_commission')->orderable(false)->searchable(false)->title('Total Commission'),

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
        return 'ReferralBonus'.date('YmdHis');
    }
}
