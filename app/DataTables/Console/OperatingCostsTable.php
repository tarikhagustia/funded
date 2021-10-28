<?php

namespace App\DataTables\Console;

use App\Models\Af;
use Carbon\Carbon;
use App\Models\MetaTrade;
use App\Models\AfOperational;
use App\Models\TransactionType;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class OperatingCostsTable extends DataTable
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
            ->editColumn('af_id',function($model){
                return $model->agent->agentname ?? '-';
            })
            ->editColumn('approval_af_id',function($model){
                return $model->agentApproval->agentname ?? '-';
            })
            ->editColumn('total',function($model){
                return number_format($model->total);
            })->editColumn('status',function($model){
                switch ($model->status) {
                    case 'Approved':
                        return "<span class='badge badge-success'>$model->status</status>";
                        break;

                    case 'Rejected':
                        return "<span class='badge badge-danger'>$model->status</status>";
                        break;

                    default:
                        return "<span class='badge badge-warning'>$model->status</status>";
                        break;
                }
            })
            ->addColumn('action', 'console.operating_costs.action')
            ->addIndexColumn()
            ->rawColumns(['action','status']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Console/TradingAccount $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(AfOperational $model)
    {

        $query = $model->newQuery();

        $tmpDate = explode(' - ', request()->input('range'));
        if (count($tmpDate) == 2) {
            $dateStart = Carbon::parse($tmpDate[0])->startOfDay();
            $dateEnd = Carbon::parse($tmpDate[1])->endOfDay();
            $query->whereBetween('date', [$dateStart, $dateEnd]);
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
                    ->setTableId('operating-costs-table')
                    ->columns($this->getColumns())
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
            Column::make('af_id')->title('Agent'),
            Column::make('approval_af_id')->title('Approval Agent'),
            Column::make('title')->title('Title'),
            Column::make('total')->title('Total'),
            Column::make('status')->title('Status'),
            Column::make('date')->title('Date'),

            Column::computed('action')
                  ->exportable(false)
                  ->printable(false),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'OperatingCosts_' . date('YmdHis');
    }
}
