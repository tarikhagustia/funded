<?php

namespace App\DataTables\Console;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use App\Models\AccountType;
use Yajra\DataTables\Html\Builder;
use App\Models\Console;
use Yajra\DataTables\DataTableAbstract;

class AccountTypeTable extends DataTable
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
            ->eloquent($query)
            ->addColumn('action', 'console.account_type.action')
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param Console/User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(AccountType $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('user-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->dom('Bfrtip')
                    ->buttons(
                        Button::make('create'),
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
            Column::make('account_type'),
            Column::make('meta_group_name'),
            Column::make('securities'),
            Column::make('rate'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
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
