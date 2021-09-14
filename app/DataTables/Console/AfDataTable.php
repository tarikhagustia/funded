<?php

namespace App\DataTables\Console;

use App\Models\Af;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AfDataTable extends DataTable
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
            ->editColumn('agentname', function ($agent) {
                return '<a href="'.route('console.affiliates.show',$agent->id).'">'.$agent->agentname.'</a>';
            })
            ->rawColumns(['agentname'])
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Af $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Af $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('clent-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
            ->dom('Bfrtip')
            ->buttons(
                Button::make('export'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
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
            Column::make('createddate')->title('Registration Date'),
            Column::make('agentname')->title('Name'),
            Column::make('agentemail'),
            Column::make('agentphone')->title('Phone Number'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Af_' . date('YmdHis');
    }
}
