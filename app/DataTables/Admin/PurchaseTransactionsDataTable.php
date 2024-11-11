<?php

namespace App\DataTables\Admin;

use App\DataTables\BaseDataTable;
use App\Inventory;
use App\PurchaseTransaction;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class PurchaseTransactionsDataTable extends BaseDataTable
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
        
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($row) {
                $action = '<div class="btn-group dropdown m-r-10">
                 <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default dropdown-toggle waves-effect waves-light" type="button"><i class="fa fa-gears "></i></button>
                <ul role="menu" class="dropdown-menu">';
                    $action .= '<li><a href="' . route("admin.stocks.show", $row->id) . '"><i class="fa fa-eye"></i> ' . __('modules.stocks.show') . '</a></li>';
                    $action .= '<li><a href="' . route("admin.stocks.edit", $row->id) . '"><i class="fa fa-pencil-square-o"></i> ' .  __('modules.stocks.show')  . '</a></li>';
                $action .= '</ul> </div>';

                return $action;
            })
            
            ->editColumn('product', function ($row) {
                return $row->name;
            })->editColumn('prev', function ($row) {
                return $row->prev;
            })->editColumn('current', function ($row) {
                return $row->current;
            })->editColumn('date', function ($row) {
                return $row->date;
            })->editColumn('state', function ($row) {

                if($row->state >0)
                return '<label class="label label-success"> <i class="fa fa-arrow-up" aria-hidden="true"></i> </label>';
                elseif($row->state <0)
                return '<label class="label label-danger">  <i class="fa fa-arrow-down" aria-hidden="true"></i> </label>';
                else return '<label class="label label-primary"> - </label>';
                
               
            })->rawColumns(['state','action'])->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Product $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(PurchaseTransaction $model)
    {
        $request = $this->request();
    //    dd($request->status);
         $model = $model ->Join('product_inventories', 'stock_transactions.product', '=', 'product_inventories.id')
         ->Join('products','products.id','=','product_inventories.product')
         ->select('stock_transactions.*','products.name')
         ->distinct('stock_transactions.product')
         ;


         if($request->product !== null && $request->product !== 'all'){

            $model = $model->where('stock_transactions.product','=',$request->product);

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
            __('modules.stocks.product')  => ['data' => 'product', 'name' => 'product'],
           __('modules.stocks.prev') => ['data' => 'prev', 'name' => 'prev'],
           __('modules.stocks.current') => ['data' => 'current', 'name' => 'current'],
           __('modules.stocks.date') => ['data' => 'date', 'name' => 'date'],
         __('modules.stocks.state') => ['data' => 'state', 'name' => 'state'],
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
        return 'Transactions_' . date('YmdHis');
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
