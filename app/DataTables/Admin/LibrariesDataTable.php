<?php

namespace App\DataTables\Admin;

use App\DataTables\BaseDataTable;
use App\Inventory;
use App\Resource;
use App\PurchaseTransaction;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class LibrariesDataTable extends BaseDataTable
{
    protected $firstInvoice;
    protected $invoiceSettings;
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $user =  \Auth::user();
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($row) use ($user) {
                $action = '<div class="btn-group dropdown m-r-10">
                 <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default dropdown-toggle waves-effect waves-light" type="button"><i class="fa fa-gears "></i></button>
                <ul role="menu" class="dropdown-menu">';
                    if($user->cans('edit_libraries'))
                    $action .= '<li><a href="' . route("admin.libraries.edit", $row->id) . '"><i class="fa fa-pencil-square-o"></i> ' . __('app.edit') . '</a></li>';
                $action .= '</ul> </div>';

                return $action;
            })
            
            ->editColumn('name', function ($row) {
                return $row->name;
            })->editColumn('type', function ($row) {
                return $row->resource_type;
            })->editColumn('item_in_stock', function ($row) {
                return $row->item_in_stock;
            })->editColumn('borrowed', function ($row) {
                return $row->borrowed;
            })->editColumn('borrowable', function ($row) {

                if($row->borrowable >0)
                return '<label class="label label-success"> <i class="fa fa-check" aria-hidden="true"></i>
                </label>';
                else
                '<label class="label label-success"> <i class="fa fa-times" aria-hidden="true"></i>

                </label>';
               
               
            })->rawColumns(['borrowable','action'])->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Product $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Resource $model)
    {
        $request = $this->request();

         $model = $model ->Join('resource_types','resources.type','=','resource_types.id')
         ->select('resources.*','resource_types.name as resource_type');
         ;
         if($request->type !== null && $request->type !== 'all'){
            $model = $model->where('type','=',$request->type);
         }

        return $model;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('libraries-table')
            ->columns($this->processTitle($this->getColumns()))
            ->minifiedAjax()
            ->dom("<'row'<'col-md-6'l><'col-md-6'Bf>><'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>")
            ->orderBy(0)
            ->destroy(true)
            ->responsive(true)
            ->serverSide(true)
            ->stateSave(true)
            ->processing(true)
            ->language(__("app.datatable"))
            ->buttons(
                Button::make(['extend' => 'export', 'buttons' => ['excel', 'csv'], 'text' => '<i class="fa fa-download"></i> ' . trans('app.exportExcel') . '&nbsp;<span class="caret"></span>'])
            )
            ->parameters([
                'initComplete' => 'function () {
                   window.LaravelDataTables["libraries-table"].buttons().container()
                    .appendTo( ".bg-title .text-right")
                }',
                'fnDrawCallback' => 'function( oSettings ) {
                    $("body").tooltip({
                        selector: \'[data-toggle="tooltip"]\'
                    })
                }',
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $modules = $this->user->modules;
        $dsData =  [
            __('app.id') => ['data' => 'id', 'name' => 'id', 'visible' => false],
            '#' => ['data' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
            __('modules.libraries.resource_name') => ['data' => 'name', 'name' => 'name'],
      __('modules.libraries.resource_type') => ['data' => 'resource_type', 'name' => 'resource_type', 'searchable' => false],
           __('modules.libraries.available') => ['data' => 'item_in_stock', 'name' => 'item_in_stock'],
          __('modules.libraries.borrowed') => ['data' => 'borrowed', 'name' => 'borrowed'],
           __('modules.libraries.borrowable')  => ['data' => 'borrowable', 'name' => 'borrowable', 'searchable' => false],
            Column::computed('action', __('app.action'))
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
                ->searchable(false)
                ->width(150)
                ->addClass('text-center')
            
        ];
        

        return $dsData;
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Libraries_' . date('YmdHis');
    }

    public function pdf()
    {
        set_time_limit(0);
        if ('snappy' == config('datatables-buttons.pdf_generator', 'snappy')) {
            return $this->snappyPdf();
        }

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('datatables::print', ['data' => $this->getDataForPrint()]);

        return $pdf->download($this->getFilename() . '.pdf');
    }
}
