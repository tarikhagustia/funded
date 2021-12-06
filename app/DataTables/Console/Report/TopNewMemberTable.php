<?php

namespace App\DataTables\Console\Report;

use App\Models\Af;
use App\Models\TransactionType;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Carbon\Carbon;

class TopNewMemberTable extends DataTable
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
            ->editColumn('total_new_member',function($agent){
                return $agent->clients->count();
            })
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Console/TradingAccount $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Af $model)
    {

        $query = $model->newQuery();

        $tmpDate = explode(' - ', request()->input('range'));
        if (count($tmpDate) == 2) {
            $dateStart = Carbon::parse($tmpDate[0])->startOfDay();
            $dateEnd = Carbon::parse($tmpDate[1])->endOfDay();
            $query->whereBetween('createddate', [$dateStart, $dateEnd]);
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
                    ->setTableId('top-new-member-table')
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
            Column::make('id')->title('Af ID'),
            Column::make('agentname')->title('Af Name'),
            Column::make('agentemail')->title('Email'),
            Column::make('total_new_member')->title('Total New Member')->searchable(false),
            Column::make('level_on_group')->title('Level'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'TopNewMember_' . date('YmdHis');
    }
}
