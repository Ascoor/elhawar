<?php

namespace Modules\Accounting\DataTables;

use Modules\Accounting\DataTables\AccountingBaseDataTable;

use Illuminate\Support\Str;
use Modules\Accounting\Entities\Loan;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class LoansDataTable extends AccountingBaseDataTable
{

    protected $exportFilename = 'Loans';

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($row) {
                $action = '<div class="btn-group dropdown m-r-10">
                 <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default dropdown-toggle waves-effect waves-light" type="button"><i class="fa fa-gears "></i></button>
                <ul role="menu" class="dropdown-menu">';
                    $action .= '<li><a href="' . route("admin.accounting.loans.update", $row->id) . '"><i class="fa fa-pencil-square-o"></i> ' . __('app.edit') . '</a></li>';
                    $action .= '<li><a href="#" onclick="confirmDelete('.$row->id.')"><i class="fa fa-trash-o"></i> ' . __('app.delete') . '</a></li>';
                    $action .= '</ul> </div>';

                return $action;
            })
            ->editColumn('description',function ($row){return Str::words($row->description, 10,'...');})
            ->rawColumns(['action'])
            ->addIndexColumn();
    }


    public function query(Loan $model): QueryBuilder
    {
        $model= $model->newQuery();
        $request=$this->request();

        if (!is_null($request->input('startDate')) && is_null($request->input('endDate')))
        {
            $model->where('expirationDate','>=',(new Carbon($request->input('startDate')))->toDateString());
        }
        elseif (is_null($request->input('startDate')) && !is_null($request->input('endDate')))
        {
            $model->where('expirationDate','<=',(new Carbon($request->input('endDate')))->toDateString());
        }
        elseif(!is_null($request->input('startDate')) && !is_null($request->input('endDate')))
        {
            $model->whereBetween('expirationDate',[(new Carbon($request->input('startDate')))->toDateString(),(new Carbon($request->input('endDate')))->toDateString()]);
        }

        return $model;
    }


    protected function getColumns():array
    {
    
        return 
        [
            Column::make('DT_RowIndex', 'DT_RowIndex')->title('#')->orderable(false)->searchable(false),
            Column::make('borrower', 'borrower')->title(__('accounting::modules.accounting.borrower')),   
            Column::make('description', 'description')->title(__('accounting::modules.accounting.loanDescription')),                   
            Column::make('amount', 'amount')->title(__('accounting::modules.accounting.amount')),
            Column::make('issuingDate', 'issuingDate')->title(__('accounting::modules.accounting.issuingDate')),
            Column::make('expirationDate', 'expirationDate')->title(__('accounting::modules.accounting.claimingDate')),
            Column::computed('action', __('app.action'))->exportable(false)->printable(false)->orderable(false)->searchable(false)->width(150)->addClass('text-center'),
        ];

    }



}
