<?php

namespace App\DataTables\Admin;

use App\ClientDetails;
use App\DataTables\BaseDataTable;
use App\EmployeeDetails;
use App\memberCategory;
use App\memberDetails;
use App\SportAcademy;
use App\sports;
use App\sportsTeams;
use App\TeamsCoaches;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class SportsTeamsDataTable extends BaseDataTable
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
                               <li><a href="' . route('admin.sportsTeams.teamPlayers', [$row->id]) . '"><i class="fa fa-search" aria-hidden="true"></i> ' . __('modules.club.view_players') . '</a></li>
                               <li><a href="' . route('admin.sportsTeams.addPlayerIndex', [$row->id]) . '"><i class="fa fa-plus" aria-hidden="true"></i> ' . trans('modules.club.add_player') . '</a></li>
                                <li><a href="' . route('admin.sportsTeams.edit', [$row->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i> ' . trans('app.edit') . '</a></li>
                <li><a href="javascript:;"  data-user-id="' . $row->id . '"  class="sa-params"><i class="fa fa-times" aria-hidden="true"></i> ' . trans('app.delete') . '</a></li>';

                $action .= '</ul> </div>';

                return $action;
            })
            ->editColumn('team_id' ,
            function ($row){
                $coaches=EmployeeDetails::all();
                $teams=TeamsCoaches::where('team_id' , $row->team_id)->select('coach_id')->get();
                $i=0;
                foreach ($coaches as $coach){
                    foreach ($teams as $team){
                        if ($coach->id == $team->coach_id){
                            $trainers[$i]=$coach->user->name;
                            $i++;
                        }
                    }
                }
                return $trainers;
            })
            ->addIndexColumn();

    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(sportsTeams $model)
    {
        $request = $this->request();
        $model = $model->join('sports', 'sports_teams.sport_id' , '=' , 'sports.id')
            ->join('teams_coaches' , 'sports_teams.id' , '=' , 'teams_coaches.team_id')
            ->select('sports_teams.id' , 'team_name' , 'from_age' , 'to_age' , 'sports.name' , 'teams_coaches.team_id' )
            ->groupBy('sports_teams.id');

        if ($request->team_id != 'all' && $request->team_id != '') {
            $model = $model->where('sports_teams.id', $request->team_id);
        }
        if (!is_null($request->sport_id) && $request->sport_id != 'all') {
            $model = $model->where('sport_id', $request->sport_id);
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
            ->setTableId('teams-table')
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
                   window.LaravelDataTables["teams-table"].buttons().container()
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
            __('app.id') => ['data' => 'id', 'name' => 'id', 'visible' => true, 'exportable' => true, 'searchable'=>true],
            '#' => ['data' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false , 'visible' => false],
            __('app.name') => ['data' => 'team_name', 'name' => 'team_name'],
            __('app.sport') => ['data' => 'name', 'name' => 'sports.name'],
            __('app.coaches') => ['data' => 'team_id', 'name' => 'teams_coaches.team_id'],
            __('app.from_age') => ['data' => 'from_age', 'name' => 'from_age'],
            __('app.to_age') => ['data' => 'to_age', 'name' => 'to_age'],

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