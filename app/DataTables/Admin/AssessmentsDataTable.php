<?php

namespace App\DataTables\Admin;

use App\Assessment;
use App\DataTables\BaseDataTable;
use App\SportAcademy;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class AssessmentsDataTable extends BaseDataTable
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
                 <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default dropdown-toggle waves-effect waves-light" type="button"><i class="fa fa-gears "></i></button>
                <ul role="menu" class="dropdown-menu pull-right">
                                  <li><a href="' . route('admin.assessments.show', [$row->id]) . '"><i class="fa fa-search" aria-hidden="true"></i> ' . __('app.view') . '</a></li>

                                <li><a href="' . route('admin.assessments.edit', [$row->id]) . '"><i class="fa fa-pencil"></i> ' . __('app.edit') . '</a></li>
                  <li><a href="javascript:;"  data-user-id="' . $row->id . '"  class="sa-params"><i class="fa fa-times" aria-hidden="true"></i> ' . trans('app.delete') . '</a></li>';

                $action .= '</ul> </div>';

                return $action;
            })


            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Assessment $model)
    {
        $request = $this->request();
        $model = $model->join('member_details' , 'member_details.user_id' ,'=','assessments.player_id')
            ->select('assessments.id' , 'assessments.name as assessmentName' , 'member_details.name as playerName' , 'assessments.at_date' , 'member_details.member_id')
            ->groupBy('assessments.id');

        if ($request->member_id != 'all' && $request->member_id != '') {
            $model = $model->where('member_details.member_id', $request->member_id);
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
//            __('app.id') => ['data' => 'id', 'name' => 'id', 'visible' => true, 'exportable' => true, 'searchable'=>true],
            '#' => ['data' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false , 'visible' => true],
            __('app.playerName') => ['data' => 'playerName', 'name' => 'member_details.name'],
            __('app.assessmentName') => ['data' => 'assessmentName', 'name' => 'assessments.name'],
            __('app.date') => ['data' => 'at_date', 'name' => 'assessments.at_date'],

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
        return 'sports_' . date('YmdHis');
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