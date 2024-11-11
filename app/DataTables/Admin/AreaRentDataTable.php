<?php


namespace App\DataTables\Admin;

use App\DataTables\BaseDataTable;
use App\ProjectTimeLog;
use App\RentedArea;
use App\User;
use App\EmployeeDetails;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use App\AreaRent;

// return  '<div class="row truncate"><div class="col-sm-3 col-xs-4">' . $image . '</div><div class="col-sm-1 col-xs-1"></div><div class="col-sm-7 col-xs-6"><a href="' . route('admin.employees.show', $row->id) . '">' . ucwords($row->name) . '</a><br><span class="text-muted font-12">' . $designation . '</span></div></div>';

class AreaRentDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        // ' . route('admin.area-rents.addPlayer', ['id'=>$row->id, 'team_id'=>$this->this_team]) . '
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($row) {
                $action = '<button> Rent</button>';

//                $action .= '</ul> </div>';

                // return $action;
                return '-';

            })
            
            ->editColumn(
                'area_name',
                function ($row) {
                    return  ucfirst($row->area_name) ;
                    // if(!is_null($row->name) && $row->mobile != ' ' )
                    // {
                    //     return '<a href="tel:+'. ($row->mobile) . '">'.'+'.($row->mobile) .'</a>';
                    // }
                    // return '--';
                }
            )
            ->editColumn(
                'cleint_phone',
                function ($row) {
                    
                    // return  '<div class="row truncate" >' . ($row->client_name) .' </div>';
                    // return  '<div class="row truncate" >' . ($row->client_name) .' </div>';
                    return  $row->phone_number .'<br>'. ucwords($row->client_name) ; 
                // return  '<div class="row truncate"><div class="col-sm-1 col-xs-1"></div><div class="col-sm-7 col-xs-6"><a href="' . route('admin.employees.show', $row->id) . '">' . ucwords($row->client_name) . '</a><br><span class="text-muted font-12">' . ($row->phone_number) . '</span></div></div>';


                    
                   


                        // return '<a href="tel:+'. ($row->mobile) . '">'.'+'.($row->mobile) .'</a>';
// return  '<div class="row"><div class="col-sm-7 col-xs-6">. ucwords($row->name) .'<br><span class="text-muted font-12">' . $designation . '</span></div></div>';
// return '<div class="row truncate"><div class="col-sm-7 col-xs-6">' . ucwords($row->client_name) . '<br><span class="text-muted font-12">' . ucwords($row->$phone_number) . '</span></div></div>'

                }
            )
            ->editColumn(
                'occusion_date',
                function ($row) {
             
                    return '<span style="font-weight: bold;">Start at </span>'.$row->start_date_time .'<br>  <span style="font-weight: bold;">End at </span>'. ucwords($row->end_date_time) ; 
            
                }
            )
            ->editColumn(
                'occusion_date',
                function ($row) {
             
                    return '<span style="font-weight: bold;">Start at </span>'.$row->start_date_time .'<br>  <span style="font-weight: bold;">End at </span>'. ucwords($row->end_date_time) ; 
            
                }
            ) 
            ->editColumn(
                'guardian',
                function ($row) {
                    if ($row->guardian == 'yes'){
                       
                        // return   $row->employee_name .'---'.$row->employee_details_id ;
                    return  ucwords($row->employee_name) .'<br>'. $row->employee_mobile ; 

                    }else{
                        return '--';
                    }
                    
                    // return '<span style="font-weight: bold;">Start at </span>'.$row->start_date_time .'<br>  <span style="font-weight: bold;">End at </span>'. ucwords($row->end_date_time) ; 
             
                }
            ) 

            ->editColumn(
                'occusion_repeat',
                function ($row) {
                    if ($row->session_repeat == 'yes'){
                       
                        // return   $row->employee_name .'---'.$row->employee_details_id ;
                    return  ucwords($row->repeat_every) .' '.ucwords($row->repeat_type) .'<br> for '. $row->repeat_cycles .'cycle'; 

                    }else{
                        return '--';
                    }
                    
                    // return '<span style="font-weight: bold;">Start at </span>'.$row->start_date_time .'<br>  <span style="font-weight: bold;">End at </span>'. ucwords($row->end_date_time) ; 
             
                }
            ) 

       
            ->addIndexColumn()
            ->rawColumns(['occusion_date','guardian','cleint_phone','occusion_repeat','action']);
            //   'hall_name' , 'action','description' , 'area_capacity','location',
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Product $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(RentedArea $model)
    {
        $request = $this->request();
        $model = $model
            ->select('rented_area.id' , 
            'rented_area.start_date_time', 
            'rented_area.end_date_time',
            'rented_area.area_rent_details_id',
            // 'rented_area.status',
            'rented_area.guardian',
            'rented_area.price',
            'rented_area.client_name',
            'rented_area.phone_number',
            'rented_area.session_repeat',
            'rented_area.employee_details_id',
            'rented_area.repeat_type',
            'rented_area.label_color',
            'rented_area.repeat_every',
            'rented_area.repeat_cycles',

            'area_rent_details.area_name',
            'area_rent_details.location',
            'area_rent_details.description',
            'area_rent_details.area_capacity',
            'users.name as employee_name',
            'users.mobile as employee_mobile',




             )
           -> join('area_rent_details', 'rented_area.area_rent_details_id', '=', 'area_rent_details.id')
           -> join('employee_details', 'rented_area.employee_details_id', '=', 'employee_details.id')
         
           -> join('users', 'employee_details.user_id', '=', 'users.id')
        //    ->where('employee_details.user_id' ,'=','users.id')
        //    ->join( \DB::raw("(select * from users  where employee_details.user_id = users.id"),)
        

            ->groupBy('id');
        foreach ($model as $mod){
            $mod->start_time=Carbon::parse('start_time')->format('H:i A');
        }
//        SportAcademy::where('id' , 'sport_location.sport_id')->select('name' , 'code');
        if ($request->area_name != 'all' && $request->area_name != '') {
            $model = $model->where('area_name', $request->area_name);
        }
        // if ($request->guradian != 'all' && $request->guradian  == 'yes') {
        //     $model = $model->where('employee_details_id ', $request->employee_details_id );
        // }
        
        // if (!is_null($request->capacity) && $request->capacity != 'all') {
        //     $users = $model->where('area_capacity', $request->capacity);
        // }
        // if (!is_null($request->description) && $request->description != 'all') {
        //     $users = $model->where('description', $request->description);
        // }
        // if (!is_null($request->location) && $request->location != 'all') {
        //     $users = $model->where('location', $request->location);
        // }

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
            
            '#' => ['data' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false , 'visible' => true],
            __('app.hall_name') => ['data' => 'area_name'],
            
            __('app.descriprrtion') => ['data' =>'description' , ],
            __('app.area_capacity') => ['data' =>'area_capacity' , 'name' => 'area_capacity'],
            __('app.location') => ['data' =>'location'],
            __('app.cleint_phone') => ['data' =>'cleint_phone'], 
            // __('app.cleint_phone') => ['data' =>'cleint_phone','width' => '20rem',], 

            __('app.Date') => ['data' =>'occusion_date' ],
            __('app.guardian') => ['data' =>'guardian'  ],
            __('app.occusion_repeat') => ['data' =>'occusion_repeat'  ],
           



            

            Column::computed('action', __('app.action'))
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
                ->searchable(false)
                ->width(150)
                ->addClass('text-center')
        ];
        // return [
        //     Column::computed('action')
        //           ->exportable(false)
        //           ->printable(false)
        //           ->width(60)
        //           ->addClass('text-center'),
        //     Column::make('id'),
        //     Column::make('add your columns'),
        //     Column::make('created_at'),
        //     Column::make('updated_at'),
        // ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Admin\AreaRentttttttt_' . date('YmdHis');
    }
}
