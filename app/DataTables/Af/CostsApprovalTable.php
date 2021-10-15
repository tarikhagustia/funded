<?php

namespace App\DataTables\Af;

use Carbon\Carbon;
use App\Models\AfOperational;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Builder;
use Illuminate\Support\Facades\Auth;
use App\Services\AfCommissionService;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Services\DataTable;

class CostsApprovalTable extends DataTable
{

    private $user;

    public function __construct()
    {
        $this->user = auth()->user();
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
            ->editColumn('name',function($model){
                return $model->agent->agentname;
            })
            ->addColumn('action', 'af.operations.approval.action')
            ->addIndexColumn()
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param Console/User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $query = AfOperational::where('af_id', '!=',Auth::id())->where('status','Pending');

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
     * @return Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('approval-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(0, 'desc')
                    ->dom('Bfrtip')
                    ->buttons(
                        // Button::make('create'),
                        // Button::make('export'),
                        // Button::make('print')
                        Button::make('reset')
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
            Column::make('title')->title('Title'),
            Column::make('name')->title('Name'),
            Column::make('status')->title('Status'),
            Column::make('total')->title('Total'),

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
        return 'CostsApproval_'.date('YmdHis');
    }
}
