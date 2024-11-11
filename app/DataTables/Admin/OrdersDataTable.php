<?php

namespace App\DataTables\Admin;

use App\DataTables\BaseDataTable;
use App\MembersOrder;
use App\MembresOrder;
use App\StockRequest;

use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;


class OrdersDataTable extends BaseDataTable
{
    
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
                 <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default dropdown-toggle waves-effect waves-light" type="button">
                 <i class="fa fa-gears "></i>
                 </button>
                <ul role="menu" class="dropdown-menu pull-right">
                  <li>
                  <a href="' . route('admin.orders.survey', [$row->id]) . '">
                  <i class="fa fa-pencil" aria-hidden="true"></i> '.__("modules.orders.vote"). '</a>
                  </li>';
                $user = \Auth::user();



                  if ($user->hasRole('B')){
                      $action.= '
                  <li>
                  <a href="' . route('admin.orders.reply', [$row->id]) . '">
                  <i class="fa fa-eye" aria-hidden="true"></i> '.__("modules.orders.show"). '</a>
                  </li>
                 ';
                  }


                $action .= '</ul> </div>';

                return $action;
            })
            ->editColumn('created_by', function ($row) {
                return ucfirst($row->created_by);
            })
            ->editColumn('name', function ($row) {
                return $row->name;
            })->editColumn('created_by', function ($row) {
                return $row->created;
            })->editColumn('directed_to', function ($row) {
                return $row->directed;
            })->editColumn('date', function ($row) {
                return $row->date;
            })->editColumn('due_date', function ($row) {
                return $row->due_date;
            })->editColumn('state', function ($row) {
                $today = date("Y-m-d");
                $user = \Auth::user();
                $user_id = $user->id;
                $details = DB::table('employee_details')->where('user_id', '=' , $user_id)->get();
                $can_reply = 0;
                foreach ($details as $detail){
                    if($detail->department_id === $row->directed_to){
                      $can_reply= 1;
                    }
                }
                if($can_reply){
                if($row->state > 0)
                return '<label class="label label-danger">'. 'Closed' .'</label>';
                elseif ($row->due_date < $today)
                    return '<a href="'.route('admin.orders.reply', $row->id).' " class="label label-danger">'. __('modules.orders.late') .'</label><a>';
                return '<a href="'.route('admin.orders.reply', $row->id).' " class="label label-primary">'. __('modules.orders.reply') .'</label><a>';
                }
                return ;
            })->rawColumns(['state','action'])
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Product $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(MembersOrder $model)
    {

        $request = $this->request();
        $model =  $model
        ->join('users','users.id','members_orders.directed_to')
        ->join('users as by','by.id','members_orders.created_by')
        ->select('members_orders.*', 'by.name as created','users.name as directed');

        if ($request->status != 'all' && !is_null($request->status)) {
            $model = $model->where('state', '=', $request->status);
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
            __('modules.orders.order_name') => ['data' => 'name', 'name' => 'name'],
            __('modules.orders.created_by') => ['data' => 'created_by', 'name' => 'created_by'],
           __('modules.orders.directed_to') => ['data' => 'directed_to', 'name' => 'directed_to'],
           __('modules.orders.created_at')=> ['data' => 'date', 'name' => 'date'],
           __('modules.orders.due')  => ['data' => 'due_date', 'name' => 'due_date'],
            __('app.status') => ['data' => 'state', 'name' => 'state'],
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
        return 'Orders_' . date('YmdHis');
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
