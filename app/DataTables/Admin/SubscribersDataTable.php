<?php

namespace App\DataTables\Admin;

use App\DataTables\BaseDataTable;
use App\Invoice;
use App\InvoiceItems;
use App\memberDetails;
use App\SessionMember;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PayPal\Api\InvoiceItem;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class SubscribersDataTable extends BaseDataTable
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
                if ($row->status=='waiting'){
                    $action = '<div class="btn-group dropdown m-r-10">
                  <a href="javascript:;"  data-user-id="' . $row->user_id . '"  data-session-id="' . $row->sess_id . '" class="btn btn-default save-event waves-effect waves-light" type="button" ><i class="fa fa-money" aria-hidden="true"></i>'. trans('app.subscribe') . '</a>

                  <a href="javascript:;"  data-user-id="' . $row->id . '"  class="btn btn-default sa-params waves-effect waves-light" type="button" ><i class="fa fa-times" aria-hidden="true"></i></a>
                </div>';
                }else{
                    $action = '<div class="btn-group dropdown m-r-10">
                  <a href="javascript:;"  data-user-id="' . $row->id . '"  class="btn btn-default sa-params waves-effect waves-light" type="button" ><i class="fa fa-times" aria-hidden="true"></i></a>
                </div>';
                }

//                    $action .= '</ul> </div>';}

                return $action;
            })
            ->editColumn(
                'name',
                function ($row) {
                    return '<a href="' . route('admin.members.show', $row->id) . '">' . ucfirst($row->name) . '</a>';
                }
            )
            ->editColumn(
                    'session_name',
                    function ($row) {
                        $item=InvoiceItems::where('item_name' , $row->session_name.' #'.$row->session_id)->first();
                        $invoice=Invoice::where('id' , $item->invoice_id)->first();
                        $status=$invoice->status;
                        $ulist=$row->session_name.'  ';
//                    $ulist=$row->trip_name;
                        if ($status=='unpaid'){
                            $ulist.='<label class="label label-danger">' . __('app.' . $status) . '</label>';
                        }elseif($status=='paid'){
                            $ulist='<label class="label label-success">' . __('app.' . $status) . '</label>';

                        }
                        return $ulist;
                    }
                )

            ->addIndexColumn()
            ->rawColumns(['name', 'mobile','action', 'session_name']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(SessionMember $model)
    {
        $request = $this->request();
        $model = $model->join('member_details', 'member_details.user_id', '=', 'session_member.user_id')
            ->join('sport_location' , 'sport_location.session_id' , '=' , 'session_member.session_id')
//            ->join('invoice_items' , 'invoice_items.item_name' , 'like' , '')
            ->select('session_member.id' , 'member_details.member_id' , 'member_details.user_id', 'member_details.name',  'sport_location.session_id', 'sport_location.session_name',
                'sport_location.sport_id' , 'session_member.status' , 'sport_location.id as sess_id')
            ->groupBy('session_member.id');

        if ($request->session_id != 'all' && $request->session_id != '') {
            $model = $model->where('session_member.session_id', $request->session_id);
        }
        if ($request->sport_id != 'all' && $request->sport_id != '') {
            $model = $model->where('sport_location.sport_id', $request->sport_id);
        }
        if ($request->status != 'all' && $request->status != '') {
            $model = $model->where('session_member.status', $request->status);
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
            ->setTableId('members-table')
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
            ->parameters([
                'initComplete' => 'function () {
                   window.LaravelDataTables["members-table"].buttons().container()
                    .appendTo( ".bg-title .text-right")
                }',
                'fnDrawCallback' => 'function( oSettings ) {
                    $("body").tooltip({
                        selector: \'[data-toggle="tooltip"]\'
                    })
                }',
            ])
            ->buttons(Button::make(['extend' => 'export', 'buttons' => ['excel', 'csv'], 'text' => '<i class="fa fa-download"></i> ' . trans('app.exportExcel') . '&nbsp;<span class="caret"></span>']));

    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            __('app.member_id') => ['data' => 'member_id', 'name' => 'member_id', 'visible' => true, 'exportable' => true, 'searchable'=>true],
//            '#' => ['data' => 'DT_RowIndex', 'orderable' => true, 'searchable' => true , 'visible' => true],
            __('app.name') => ['data' => 'name', 'name' => 'name'],
            __('app.session_name') => ['data' => 'session_name', 'name' => 'session_name'],
            __('app.session_id') => ['data' => 'session_id', 'name' => 'session_id'],
            __('app.status') => ['data' => 'status', 'name' => 'status'],

//            __('app.fees') => ['data' => 'session_id', 'name' => 'fees'],

            Column::computed('action', __('app.action'))
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
                ->searchable(false)
                ->width(150)
                ->addClass('text-center')
        ];
    }



    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'subscribers_' . date('YmdHis');
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