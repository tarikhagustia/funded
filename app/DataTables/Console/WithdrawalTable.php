<?php

namespace App\DataTables\Console;

use App\Models\TransactionCrm;
use App\Models\TransactionType;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Carbon\Carbon;

class WithdrawalTable extends DataTable
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
            ->editColumn('userid',function($transaction){
                return $transaction->user->nama;
            })
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Console/TradingAccount $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(TransactionCrm $model)
    {   
        $r_type = request()->input('type');

        if($r_type){
            $type = TransactionType::where('name',$r_type)->first();
        }else{
            $type = TransactionType::where('name','Withdrawal')->first();
        }

        $query = $model->newQuery()->where('transaction_type',$type->id);

        $tmpDate = explode(' - ', request()->input('range'));
        if (count($tmpDate) == 2) {
            $dateStart = Carbon::parse($tmpDate[0])->startOfDay();
            $dateEnd = Carbon::parse($tmpDate[1])->endOfDay();
            $query->whereBetween('tdate', [$dateStart, $dateEnd]);
        }

        $query->join('status','transactions.status','=','status.id')->select('transactions.*','status.name as status_name');

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
                    ->setTableId('withdrawal-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->ajax([
                        'data' => 'function(d) {
                            d.range = $("#reportrange span").html();
                            d.type = $("#select-type").val();
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
            Column::make('userid')->title('Client'),
            Column::make('status_name')->title('Status'),
            Column::make('tdate')->title('Transaction Date'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Withdrawal_' . date('YmdHis');
    }
}
