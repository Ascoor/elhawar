<?php

namespace App\DataTables\Admin;

use App\DataTables\BaseDataTable;

use App\ProductCategory;


use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class CategoryDataTable extends BaseDataTable
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
            ->addColumn('action', function ($row) use ($user){
                $action = '
                        <div class="btn-group dropdown m-r-10">
                        <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default dropdown-toggle waves-effect waves-light" type="button">
                            <i class="fa fa-gears "></i>
                        </button>
                      <ul role="menu" class="dropdown-menu pull-right">';
                     if($user->cans('edit_inventories'))
                      $action .= '   <li>
                         <a href="' . route('admin.categories.edit', [$row->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i> 
                         ' . trans('app.edit') . '
                         </a>
                       </li>';
                    if($user->cans('view_inventories'))
                      $action .= '
                          <li>
                         <a href="' . route('admin.categories.show', [$row->id]) . '">
                               <i class="fa fa-eye" aria-hidden="true"></i> 
                                  ' . trans('app.show') . '
                         </a>
                        </li>';
                $action .= '</ul> </div>';

                return $action;
            })
            
            ->editColumn('name', function ($row) {
                return $row->name;
            })->editColumn('description', function ($row) {
                return $row->description;
            })->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Product $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ProductCategory $model)
    {
        $request = $this->request();

        
         $model = $model->select('id','name','description');
        
        

        
        // if ($request->status != 'all' && !is_null($request->status)) {
        //     $model = $model->where('approved', '=', $request->status);
        // }

       
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
            ->setTableId('invoices-table')
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
                   window.LaravelDataTables["invoices-table"].buttons().container()
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
            __('modules.stocks.category_name') => ['data' => 'name', 'name' => 'name'],
            __('modules.stocks.category_description') => ['data' => 'description', 'name' => 'description'],
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
        return 'Categories_' . date('YmdHis');
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
