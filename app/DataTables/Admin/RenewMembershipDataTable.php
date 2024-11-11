<?php

namespace App\DataTables\Admin;

use App\DataTables\BaseDataTable;
use App\memberDetails;
use App\RecurringInvoice;
use App\Scopes\CompanyScope;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class RenewMembershipDataTable extends BaseDataTable
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
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $action = '<a href="' . route('admin.members.membership-renew-show', $row->id) . '"><i class="fa fa-search"></i>' . __('app.view') . '</a>';

                return $action;
            })
            ->addColumn('action', function ($row) {
                $action = '<div class="btn-group dropdown m-r-10">
                 <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default dropdown-toggle waves-effect waves-light" type="button"><i class="fa fa-gears "></i></button>
                <ul role="menu" class="dropdown-menu">';

                $action .= '<li><a href="' . route("admin.members.membership-renew-show", $row->id) . '"><i class="fa fa-search"></i> ' . __('app.view') . '</a></li>';
                $action .= '<li><a href="' . route("admin.members.membership-renew-edit", $row->id) . '"><i class="fa fa-pencil"></i> ' . __('app.edit') . '</a></li>';

                $action .= '<li><a href="javascript:;" data-toggle="tooltip"  data-invoice-id="' . $row->id . '" class="sa-params"><i class="fa fa-times"></i> ' . __('app.delete') . '</a></li>';

                $action .= '</ul> </div>';

                return $action;
            })
            ->editColumn('member_id', function ($row) {
                $member_id='';
                $memId='';
                if ($row->client_id != '') {
                    $member = MemberDetails::where('user_id',$row->client_id)->first();
                    if (!is_null($member)) {
                        $member_id= ucfirst($member->member_id);
                        $memId= ucfirst($member->id);
                        }
                    else{
                            $member_id= '--';
                        }
                }else{
                $member_id= '--';
                }
                return '<div class="text-center">'.
                            '<a href="'.
                                route("admin.members.show", $memId).
                                '">'.
                                $member_id.
                            '</a>'.
                        '</div>';
            })
            ->editColumn('name', function ($row) {
                $name='';
                if ($row->project && $row->project->client) {
                    $name = ucfirst($row->project->client->name);
                }else{
                    if ($row->client_id != '') {
                        $client = User::withoutGlobalScope(CompanyScope::class)->find($row->client_id);
                        if (!is_null($client) && !is_null($client->client_details)) {
                            $name = ucfirst($client->client_details->name);
                        }
                        if (!is_null($client)){
                            $name = ucfirst($client->name);
                        }else{
                            $name = '--';
                        }
                    }else{
                        $name = '--';
                    }
                }
                return '<div class="text-center">' .$name. '</div>';

            })
            ->editColumn('total', function ($row) {
                $currencyCode = ' (' . $row->currency->currency_code . ') ';
                $currencySymbol = $row->currency->currency_symbol;

                return '<div class="text-center">' . __('app.total') . ': ' . currency_formatter($row->total, $currencySymbol) . '</div>';
            })
            ->editColumn(
                'issue_date',
                function ($row) {
                    return '<div class="text-center">' . $row->issue_date->timezone($this->global->timezone)->format($this->global->date_format)  . '</div>';
                }
            )
            ->rawColumns(['action', 'total','issue_date','member_id','name'])
            ->removeColumn('currency_symbol')
            ->removeColumn('currency_code')
            ->removeColumn('project_id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Product $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(RecurringInvoice $model)
    {
        $request = $this->request();

        $model = $model->with([
                            'project' => function ($q) {
                                    $q->withTrashed();
                                    $q->select('id', 'project_name', 'client_id','deleted_at');
                                },
                            'currency:id,currency_symbol,currency_code', 'project.client'
                            ])
                        ->select(
                            'invoice_recurring.id',
                            'invoice_recurring.project_id',
                            'invoice_recurring.client_id',
                            'invoice_recurring.currency_id',
                            'invoice_recurring.total',
                            'invoice_recurring.status',
                            'invoice_recurring.issue_date',
                            'invoice_recurring.show_shipping_address'
                            )
                        ->leftJoin('users', 'invoice_recurring.client_id', 'users.id')
                        ->leftJoin('client_details', 'client_details.user_id', 'users.id');
            $model=$model->where('invoice_recurring.is_renew',1);
        if ($request->startDate !== null && $request->startDate != 'null' && $request->startDate != '') {
            $startDate = Carbon::createFromFormat($this->global->date_format, $request->startDate)->toDateString();
            $model = $model->where(DB::raw('DATE(invoice_recurring.`issue_date`)'), '>=', $startDate);
        }

        if ($request->endDate !== null && $request->endDate != 'null' && $request->endDate != '') {
            $endDate = Carbon::createFromFormat($this->global->date_format, $request->endDate)->toDateString();
            $model = $model->where(DB::raw('DATE(invoice_recurring.`issue_date`)'), '<=', $endDate);
        }

        if ($request->status != 'all' && !is_null($request->status)) {
            $model = $model->where('invoice_recurring.status', '=', $request->status);
        }

        if ($request->projectID != 'all' && !is_null($request->projectID)) {
            $model = $model->where('invoice_recurring.project_id', '=', $request->projectID);
        }

        if ($request->clientID != 'all' && !is_null($request->clientID)) {
            $model = $model->where('client_id', '=', $request->clientID);
        }
        if ($request->employeeID != 'all' && !is_null($request->employeeID)) {
            $model = $model->where('client_id', '=', $request->employeeID);
        }
        $Ids=array();
            $members=memberDetails::all();
            $i=0;
            foreach ($members as $member){
                $Ids[$i]=$member->user_id;
                $i++;
            }
            if(count($Ids)>0){
                $model = $model->whereIn('client_id',$Ids);
            }


        if ($request->memberID != '' && !is_null($request->memberID)) {
            $member=memberDetails::where('member_id',$request->memberID)->first();
            $model = $model->where('client_id', '=', $member->user_id);
        }

        $model = $model->whereHas(
            'project', function ($q) {
                                        $q->whereNull('deleted_at');
                                    },
            '>=', 0);
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
            ->setTableId('invoices-recurring-table')
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
                   window.LaravelDataTables["invoices-recurring-table"].buttons().container()
                    .appendTo( ".bg-title .text-center")
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
            __('app.menu.members') => ['data' => 'name', 'name' => 'client_details.name'],
            __('app.member_id') => ['data' => 'member_id', 'member_id' => 'member_details.member_id'],
            __('modules.invoices.total') => ['data' => 'total', 'name' => 'total'],
            __('modules.invoices.invoiceDate') => ['data' => 'issue_date', 'name' => 'issue_date'],
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
        return 'Invoices_recurring_' . date('YmdHis');
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
