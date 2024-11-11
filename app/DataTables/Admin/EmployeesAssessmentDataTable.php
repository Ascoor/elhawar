<?php

namespace App\DataTables\Admin;

use App\DataTables\BaseDataTable;
use App\EmployeeAssessment;
use App\Role;
use App\User;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class EmployeesAssessmentDataTable extends BaseDataTable
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
                $action = '<div class="btn-group dropdown m-r-10">'.
                    '<button aria-expanded="false" data-toggle="dropdown" class="btn btn-default dropdown-toggle waves-effect waves-light" 
                            type="button"><i class="fa fa-gears "></i></button>'.
                    '<ul role="menu" class="dropdown-menu pull-right">'.
                    '<li><a href="' . route('admin.employees.assessments.edit', [$row->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i>'.trans('app.edit').'</a></li>'.
                    '<li><a href="javascript:;"  data-user-id="' . $row->id . '"  class="sa-params"><i class="fa fa-times" aria-hidden="true"></i>'.trans('app.delete').'</a></li>'.
                    '</ul></div>';
                return $action;
            })
            ->editColumn(
                'status',
                function ($row) {
                    return __('app.'.$row->status);
                }
            )
            ->addIndexColumn()
            ->rawColumns([
                'name',
                'employee_name',
                'date',
                'assessment_percentage',
                'action',])
            ->removeColumn('user_id')
            ->removeColumn('opinion1')
            ->removeColumn('opinion2')
            ->removeColumn('opinion3')
            ->removeColumn('extra_json');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Product $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(EmployeeAssessment $assessments)
    {
        $request = $this->request();
        $assessments = EmployeeAssessment::whereNotNull('assessment_percentage');
        if ($request->status != 'all' && $request->status != '') {
            $assessments = $assessments->where('status', $request->status);
        }
        if ($request->employee != 'all' && $request->employee != '') {
            $assessments = $assessments->where('user_id', $request->employee);
        }
        if ($request->filter_assessment_name != 'all' && $request->filter_assessment_name != '') {
            $assessments = $assessments->where('name',$request->filter_assessment_name);
        }
        if ($request->percentlargere != 'all' && $request->percentlargere != '') {
            $assessments = $assessments->where('assessment_percentage', '>=',$request->percentlargere);
        }
        if ($request->percentless != 'all' && $request->percentless != '') {
            $assessments = $assessments->where('assessment_percentage', '<=',$request->percentless);
        }
        return $assessments;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('employees-assessment-table')
            ->columns($this->processTitle($this->getColumns()))
            ->minifiedAjax()
            ->dom("<'row'<'col-md-6'l><'col-md-6'Bf>><'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>")
            ->destroy(true)
            ->orderBy(0)
            ->responsive(true)
            ->serverSide(true)
            ->stateSave(true)
            ->processing(true)
            ->language(__("app.datatable"))
            ->parameters([
                'initComplete' => 'function () {
                   window.LaravelDataTables["employees-assessment-table"].buttons().container()
                    .appendTo( ".bg-title .text-right")
                }',
                'fnDrawCallback' => 'function( oSettings ) {
                    $("body").tooltip({
                        selector: \'[data-toggle="tooltip"]\'
                    })
                }',
            ])
            ->buttons(
                Button::make(['extend' => 'export', 'buttons' => ['excel', 'csv'], 'text' => '<i class="fa fa-download"></i> ' . trans('app.exportExcel') . '&nbsp;<span class="caret"></span>'])
            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            __('app.id') => ['data' => 'id', 'name' => 'id', 'visible' => false, 'exportable' => false],
            '#' => ['data' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
            __('app.name') => ['data' => 'name', 'name' => 'name', 'exportable' => false],
            __('app.status') => ['data' => 'status', 'name' => 'status'],
            __('app.menu.employee_name') => ['data' => 'employee_name', 'name' => 'employee_name'],
            __('app.date') => ['data' => 'date', 'name' => 'date'],
            __('app.menu.total_assessment_percentage').'%' => ['data' => 'assessment_percentage', 'name' => 'assessment_percentage'],
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
        return 'Employee Assessment' . date('YmdHis');
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
