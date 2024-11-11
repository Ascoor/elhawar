<?php

namespace App\DataTables\Admin;

use App\DataTables\BaseDataTable;
use App\Invoice;
use App\InvoiceSetting;
use App\StockRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class RequestsDataTable extends BaseDataTable
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
            
            ->editColumn('created_by', function ($row) {
                return ucfirst($row->created_by);
            })
            ->editColumn('type', function ($row) {
                return $row->type;
            })->editColumn('total', function ($row) {
                return $row->total;
            })->editColumn('products', function ($row) {
                $products_elm = '<div class="text-left">';
                $products = json_decode($row->products);
                foreach ($products as $product){
                    $products_elm.= '<div class="row m-b-5">
                                      <label class="label label-inverse m-r-5">'.$product->name.'</label>
                                      <label class="label label-success">'.$product->quantity.'</label>
                                       </div>';
                }
               return $products_elm.'</div>';

            })->editColumn('approved', function ($row) {
                $user =  \Auth::user();
                $user_id = $user->id;
                $isAdmin = $user->hasRole('admin');
                if($row->approved > 0)
                return '<label class="label label-primary">'. __('modules.stocks.approved') .'</label>';
                if($isAdmin)
                return '<a href="' . route('admin.stocks.approve-request', [$row->type,$row->id]) . '"> <label class="label label-danger">'. __("modules.stocks.approve") .'</label><a>';
                else return '<label class="label label-danger">'. __('modules.stocks.not_approved') .'</label>';

            })->editColumn('issue_date', function ($row) {
                return $row->issue_date;
            })->rawColumns(['approved','products'])
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Product $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(StockRequest $model)
    {
        $request = $this->request();
        $model =  $model->join('request_types','request_types.id','stock_requests.type')
            ->join('users','users.id','stock_requests.created_by')
            ->select('stock_requests.id', 'request_types.name as type', 'users.name as created_by', 'stock_requests.total', 'stock_requests.products', 'stock_requests.issue_date','stock_requests.approved');
        if ($request->status != 'all' && !is_null($request->status)) {
            $model = $model->where('approved', '=', $request->status);
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
            __('modules.stocks.type')  => ['data' => 'type', 'name' => 'type'],
        __('modules.stocks.created_by')    => ['data' => 'created_by', 'name' => 'created_by'],
         __('modules.stocks.products_quantity')  => ['data' => 'products', 'name' => 'products'],
         __('modules.stocks.total')  => ['data' => 'total', 'name' => 'total'],
         __('modules.stocks.request_date')    => ['data' => 'issue_date', 'name' => 'issue_date'],
            __('app.status') => ['data' => 'approved', 'name' => 'approved'],
            
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
        return 'Requests_' . date('YmdHis');
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
