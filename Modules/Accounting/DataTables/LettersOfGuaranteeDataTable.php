<?php

namespace Modules\Accounting\DataTables;

use Illuminate\Support\Str;
use Modules\Accounting\Entities\Letter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class LettersOfGuaranteeDataTable extends AccountingBaseDataTable
{
    protected $exportFilename = 'Letters';



    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($row) {
                $action = '<div class="btn-group dropdown m-r-10">
                 <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default dropdown-toggle waves-effect waves-light" type="button"><i class="fa fa-gears "></i></button>
                <ul role="menu" class="dropdown-menu">';
                    $action .= '<li><a href="' . route("admin.accounting.lettersofguarantee.update", $row->id) . '"><i class="fa fa-pencil-square-o"></i> ' . __('app.edit') . '</a></li>';
                    $action .= '<li><a href="#" onclick="confirmDelete('.$row->id.')"><i class="fa fa-trash-o"></i> ' . __('app.delete') . '</a></li>';
                    $action .= '</ul> </div>';

                return $action;
            })
            ->editColumn('description',function ($row){return Str::words($row->description, 10,'...');})
            ->rawColumns(['action'])
            ->addIndexColumn();
    }


    public function query(Letter $model): QueryBuilder
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

        if (!is_null($request->input('letterType')) && $request->input('letterType') !== 'all') {

            $model->where('letterType', '=', $request->input('letterType'));
       }

        return $model;
    }


    protected function getColumns():array
    {
    
        return 
        [
            Column::make('DT_RowIndex', 'DT_RowIndex')->title('#')->orderable(false)->searchable(false),
            Column::make('letterNumber', 'letterNumber')->title(__('accounting::modules.accounting.letterNumber')),
            Column::make('lettype', 'lettype')->title(__('accounting::modules.accounting.letterType'))->orderable(false)->searchable(false),
            Column::make('description', 'description')->title( __('accounting::modules.accounting.letterDescription')),
            Column::make('issuedToCompany', 'issuedToCompany')->title( __('accounting::modules.accounting.issuedToCompany')),
            Column::make('issuingBank', 'issuingBank')->title(__('accounting::modules.accounting.issuingBank')),
            Column::make('amount', 'amount')->title(__('accounting::modules.accounting.amount')),
            Column::make('issuingDate', 'issuingDate')->title(__('accounting::modules.accounting.issuingDate')),
            Column::make('expirationDate', 'expirationDate')->title(__('accounting::modules.accounting.expirationDate')),
            Column::computed('action', __('app.action'))->exportable(false)->printable(false)->orderable(false)->searchable(false)->width(150)->addClass('text-center'),
        ];

    }


}
