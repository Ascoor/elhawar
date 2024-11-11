<?php

namespace App\DataTables\Admin;

use App\Borrowing;
use App\DataTables\BaseDataTable;
use App\Invoice;
use App\InvoiceSetting;
use App\Notifications\BookLate;
use App\StockRequest;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class BorrowingsDataTable extends BaseDataTable
{
   
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    { ;
        return datatables()
            ->eloquent($query)
            
            ->editColumn('borrower', function ($row) {
                return ucfirst($row->borrower_name);
            })
            ->editColumn('date', function ($row) {
                return $row->borrow_date;
            })->editColumn('resources', function ($row) {
                return $row->resource_name;
            })->editColumn('due_date', function ($row) {
                return $row->due_date;
            })->editColumn('turn_in', function ($row) {
                if($row->turn_in > 0)
                return '<label class="label label-success">'. 'Turned IN' .'</label>';
                else{
                    $today =  date("Y-m-d") ;
                    if ($today > $row->due_date){
                        $user = User::find($row->borrower);
//                        send notification
                        Notification::send($user, new BookLate($row->resources));
                        return '<a > <label class="label label-danger">'. __('modules.libraries.late') .'</label><a>';
                    }
                    return '<a > <label class="label label-primary">'.  __('modules.libraries.borrowed') .'</label><a>';
                    
                }
                
            })->editColumn('issue_date', function ($row) {
                return $row->issue_date;
            })->rawColumns(['turn_in',])
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Product $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Borrowing $model)
    {
        $request = $this->request();
        $model =  $model->join('resources','resources.id','borrowings.resources')->
            join('users','users.id','borrowings.borrower')->
        select('borrowings.*','resources.name as resource_name','users.name as borrower_name');
        if ($request->status != 'all' && !is_null($request->status)) {
            if($request->status === '-1'){
                $today =  date("Y-m-d") ;
                $model = $model->where('due_date', '<', $today);
            }else
            $model = $model->where('turn_in', '=', $request->status);
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
            __('modules.libraries.borrower') => ['data' => 'borrower', 'name' => 'borrower'],
           __('modules.libraries.date') => ['data' => 'borrow_date', 'name' => 'borrow_date'],
            
           __('modules.libraries.resources') => ['data' => 'resources', 'name' => 'resources'],
           __('modules.libraries.due') => ['data' => 'due_date', 'name' => 'due_date'],
            __('app.status') => ['data' => 'turn_in', 'name' => 'turn_in'],
            
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
        return 'Borrowings_' . date('YmdHis');
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
