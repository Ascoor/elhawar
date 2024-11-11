<?php

namespace Modules\Accounting\DataTables;

use Modules\Accounting\Entities\BankTransfer;

use App\DataTables\BaseDataTable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class BankTransfersDataTable extends AccountingBaseDataTable
{
    protected $exportFilename = 'BankTransfers';


    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($row) {
                $action = '<div class="btn-group dropdown m-r-10">
                 <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default dropdown-toggle waves-effect waves-light" type="button"><i class="fa fa-gears "></i></button>
                <ul role="menu" class="dropdown-menu">';
                    $action .= '<li><a href="' . route("admin.accounting.banktransfers.update", $row->id) . '"><i class="fa fa-pencil-square-o"></i> ' . __('app.edit') . '</a></li>';
                    $action .= '<li><a href="#" onclick="confirmDelete('.$row->id.')"><i class="fa fa-trash-o"></i> ' . __('app.delete') . '</a></li>';
                    $action .= '</ul> </div>';

                return $action;
            })
            ->editColumn('status',function ($row){return ($row->status == 'in')?__('accounting::modules.accounting.inbound'):__('accounting::modules.accounting.outgoing');})
            ->rawColumns(['action'])
            ->addIndexColumn();
    }


    public function query(BankTransfer $model): QueryBuilder
    {
        $model= $model->newQuery();
        $request=$this->request();

        if (!is_null($request->input('startDate')) && is_null($request->input('endDate')))
        {
            $model->where('date','>=',(new Carbon($request->input('startDate')))->toDateString());
        }
        elseif (is_null($request->input('startDate')) && !is_null($request->input('endDate')))
        {
            $model->where('date','<=',(new Carbon($request->input('endDate')))->toDateString());
        }
        elseif(!is_null($request->input('startDate')) && !is_null($request->input('endDate')))
        {
            $model->whereBetween('date',[(new Carbon($request->input('startDate')))->toDateString(),(new Carbon($request->input('endDate')))->toDateString()]);
        }

        if (!is_null($request->input('status')) && $request->input('status') !== 'all') {

            $model->where('status', '=', $request->input('status'));
       }

        if (!is_null($request->input('accountType')) && $request->input('accountType') !== 'all') {

            $model->where('bank_account_type_id', '=', $request->input('accountType'));
       }

        return $model;
    }


    protected function getColumns():array
    {
    
        return 
        [
            Column::make('DT_RowIndex', 'DT_RowIndex')->title('#')->orderable(false)->searchable(false),
            Column::make('number', 'number')->title(__('accounting::modules.accounting.transferNumber')),
            Column::make('AccountType', 'AccountType')->title(__('accounting::modules.accounting.accountType'))->orderable(false)->searchable(false),
            Column::make('status', 'status')->title( __('accounting::modules.accounting.status'))->orderable(false)->searchable(false),
            Column::make('date', 'date')->title( __('accounting::modules.accounting.date')),
            Column::make('bankName', 'bankName')->title(__('accounting::modules.accounting.bankName')),
            Column::make('recipient', 'recipient')->title(__('accounting::modules.accounting.recipient')),
            Column::make('amount', 'amount')->title(__('accounting::modules.accounting.amount')),
            Column::computed('action', __('app.action'))->exportable(false)->printable(false)->orderable(false)->searchable(false)->width(150)->addClass('text-center'),
        ];

    }



 

}
