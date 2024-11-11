<?php

namespace Modules\Accounting\DataTables;

use Illuminate\Support\Str;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\Accounting\Entities\Insurance;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class InsurancesDataTable extends AccountingBaseDataTable
{
    protected $exportFilename = 'Insurances';


    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($row) {
                $action = '<div class="btn-group dropdown m-r-10">
                 <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default dropdown-toggle waves-effect waves-light" type="button"><i class="fa fa-gears "></i></button>
                <ul role="menu" class="dropdown-menu">';
                    $action .= '<li><a href="' . route("admin.accounting.insurances.update", $row->id) . '"><i class="fa fa-pencil-square-o"></i> ' . __('app.edit') . '</a></li>';
                    $action .= '<li><a href="#" onclick="confirmDelete('.$row->id.')"><i class="fa fa-trash-o"></i> ' . __('app.delete') . '</a></li>';
                    $action .= '</ul> </div>';

                return $action;
            })
            ->editColumn('purpose',function ($row){return Str::words($row->purpose, 10,'...');})
            ->rawColumns(['action'])
            ->addIndexColumn();
    }


    public function query(Insurance $model): QueryBuilder
    {
        $model= $model->newQuery();
        $request=$this->request();

        if (!is_null($request->input('startDate')) && is_null($request->input('endDate')))
        {
            $model->where('returnDate','>=',(new Carbon($request->input('startDate')))->toDateString());
        }
        elseif (is_null($request->input('startDate')) && !is_null($request->input('endDate')))
        {
            $model->where('returnDate','<=',(new Carbon($request->input('endDate')))->toDateString());
        }
        elseif(!is_null($request->input('startDate')) && !is_null($request->input('endDate')))
        {
            $model->whereBetween('returnDate',[(new Carbon($request->input('startDate')))->toDateString(),(new Carbon($request->input('endDate')))->toDateString()]);
        }

        if (!is_null($request->input('insuranceType')) && $request->input('insuranceType') !== 'all') {

            $model->where('insurance_type_id', '=', $request->input('insuranceType'));
       }

        return $model;
    }



    protected function getColumns():array
    {
    
        return 
        [
            Column::make('DT_RowIndex', 'DT_RowIndex')->title('#')->orderable(false)->searchable(false),
            Column::make('insuranceType', 'insuranceType')->title( __('accounting::modules.accounting.insuranceType'))->orderable(false)->searchable(false),
            Column::make('amount', 'amount')->title(__('accounting::modules.accounting.amount')),
            Column::make('purpose', 'purpose')->title( __('accounting::modules.accounting.insurancePurpose')),
            Column::make('paymentDate', 'paymentDate')->title(__('accounting::modules.accounting.paymentDate')),
            Column::make('returnDate', 'returnDate')->title(__('accounting::modules.accounting.returnDate')),
            Column::computed('action', __('app.action'))->exportable(false)->printable(false)->orderable(false)->searchable(false)->width(150)->addClass('text-center'),
        ];

    }


}
