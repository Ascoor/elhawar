<?php

namespace App\DataTables\Admin;

use App\DataTables\BaseDataTable;
use App\PurchaseRequest;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Button;

    class PurchasesDataTable extends BaseDataTable
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
           ->editColumn('total', function ($row) {
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

            })->editColumn('clubMangerApproval', function ($row) {
                $taskbar="";
                if($row->approved < 30){
                    if($row->approved == 0){
                        if(auth()->user()->getUserOtherRoleAttribute()=="club_manger"){
                            $taskbar.='<a href="' . route('admin.purchases.disapprove-request',$row->id) . '"> <label class="label label-danger">'. __("app.reject") .'</label><a>';
                            $taskbar.='<a href="' . route('admin.purchases.approve-request',$row->id) . '"> <label class="label label-success">'. __("modules.purchases.approve") .'</label><a>';
                        }else{
                            $taskbar.='<label class="label label-danger">'. 'منتظر' .'</label><a>';
                        }
                        return $taskbar;
                    }else if($row->approved > 0){
                        return $taskbar.'<label class="label label-primary">'. __('modules.purchases.approved') .'</label>';
                    }
                }else{
                    if($row->approved == 31){
                    return $taskbar.'<label class="label label-danger">'. __('modules.purchases.not_approved') .'</label>';
                }
            }
            })->editColumn('cancelRequest', function ($row) {
                $taskbar="";
                if($row->approved==3 && auth()->user()->getUserOtherRoleAttribute()=="admin_purchase"){
                    $taskbar.='<div class="form-group"><button onclick="printRequest('.$row->id.')" class="btn btn-success"><i class="fa fa-print"></i></button></div>';
                }else if($row->approved <3){
                    if(auth()->user()->getUserOtherRoleAttribute()=="employee"){
                        $taskbar.='<a href="javascript:;" data-toggle="tooltip" data-original-title="Delete" data-file-id="'.$row->id.'"data-pk="list" class="btn btn-danger btn-circle sa-params"><i class="fa fa-times"></i></a>';
                    }
                }
                return $taskbar;
            })->editColumn('clubCEOApproval', function ($row) {
                $taskbar="";
                if($row->approved < 30){
                    if($row->approved == 2){
                        if(auth()->user()->getUserOtherRoleAttribute()=="ceo"){
                            $taskbar.='<a href="' . route('admin.purchases.disapprove-request',$row->id) . '"> <label class="label label-danger">'. __("app.reject") .'</label><a>';
                            $taskbar.='<a href="' . route('admin.purchases.approve-request',$row->id) . '"> <label class="label label-success">'. __("modules.purchases.approve") .'</label><a>';
                        }else{
                            $taskbar.='<label class="label label-danger">'. 'منتظر' .'</label><a>';
                        }
                        return $taskbar;
                    }else if($row->approved > 2){
                        return $taskbar.'<label class="label label-primary">'. __('modules.purchases.approved') .'</label>';
                    }
                    }else{
                        if($row->approved == 33){
                        return $taskbar.'<label class="label label-danger">'. __('modules.purchases.not_approved') .'</label>';
                    }
                }
            })->editColumn('clubTreasuryApproval', function ($row) {
                $taskbar="";
                if($row->approved < 30){
                    if($row->approved == 1){
                        if(auth()->user()->getUserOtherRoleAttribute()=="treasury"){
                            $taskbar.='<a href="' . route('admin.purchases.disapprove-request',$row->id) . '"> <label class="label label-danger">'. __("app.reject") .'</label><a>';
                            $taskbar.='<a href="' . route('admin.purchases.approve-request',$row->id) . '"> <label class="label label-success">'. __("modules.purchases.approve") .'</label><a>';
                        }else{
                            $taskbar.='<label class="label label-danger">'. 'منتظر' .'</label><a>';
                        }
                        return $taskbar;
                        }else if($row->approved > 1){
                            return $taskbar.'<label class="label label-primary">'. __('modules.purchases.approved') .'</label>';
                        }
                    }else{
                        if($row->approved == 32){
                        return $taskbar.'<label class="label label-danger">'. __('modules.purchases.not_approved') .'</label>';
                    }
                }
            })->editColumn('issue_date', function ($row) {
                return $row->issue_date;
            })->rawColumns(['clubMangerApproval','clubTreasuryApproval','clubCEOApproval','cancelRequest','products'])
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param PurchaseRequest $model
     * @return Builder
     */
    public function query(PurchaseRequest $model)
    {
        $request = $this->request();
        $model =  $model
            ->join('users','users.id','purchase_requests.created_by')
            ->select('purchase_requests.id',  'users.name as created_by', 'purchase_requests.total', 'purchase_requests.products', 'purchase_requests.issue_date','purchase_requests.approved' , 'purchase_requests.created_by as creator');
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
//            __('modules.purchases.type')  => ['data' => 'type', 'name' => 'type'],
        __('modules.purchases.created_by')    => ['data' => 'created_by', 'name' => 'created_by'],
         __('modules.purchases.products_quantity')  => ['data' => 'products', 'name' => 'products'],
         __('modules.purchases.total')  => ['data' => 'total', 'name' => 'total'],
         __('modules.purchases.request_date')    => ['data' => 'issue_date', 'name' => 'issue_date'],
            __('app.clubMangerApproval') => ['data' => 'clubMangerApproval', 'name' => 'clubMangerApproval'],
            __('app.clubTreasuryApproval') => ['data' => 'clubTreasuryApproval', 'name' => 'clubTreasuryApproval'],
            __('app.clubCEOApproval') => ['data' => 'clubCEOApproval', 'name' => 'clubCEOApproval'],
            __('app.cancelRequest') => ['data' => 'cancelRequest', 'name' => 'cancelRequest'],

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
