<?php

namespace Modules\Accounting\DataTables;

use Modules\Accounting\DataTables\AccountingBaseDataTable;

use Modules\Accounting\Entities\AssetDeprecation;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class AssetsDeprecationsDataTable extends AccountingBaseDataTable
{

    protected $exportFilename = 'Assets Deprecations';

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        
        return (new EloquentDataTable($query))
            ->editColumn('code_id', function ($row){
                return $row->assetCode->breadcrumb;
            })
            ->addColumn('action', function ($row) {
                $action = '<div class="btn-group dropdown m-r-10">
                 <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default dropdown-toggle waves-effect waves-light" type="button"><i class="fa fa-gears "></i></button>
                <ul role="menu" class="dropdown-menu">';
                    $action .= '<li><a href="' . route("admin.accounting.assetsdeprecations.update", $row->id) . '"><i class="fa fa-pencil-square-o"></i> ' . __('app.edit') . '</a></li>';
                   //
                    $action .= '<li><a href="' . route("admin.accounting.assetsdeprecations.delete", $row->id) . '" onclick="confirmDelete('.$row->id.')"><i class="fa fa-trash-o"></i> ' . __('app.delete') . '</a></li>';
                    $action .= '</ul> </div>';
                return $action;
            })
            ->rawColumns(['action'])
            ->addIndexColumn();
    }


    public function query(AssetDeprecation $model): QueryBuilder
    {
        return $model->newQuery();
    }


    protected function getColumns():array
    {
    
        return 
        [
            Column::make('DT_RowIndex', 'DT_RowIndex')->title('#')->orderable(false),
            Column::make('code_id', 'code_id')->title(__('accounting::modules.accounting.code'))->sortable(false)->orderable(false)->searchable(false),   
            Column::make('numberOfYears', 'numberOfYears')->title(__('accounting::modules.accounting.numberOfYears')),
            Column::make('precentageOfDeprecation', 'precentageOfDeprecation')->title(__('accounting::modules.accounting.percentageOfDeprecation')),
            Column::computed('action', __('app.action'))->exportable(false)->printable(false)->orderable(false)->searchable(false)->width(150)->addClass('text-center'),
        ];

    }



}
