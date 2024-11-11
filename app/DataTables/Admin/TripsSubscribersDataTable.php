<?php

namespace App\DataTables\Admin;

use App\DataTables\BaseDataTable;
use App\Invoice;
use App\InvoiceItems;
use App\SessionMember;
use App\TripMember;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class TripsSubscribersDataTable extends BaseDataTable
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
                  <a href="javascript:;"  data-user-id="' . $row->id . '"  class="btn btn-default sa-params waves-effect waves-light" type="button" ><i class="fa fa-times" aria-hidden="true"></i></a>
                </div>';

//                    $action .= '</ul> </div>';}

                return $action;
            })
            ->editColumn(
                'name',
                function ($row) {
                    return '<a href="' . route('admin.members.show', $row->trip_id) . '">' . ucfirst($row->name) . '</a>';
                }
            )
            ->editColumn(
                'trip_name',
                function ($row) {
                    $item=InvoiceItems::where('item_name' , $row->trip_name.' #'.$row->trip_id)->first();
                    $invoice=Invoice::where('id' , $item->invoice_id)->first();
                    $status=$invoice->status;
                    $ulist=$row->trip_name.'  ';
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
            ->rawColumns(['name', 'mobile','action', 'trip_name']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(TripMember $model)
    {
        $request = $this->request();
        $model = $model->join('member_details', 'member_details.user_id', '=', 'trip_member.user_id')
            ->join('trips' , 'trips.id' , '=' , 'trip_member.trip_id')
//            ->join('invoice_items' , 'invoice_items.item_name' , 'like' , '')
            ->select( 'member_details.member_id' , 'member_details.user_id', 'member_details.name',  'trips.id as trip_id', 'trips.trip_name','trip_member.id'
                )
            ->groupBy('trip_member.id');

        if ($request->trip_id != 'all' && $request->trip_id != '') {
            $model = $model->where('trips.id', $request->trip_id);
        }
//        if ($request->sport_id != 'all' && $request->sport_id != '') {
//            $model = $model->where('sport_location.sport_id', $request->sport_id);
//        }

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
            __('app.member_id') => ['data' => 'member_id', 'name' => 'member_details.member_id', 'visible' => true, 'exportable' => true, 'searchable'=>true],
//            '#' => ['data' => 'DT_RowIndex', 'orderable' => true, 'searchable' => true , 'visible' => true],
            __('app.name') => ['data' => 'name', 'name' => 'member_details.name'],
            __('app.trip_name') => ['data' => 'trip_name', 'name' => 'trips.trip_name'],
//            __('app.fees') => ['data' => 'user_id', 'name' => 'fees'],

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