<?php

namespace App\DataTables\Admin;

use App\Player;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Services\DataTable;

class PlayerDataTable extends DataTable
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
                if ($row->category_id == 1) {
                    $action = '<div class="btn-group dropdown m-r-10">
                 <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default dropdown-toggle waves-effect waves-light" type="button"><i class="fa fa-gears "></i></button>
                <ul role="menu" class="dropdown-menu pull-right">
                   <li><a href="' . route('admin.players.create', [$row->player_id]) . '"><i class="fa fa-plus" aria-hidden="true"></i> ' . trans('modules.players.add_to_family') . '</a></li>
                  <li><a href="' . route('admin.players.edit', [$row->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i> ' . trans('app.edit') . '</a></li>
                  <li><a href="' . route('admin.players.show', [$row->id]) . '"><i class="fa fa-search" aria-hidden="true"></i> ' . __('app.view') . '</a></li>
                  <li><a href="javascript:;"  data-user-id="' . $row->user_id . '"  class="sa-params"><i class="fa fa-times" aria-hidden="true"></i> ' . trans('app.delete') . '</a></li>';

                    $action .= '</ul> </div>';
                } else {
                    $action = '<div class="btn-group dropdown m-r-10">
                 <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default dropdown-toggle waves-effect waves-light" type="button"><i class="fa fa-gears "></i></button>
                <ul role="menu" class="dropdown-menu pull-right">
                  <li><a href="' . route('admin.players.edit', [$row->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i> ' . trans('app.edit') . '</a></li>
                  <li><a href="' . route('admin.players.show', [$row->id]) . '"><i class="fa fa-search" aria-hidden="true"></i> ' . __('app.view') . '</a></li>
                  <li><a href="javascript:;"  data-user-id="' . $row->user_id . '"  class="sa-params"><i class="fa fa-times" aria-hidden="true"></i> ' . trans('app.delete') . '</a></li>';

                    $action .= '</ul> </div>';
                }

                return $action;
            })
            ->editColumn(
                'name',
                function ($row) {
                    return '<a href="' . route('admin.players.show', $row->id) . '">' . ucfirst($row->name) . '</a>';
                }
            )
            ->editColumn(
                'mobile',
                function ($row) {
                    if (!is_null($row->mobile) && $row->mobile != ' ') {
                        return '<a href="tel:+' . ($row->mobile) . '">' . '+' . ($row->mobile) . '</a>';
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
           
            ->editColumn(
                'exc_cat',
                function ($row) {
                    return __('app.' . $row->exc_cat);
                }
            )
            ->editColumn(
                'relation_name',
                function ($row) {
                    return __('app.member_relations.' . $row->relation_name);
                }
            )
            ->editColumn(
                'status_name',
                function ($row) {
                    return __('app.member_status.' . $row->status_name);
                }
            )
            ->addIndexColumn()
            ->rawColumns(['name', 'mobile', 'city', 'state', 'address', 'profession', 'action', 'status']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\App\admin/players $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Player $model)
    {
       
            $request = $this->request();
            $model = $model->join('team' , 'players.team_id' , '=' , 'team_id.id')
                ->leftJoin('countries', 'players.country_id', '=', 'countries.id')
                ->select( 
                    'players.player_id' ,
                    'players.union_id', 
                    'players.name',  
                    'players.national_id', 
                    'players.atu_sport' , 
                    'players.atu_acadmy' , 
                    'players.team_id' , 
                    'players.status_id' , 
                    'players.gender' , 
                    'players.date_of_birth',
                    'players.age',
                    'players.city',
                    'players.state',
                    'players.champions_award',
                    'players.address',
                    'players.country_id',
                    'players.mobile' ,
                    'players.guardian_mobile' , 
                    'players.note',
                    'players.created_at',
                    
                    )
    
                ->groupBy('players.id');
    
            if ($request->startDate !== null && $request->startDate != 'null' && $request->startDate != '') {
                $startDate = Carbon::createFromFormat($this->global->date_format, $request->startDate)->toDateString();
                $model = $model->where(DB::raw('DATE(players.`created_at`)'), '>=', $startDate);
            }
    
            if ($request->endDate !== null && $request->endDate != 'null' && $request->endDate != '') {
                $endDate = Carbon::createFromFormat($this->global->date_format, $request->endDate)->toDateString();
                $model = $model->where(DB::raw('DATE(players.`created_at`)'), '<=', $endDate);
            }
            if ($request->player_id != 'all' && $request->player_id != '') {
                $model = $model->where('players.player_id', $request->player_id);
            }
            if ($request->union_id != 'all' && $request->union_id != '') {
                $model = $model->where('players.union_id', $request->union_id);
            }
            if (!is_null($request->name) && $request->name != 'all') {
                $users = $model->where('players.name', $request->name);
            }
            if (!is_null($request->national_id) && $request->national_id != 'all') {
                $model = $model->where('players.national_id', $request->national_id);
            }
    
            if (!is_null($request->atu_sport) && $request->atu_sport != 'all') {
                $model = $model->where('players.atu_sport', $request->atu_sport);
            }
    
            if (!is_null($request->atu_acadmy) && $request->atu_acadmy != 'all') {
                $model = $model->where('players.atu_acadmy', $request->atu_acadmy);
            }
    
            if (!is_null($request->team_id) && $request->team_id != 'all') {
                $model = $model->where('players.team_id', $request->team_id);
            }
    
            if (!is_null($request->age) && $request->age != 'all') {
                $model = $model->where('players.age', $request->age);
            }
    
            if (!is_null($request->city) && $request->city != 'all') {
                $model = $model->where('players.city', $request->city);
            }
    
            if (!is_null($request->state) && $request->state != 'all') {
                $model = $model->where('players.state', $request->state);
            }
    
            if (!is_null($request->address) && $request->address != 'all') {
                $model = $model->where('players.address', $request->address);
            }
    
            if (!is_null($request->country_id) && $request->country_id != 'all') {
                $model = $model->where('players.country_id', $request->country_id);
            }
    
            if (!is_null($request->mobile) && $request->mobile != 'all') {
                $model = $model->where('players.mobile', $request->mobile);
            }
    
            if (!is_null($request->status_id) && $request->status_id != 'all') {
                $model = $model->where('players.status_id', $request->status_id);
            }
    
            if (!is_null($request->gender) && $request->gender != 'all') {
                $model = $model->where('players.gender', $request->gender);
            }
    
            if (!is_null($request->date_of_birth) && $request->date_of_birth != 'all') {
                $model = $model->where('players.date_of_birth', $request->date_of_birth);
            }
    
            if (!is_null($request->country_id) && $request->country_id != 'all') {
                $model->whereHas('country', function ($query)use($request) {
                    return $query->where('id',  $request->country_id);
    
                });
            }
    
            if (!is_null($request->guardian_mobile) && $request->guardian_mobile != 'all') {
                $model = $model->where('players.guardian_mobile', $request->guardian_mobile);
            }
    
            if (!is_null($request->champions_award) && $request->champions_award != 'all') {
                $model = $model->where('players.champions_award', $request->champions_award);
            }
    
            if (!is_null($request->note) && $request->note != 'all') {
                $model = $model->where('players.note', $request->note);
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
                    ->setTableId('admin\players-table')
                    ->columns($this->getColumns())
                    // ->columns($this->processTitle($this->getColumns()))
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->destroy(true)
            ->responsive(true)
            ->serverSide(true)
            ->stateSave(true)
            ->processing(true)
            ->language(__("app.datatable"))
            ->parameters([
                'initComplete' => 'function () {
                   window.LaravelDataTables["admin\players-table"].buttons().container()
                    .appendTo( ".bg-title .text-right")
                }',
                'fnDrawCallback' => 'function( oSettings ) {
                    $("body").tooltip({
                        selector: \'[data-toggle="tooltip"]\'
                    })
                }',
            ])
            ->buttons(Button::make([
                'extend' => 'export',
                'buttons' => ['excel', 'csv'],
                'text' => '<i class="fa fa-download"></i> ' . trans('app.exportExcel') . '&nbsp;<span class="caret"></span>'
            ]));
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

            __('app.player_id') => ['data' => 'player_id', 'name' => 'player_id'],
            __('app.union_id') => ['data' => 'union_id', 'name' => 'union_id'],
            __('app.name') => ['data' => 'name', 'name' => 'name'],
            __('app.national_id') => ['data' => 'national_name', 'name' => 'national_id'],
            __('app.atu_sport') => ['data' => 'atu_sport', 'name' => 'atu_sport'],
            __('app.atu_acadmy') => ['data' => 'atu_acadmy', 'name' => 'atu_acadmy'],
            __('app.team') => ['data' => 'team_id', 'name' => 'team_id'],
            __('modules.players.status') => ['data' => 'status_name', 'name' => 'status_id'],
            __('modules.employees.gender') => ['data' => 'gender', 'name' => 'gender'],
            __('modules.players.BirthDate') => ['data' => 'date_of_birth', 'name' => 'date_of_birth'],
            __('modules.players.age') => ['data' => 'age', 'name' => 'age'],
            __('modules.stripeCustomerAddress.city') => ['data' => 'city', 'name' => 'city'],
            __('modules.stripeCustomerAddress.state') => ['data' => 'state', 'name' => 'state'],
            __('app.champions_award') => ['data' => 'champions_award', 'name' => 'champions_award'],
            __('app.address') => ['data' => 'address', 'name' => 'address'],
            __('modules.clients.country') => ['data' => 'country_id', 'name' => 'country_id'],
            __('app.mobile') => ['data' => 'mobile', 'name' => 'mobile'],
            __('app.guardian_mobile') => ['data' => 'guardian_mobile', 'name' => 'guardian_mobile'],
            __('app.note') => ['data' => 'note', 'name' => 'note'],
            
            Column::computed('action', __('app.action'))
            ->exportable(false)
            ->printable(false)
            ->orderable(false)
            ->searchable(false)
            ->width(10)
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
        return 'admin\players_' . date('YmdHis');
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
