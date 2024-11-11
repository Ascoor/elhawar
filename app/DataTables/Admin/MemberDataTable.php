<?php

namespace App\DataTables\Admin;

use App\ClientDetails;
use App\DataTables\BaseDataTable;
use App\memberCategory;
use App\memberDetails;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class MemberDataTable extends BaseDataTable
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
                   <li><a href="' . route('admin.members.createToFamily', [$row->family_id]) . '"><i class="fa fa-plus" aria-hidden="true"></i> ' . trans('modules.members.add_to_family') . '</a></li>
                  <li><a href="' . route('admin.members.edit', [$row->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i> ' . trans('app.edit') . '</a></li>
                  <li><a href="' . route('admin.members.show', [$row->id]) . '"><i class="fa fa-search" aria-hidden="true"></i> ' . __('app.view') . '</a></li>
                  <li><a href="javascript:;"  data-user-id="' . $row->user_id . '"  class="sa-params"><i class="fa fa-times" aria-hidden="true"></i> ' . trans('app.delete') . '</a></li>';

                    $action .= '</ul> </div>';
                } else {
                    $action = '<div class="btn-group dropdown m-r-10">
                 <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default dropdown-toggle waves-effect waves-light" type="button"><i class="fa fa-gears "></i></button>
                <ul role="menu" class="dropdown-menu pull-right">
                  <li><a href="' . route('admin.members.edit', [$row->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i> ' . trans('app.edit') . '</a></li>
                  <li><a href="' . route('admin.members.show', [$row->id]) . '"><i class="fa fa-search" aria-hidden="true"></i> ' . __('app.view') . '</a></li>
                  <li><a href="javascript:;"  data-user-id="' . $row->user_id . '"  class="sa-params"><i class="fa fa-times" aria-hidden="true"></i> ' . trans('app.delete') . '</a></li>';

                    $action .= '</ul> </div>';
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
                'category_name',
                function ($row) {
                    return __('app.' . $row->category_name);
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
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(memberDetails $model)
    {






        $request = $this->request();
        $model = $model->join('users', 'member_details.user_id', '=', 'users.id')
            ->join('member_category', 'member_details.category_id', '=', 'member_category.id')
            ->join('excluded_categories', 'member_details.excluded_categories_id', '=', 'excluded_categories.id')
            ->join('member_relations', 'member_details.relation_id', '=', 'member_relations.id')
            ->join('member_status', 'member_details.status_id', '=', 'member_status.id')
            ->leftJoin('countries', 'member_details.country_id', '=', 'countries.id')
            ->select(
                'member_details.id',
                'member_details.member_id',
                'member_details.user_id',
                'member_details.name',
                'member_details.email',
                'member_details.created_at',
                'member_details.phone',
                'member_details.category_id',
                'member_details.family_id',
                'member_details.city',
                'member_details.state',
                'member_details.address',
                'member_details.profession',
                'member_category.category_name',
                'member_status.status_name',
                'member_details.decision_number',
                'member_details.national_id',
                'member_details.age',
                'member_details.religion',
                'member_details.country_id',
                'member_details.renewal_status',
                'member_details.postal_code',
                'member_details.face_book',
                'member_details.twitter',
                'member_details.excluded_categories_id',
                'member_details.date_of_subscription',

                //mohammed & rola
                'member_details.mem_GraduationDesc',
                'member_details.mem_HomePhone',
                'member_details.mem_WorkPhone',
                'member_details.memCard_MemberName',
                'member_details.note_2',
                'member_details.note_3',
                'member_details.note_4',
                'member_details.remarks',




                'member_relations.relation_name',
                'excluded_categories.name as exc_cat'
            )
            ->groupBy('member_details.id');
        if ($request->startDate !== null && $request->startDate != 'null' && $request->startDate != '') {
            $startDate = Carbon::createFromFormat($this->global->date_format, $request->startDate)->toDateString();
            $model = $model->where(DB::raw('DATE(member_details.`created_at`)'), '>=', $startDate);
        }

        if ($request->endDate !== null && $request->endDate != 'null' && $request->endDate != '') {
            $endDate = Carbon::createFromFormat($this->global->date_format, $request->endDate)->toDateString();
            $model = $model->where(DB::raw('DATE(member_details.`created_at`)'), '<=', $endDate);
        }
        if ($request->to_year > 0) {
            $now = Carbon::now();
            $to_year = $now->subYears(intval($request->to_year))->format('Y-m-d');
            $model = $model->where(DB::raw('DATE(member_details.`date_of_birth`)'), '>=', $to_year);
        }
        if ($request->from_year > 0) {
            $now = Carbon::now();
            $from_year = $now->subYears(intval($request->from_year))->format('Y-m-d');
            $model = $model->where(DB::raw('DATE(member_details.`date_of_birth`)'), '<=', $from_year);
        }
        if ($request->date_of_birth != null) {
            $birthDay = Carbon::createFromFormat('Y-m-d', $request->date_of_birth)->toDateString();
            $model = $model->where(DB::raw('DATE(member_details.`date_of_birth`)'), '=', $birthDay);
        }
        if ($request->member != 'all' && $request->member != '') {
            $model = $model->where('member_details.member_id', $request->member);
        }
        if ($request->status != 'all' && $request->status != '') {
            $model = $model->where('member_details.status_id', $request->status);
        }
        if ($request->age != 'all' && $request->age != '') {
            $model = $model->where('member_age.age_id', $request->age);
        }
        if ($request->gender != "select" && $request->gender != "") {
            $model = $model->where('member_details.gender', $request->gender);
        }
        if ($request->national_id != "select" && $request->national_id != "") {
            $model = $model->where('member_details.national_id', $request->national_id);
        }


        if ($request->par) {
            if ($request->par == 'working_member') {
                $model = $model->where('member_details.category_id', 1);
            } elseif ($request->par == 'affiliate_member') {
                $model = $model->where('member_details.category_id', 2);
            } elseif ($request->par == 'founding_member') {
                $model = $model->where('member_details.category_id', 3);
            } elseif ($request->par == 'seasonal_member') {
                $model = $model->where('member_details.category_id', 5);
            } elseif ($request->par == 'a_permit') {
                $model = $model->where('member_details.category_id', 7);
            } elseif ($request->par == 'honorary_member') {
                $model = $model->where('member_details.category_id', 4);
            } elseif ($request->par == 'athletic_member') {
                $model = $model->where('member_details.category_id', 6);
            } elseif ($request->par == 'sonsOver25') {
                $model = $model->where('member_details.status_id', 5);
            } elseif ($request->par == 'total_active_members') {
                $model = $model->where('member_details.status_id', 1);
            } elseif ($request->par == 'total_affiliate_members_dropped') {
                $model = $model->where('member_details.category_id', 2)
                    ->where('member_details.status_id', 2);
            } elseif ($request->par == 'total_employed_members_dropped') {
                $model = $model->where('member_details.category_id', 1)
                    ->where('member_details.status_id', 2);
            } elseif ($request->par == 'total_deceased_members') {
                $model = $model->where('member_details.status_id', 6);
            } elseif ($request->par == 'total_unpaid_members') {
                $model = $model->where('member_details.status_id', 8);
            } elseif ($request->par == 'total_paid_members') {
                $model = $model->where('member_details.status_id', 7);
            } elseif ($request->par == 'normal') {
                $model = $model->where('member_details.excluded_categories_id', 1);
            } elseif ($request->par == 'police') {
                $model = $model->where('member_details.excluded_categories_id', 2);
            } elseif ($request->par == 'judges') {
                $model = $model->where('member_details.excluded_categories_id', 3);
            } elseif ($request->par == 'journalists') {
                $model = $model->where('member_details.excluded_categories_id', 4);
            } elseif ($request->par == 'warrior_forces') {
                $model = $model->where('member_details.excluded_categories_id', 5);
            } elseif ($request->par == 'sports_affairs') {
                $model = $model->where('member_details.excluded_categories_id', 6);
            } elseif ($request->par == 'armed_forces') {
                $model = $model->where('member_details.excluded_categories_id', 7);
            } elseif ($request->par == 'people_with_needs') {
                $model = $model->where('member_details.excluded_categories_id', 8);
            }
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
            $model->whereHas('country', function ($query) use ($request) {
                return $query->where('id', $request->country_id);

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
            __('app.id') => ['data' => 'member_id', 'name' => 'id', 'visible' => true, 'exportable' => true, 'searchable' => true],
            '#' => ['data' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false, 'visible' => false],
            __('app.name') => ['data' => 'name', 'name' => 'name'],
            __('app.family_id') => ['data' => 'family_id', 'name' => 'family_id'],
            __('app.category') => ['data' => 'category_name', 'name' => 'category_id'],
            __('app.relation') => ['data' => 'relation_name', 'name' => 'relation_id'],
            __('modules.stripeCustomerAddress.city') => ['data' => 'city', 'name' => 'city'],
            __('modules.stocks.state') => ['data' => 'state', 'name' => 'state'],
            __('app.address') => ['data' => 'address', 'name' => 'address'],
            __('modules.members.profession') => ['data' => 'profession', 'name' => 'profession'],
            __('app.status') => ['data' => 'status_name', 'name' => 'status_id'],
            __('app.excluded_categories') => ['data' => 'exc_cat', 'name' => 'status_id'],
            __('app.email') => ['data' => 'email', 'name' => 'email'],
            //
            __('app.phone') => ['data' => 'phone', 'name' => 'phone'],
            __('app.createdAt') => ['data' => 'created_at', 'name' => 'created_at'],

            //mohamed &rola & shorok
            __('app.decision_number') => ['data' => 'decision_number', 'name' => 'decision_number'],
            __('app.national_id') => ['data' => 'national_id', 'name' => 'national_id'],
            __('app.age') => ['data' => 'age', 'name' => 'age'],
            __('app.religion') => ['data' => 'religion', 'name' => 'religion'],
            __('app.country_id') => ['data' => 'country_id', 'name' => 'country_id'],
            __('app.renewal_status') => ['data' => 'renewal_status', 'name' => 'renewal_status'],
            __('app.postal_code') => ['data' => 'postal_code', 'name' => 'postal_code'],
            __('app.face_book') => ['data' => 'face_book', 'name' => 'face_book'],
            __('app.twitter') => ['data' => 'twitter', 'name' => 'twitter'],
            __('app.excluded_categories_id') => ['data' => 'excluded_categories_id', 'name' => 'excluded_categories_id'],
            __('app.date_of_subscription') => ['data' => 'date_of_subscription', 'name' => 'date_of_subscription'],
            // __('app.date_of_subscription') => ['data' => 'date_of_subscription', 'name' => 'date_of_subscription'],

            // mohammed & rola
            __('modules.members.mem_HomePhone') => ['data' => 'mem_HomePhone', 'name' => 'mem_HomePhone'],
            __('modules.members.mem_WorkPhone') => ['data' => 'mem_WorkPhone', 'name' => 'mem_WorkPhone'],
            __('modules.members.memCard_MemberName') => ['data' => 'memCard_MemberName', 'name' => 'memCard_MemberName'],
            __('modules.members.mem_GraduationDesc') => ['data' => 'mem_GraduationDesc', 'name' => 'mem_GraduationDesc'],

            __('app.remarks') => ['data' => 'remarks', 'name' => 'remarks'],
            __('app.note_2') => ['data' => 'note_2', 'name' => 'note_2'],
            __('app.note_3') => ['data' => 'note_3', 'name' => 'note_3'],
            __('app.note_4') => ['data' => 'note_4', 'name' => 'note_4'],




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