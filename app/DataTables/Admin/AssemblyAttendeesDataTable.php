<?php

namespace App\DataTables\Admin;

use App\AssemblyAttendees;
use App\DataTables\BaseDataTable;
use App\memberDetails;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class AssemblyAttendeesDataTable extends BaseDataTable
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
                $request=$this->request();
                if (!AssemblyAttendees::where('user_id',$row->user_id)->where('assembly_id',$request->assembly_id)->first()){
                $action = '<div class="btn-group dropdown m-r-10">
                 <button href="javascript:;" data-user-id="' . $row->user_id . '" class="btn btn-default addAttendee  waves-effect waves-light" id="butt_'.$row->user_id.'" type="button"><i class="fa fa-check "></i></button>
                </div>';
                }else{
                    $action='<label class="label label-success">' . __('modules.members.attendant') . '</label>';
                }
                return $action;
            })
            ->editColumn(
                'name',
                function ($row) {
                    return '<a href="' . route('admin.members.show', $row->id) . '">' . ucfirst($row->name) . '</a>';
                }
            )
            ->editColumn(
                'mobile',
                function ($row) {
                    if(!is_null($row->mobile) && $row->mobile != ' ' )
                    {
                        return '<a href="tel:+'. ($row->mobile) . '">'.'+'.($row->mobile) .'</a>';
                    }
                    return '--';
                }
            )
            ->editColumn(
                'created_at',
                function ($row) {
                    return Carbon::parse($row->created_at)->format($this->global->date_format);
                }
            )

            ->addIndexColumn()
            ->rawColumns(['name', 'mobile','action', 'status']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(memberDetails $model)
    {
        $request = $this->request();
        $now = Carbon::now();
        $oneYearBack=$now->subYears(1)->format('Y-m-d');
        $model = $model->join('users', 'member_details.user_id', '=', 'users.id')
            ->join('member_category' , 'member_details.category_id' , '=' , 'member_category.id')
            ->join('member_relations' , 'member_details.relation_id' , '=' , 'member_relations.id')
            ->join('member_status' , 'member_details.status_id' , '=' , 'member_status.id')
            ->leftJoin('countries', 'member_details.country_id', '=', 'countries.id')
            ->select('member_details.date_of_subscription','member_details.created_at','member_details.id' , 'member_details.member_id' , 'member_details.user_id', 'member_details.name',  'member_details.email',
                'member_details.phone' , 'member_details.category_id' , 'member_details.family_id' , 'member_category.category_name' , 'member_status.status_name' , 'member_relations.relation_name')
            ->where('category_id','=',1)
            ->where('renewal_status','=','renewed')
            // ->where('status_id',7)
            ->whereDate('member_details.date_of_subscription','<=',$oneYearBack)
            ->groupBy('member_details.id');
        if ($request->startDate !== null && $request->startDate != 'null' && $request->startDate != '') {
            $startDate = Carbon::createFromFormat($this->global->date_format, $request->startDate)->toDateString();
            $model = $model->where(DB::raw('DATE(member_details.`created_at`)'), '>=', $startDate);
        }

        if ($request->endDate !== null && $request->endDate != 'null' && $request->endDate != '') {
            $endDate = Carbon::createFromFormat($this->global->date_format, $request->endDate)->toDateString();
            $model = $model->where(DB::raw('DATE(member_details.`created_at`)'), '<=', $endDate);
        }
        if ($request->member != 'all' && $request->member != '') {
            $model = $model->where('member_details.member_id', $request->member);
        }
        if ($request->status != 'all' && $request->status != '') {
            $model = $model->where('member_details.status_id', $request->status);
        }
        if (!is_null($request->category_id) && $request->category_id != 'all') {
            $users = $model->where('member_details.category_id', $request->category_id);
        }
        if (!is_null($request->sub_category_id) && $request->sub_category_id != 'all') {
            $users = $model->where('member_details.sub_category_id', $request->sub_category_id);
        }

        if (!is_null($request->phone) && $request->phone != 'all') {
//            $model->whereHas('phone', function ($query)use($request) {
//                return $query->where('id',  $request->project_id);
//            });
            $users = $model->where('member_details.phone', $request->phone);

        }
        if (!is_null($request->family_id) && $request->family_id != 'all') {
//            $model->whereHas('contracts', function ($query)use($request) {
//                return $query->where('contracts.contract_type_id',  $request->contract_type_id);
//
//            });
            $users = $model->where('member_details.family_id', $request->family_id);
        }
        if (!is_null($request->country_id) && $request->country_id != 'all') {
            $model->whereHas('country', function ($query)use($request) {
                return $query->where('id',  $request->country_id);

            });
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
            __('app.id') => ['data' => 'member_id', 'name' => 'id', 'visible' => true, 'exportable' => true, 'searchable'=>true],
            '#' => ['data' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false , 'visible' => false],
            __('app.name') => ['data' => 'name', 'name' => 'name'],
            __('app.family_id') => ['data' => 'family_id', 'name' => 'family_id'],
            __('app.category') => ['data' => 'category_name', 'name' => 'category_id'],
            __('app.relation') => ['data' => 'relation_name', 'name' => 'relation_id'],
            __('app.status') => ['data' => 'status_name', 'name' => 'status_id'],
            __('app.email') => ['data' => 'email', 'name' => 'email'],
            __('app.phone') => ['data' => 'phone', 'name' => 'phone'],
            __('app.createdAt') => ['data' => 'created_at', 'name' => 'created_at'],
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
        return 'members_' . date('YmdHis');
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
