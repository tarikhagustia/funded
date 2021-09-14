<?php

namespace App\DataTables\Console;

use App\Models\Account;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class TradingAccountDataTable extends DataTable
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
            ->editColumn('accountid',function($account){
                return '<a href="'.route('console.trading_accounts.view',$account->id).'">'.$account->accountid.'</a>';
            })
            ->editColumn('account_type',function($account){
                return $account->group->type_name;
            })
            ->editColumn('currency',function($account){
                return $account->currency->symbol.$account->currency->rate;
            })
            ->editColumn('name',function($account){
                return $account->client ? $account->client->nama : '-';
            })
            ->rawColumns(['accountid'])
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Console/TradingAccount $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Account $model)
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
                    ->setTableId('trading-account-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
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
            Column::make('accountid')->title('Account'),
            Column::make('name')->title('Name'),
            Column::make('account_type')->title('Account Type'),
            Column::make('currency')->title('Currency'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'TradingAccount_' . date('YmdHis');
    }
}
