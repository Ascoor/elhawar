@extends('layouts.app')

@section('page-title')
    <div class="row bg-title">

        <!-- .page title -->
        <div class="col-lg-8 col-md-5 col-sm-6 col-xs-12 bg-title-left">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __($pageTitle) }}
                <span class="text-info b-l p-l-10 m-l-5">{{ $totalAreaRents }}</span> <span
                        class="font-12 text-muted m-l-5"> @lang('modules.dashboard.totalAreaRents')</span>
            </h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-4 col-sm-6 col-md-7 col-xs-12 text-right bg-title-right">
            {{-- <a href="#" data-toggle="modal" data-target="#my-event" class="btn btn-sm btn-success btn-outline waves-effect waves-light">
                <i class="ti-plus"></i> @lang('modules.members.rent_new_area')
            </a> --}}
            {{-- Button at the top right to add new member --}}
        <a href= "{{ route('admin.area-rents.create') }}"
        class="btn btn-outline btn-success btn-sm"> @lang('modules.area_rents.rent_new_area') <i class="fa fa-plus"
            aria-hidden="true"></i></a>

            {{-- <a id="location_id"
               class="btn btn-outline btn-success btn-sm">@lang('modules.members.add_new_location') <i class="fa fa-plus"
                                                                                                    aria-hidden="true"></i></a> --}}
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}">@lang('app.menu.home')</a></li>
                <li class="active">{{ __($pageTitle) }}</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection

@push('head-script')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/daterange-picker/daterangepicker.css') }}" />


    <style>
        .filter-section::-webkit-scrollbar {
            display: block !important;
        }
    </style>
@endpush

@section('filter-section')
    <div class="row"  id="ticket-filters">

        <form action="" id="filter-form">


            <div class="col-xs-12">
                <div class="form-group">
                    <h5 >@lang('app.location')</h5>
                    <input type="text" id="location" name="location" class="form-control" value="">

                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <h5>@lang('app.capacity')</h5>

                    <input type="text" id="capacity" name="capacity" class="form-control" value="">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <h5>@lang('app.guardian')</h5>

                    <input type="text" id="guardian" name="guardian" class="form-control" value="">
                </div>
            </div>


            <div class="col-xs-12">
                <div class="form-group p-t-10">
                    <button type="button" id="apply-filters" class="btn btn-success col-md-6"><i class="fa fa-check"></i> @lang('app.apply')</button>
                    <button type="button" id="reset-filters" class="btn btn-inverse col-md-5 col-md-offset-1"><i class="fa fa-refresh"></i> @lang('app.reset')</button>
                </div>
            </div>
        </form>
    </div>
@endsection


@section('content')


<div class="row">

    {{-- button --}}
        <div class="sttabs tabs-style-line col-md-12">
            <div class="white-box">
                <nav>
                    <ul>
                        <li><a href="{{ route('admin.calender') }}"><span>@lang('app.calender')</span></a>
    
                        <li class="tab-current"><a href="{{ route('admin.area-rents.index') }}"><span>@lang('modules.area-rents.rentedarea_datatabe')</span></a>
                        </li>
    {{--                        <li><a href="{{ route('admin.attendances.attendanceByDate') }}"><span>@lang('modules.attendance.attendanceByDate')</span></a>--}}
    {{--                        </li>--}}
    
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    {{--  --}}


    <div class="row">

        <div class="col-xs-12">
            <div class="white-box">


                <div class="table-responsive">
                    {!! $dataTable->table(['class' => 'table table-bordered table-hover toggle-circle default footable-loaded footable']) !!}
                </div>
            </div>
        </div>
    </div>
    <!-- .row -->
    {{--    Ajax Modal--}}
    <div class="modal fade bs-modal-md in" id="clientCategoryModal" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-md" id="modal-data-application">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <span class="caption-subject font-red-sunglo bold uppercase" id="modelHeading"></span>
                </div>
                <div class="modal-body">
                    Loading...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn blue">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{--    Ajax Modal Ends--}}



    <!-- .row -->

    <!-- BEGIN MODAL -->
    {{-- <div class="modal fade bs-modal-md in" id="my-event" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" id="modal-data-application">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="icon-plus"></i> @lang('modules.events.addEvent')</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(['id'=>'createEvent','class'=>'ajax-form','method'=>'POST']) !!}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-5 ">
                                <div class="form-group">
                                    <label>@lang('modules.rentarea.hall_name')</label>
                                    <input type="text" name="session_name" id="session_name" class="form-control">
                                </div>
                            </div>

                            {{-- <div class="col-md-1 ">
                                <div class="form-group">
                                    <label>@lang('modules.sticky.colors')</label>
                                    <select id="colorselector" name="label_color">
                                        <option value="bg-info" data-color="#5475ed" selected>Blue</option>
                                        <option value="bg-warning" data-color="#f1c411">Yellow</option>
                                        <option value="bg-purple" data-color="#ab8ce4">Purple</option>
                                        <option value="bg-danger" data-color="#ed4040">Red</option>
                                        <option value="bg-success" data-color="#00c292">Green</option>
                                        <option value="bg-inverse" data-color="#4c5667">Grey</option>
                                    </select>
                                </div>
                            </div> -- }}

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">@lang('modules.members.location')
                                        <a href="javascript:;" id="location" class="btn btn-xs btn-success btn-outline"><i class="fa fa-plus"></i></a>
                                    </label>
                                    <select class="select2 form-control" data-placeholder="@lang('modules.members.location')"  id="location_id" name="location_id">
                                        {{-- @forelse($locations as $location)
                                            <option value="{{ $location->id }}">{{ ucwords($location->name) }}</option>
                                        @empty 
                                            <option value="">@lang('messages.noCategoryAdded')</option>
                                        @endforelse-- }}
                                    </select>
                                </div>
                            </div>
                       
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label  class="control-label">@lang('modules.arearent.clientname')
                                            <a href="javascript:;"
                                               id="group"
                                               class="btn btn-xs btn-outline btn-success">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </label>
                                        <select class="select2 form-control" data-placeholder="@lang('modules..arearent.phonenumber')"  id="group_id" name="group_id">
                                            {{-- @forelse($groups as $group)
                                                <option value="{{ $group->id }}">{{ ucwords($group->name) }}</option>
                                            @empty
                                                <option value="">@lang('messages.noCategoryAdded')</option>
                                            @endforelse -- }}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">@lang('modules.members.coaches')
                                        </label>
                                        <select class="select2 form-control" data-placeholder="@lang('modules.members.coaches')"  id="coach_id" name="coach_id">
                                            {{-- @forelse($coaches as $coach)
                                                <option value="{{ $coach->user_id }}">{{ ucwords($coach->user->name) }}</option>
                                            @empty
                                                <option value="">@lang('messages.noCategoryAdded')</option>
                                            @endforelse -- }}
                                        </select>
                                    </div>
                                </div>


                            </div>
                            <div class="row">
                                <div class="col-md-3 ">
                                    <div class="form-group">
                                        <label>@lang('modules.members.capacity')</label>
                                        <input type="text" name="capacity" id="capacity" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3 ">
                                    <div class="form-group">
                                        <label>@lang('modules.members.fees')</label>
                                        <input type="text" name="fees" id="fees" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3 ">
                                    <div class="form-group salutation">
                                        <label for="">@lang('app.currency')

                                        </label>
                                        <select name="currency" id="training_days" data-placeholder="@lang('app.currency')" class="form-control select2 " >
                                            {{-- @foreach($currencies as $currency)
                                                <option value="{{ $currency->currency_code }}">{{ ucwords($currency->currency_code) }}</option>
                                            @endforeach -- }}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-3">
                                    <div class="form-group">
                                        <label>@lang('modules.members.resv_type')</label>
                                        <select name="reservation_type" id="reservation_type" class="form-control">
                                            <option value="group">@lang('modules.members.group')</option>
                                            <option value="single">@lang('modules.members.single')</option>
                                            <option value="special">@lang('modules.members.special')</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                            <div class="col-xs-6 col-md-3 ">
                                <div class="form-group">
                                    <label>@lang('modules.events.startOn')</label>
                                    <input type="text" name="start_date" id="start_date" class="form-control">
                                </div>
                            </div>
                            <div class="col-xs-5 col-md-3">
                                <div class="form-group input-group bootstrap-timepicker timepicker">
                                    <label>&nbsp;</label>
                                    <input type="text" name="start_time" id="start_time"
                                           class="form-control">
                                </div>
                            </div>

                            <div class="col-xs-6 col-md-3">
                                <div class="form-group">
                                    <label>@lang('modules.events.endOn')</label>
                                    <input type="text" name="end_date" id="end_date" class="form-control">
                                </div>
                            </div>
                            <div class="col-xs-5 col-md-3">
                                <div class="form-group input-group bootstrap-timepicker timepicker">
                                    <label>&nbsp;</label>
                                    <input type="text" name="end_time" id="end_time"
                                           class="form-control">
                                </div>
                            </div>
                        </div>

                            <div class="row">
                                    <div class="col-xs-6">
                                        <div class="radio radio-info">
                                            <input id="new_session" name="related_session" value=""
                                                   type="radio" checked="checked">
                                            <label for="new_session">@lang('modules.members.new_session')</label>
                                        </div>
                                </div>
                                    <div class="col-xs-6">
                                        <div class="radio radio-info">
                                            <input id="related_session" name="related_session" value=""
                                                   type="radio">
                                            <label for="related_session">@lang('modules.members.related_session')</label>
                                        </div>
                                    </div>
                            </div>
                            <div class="row" id="new_fields" >
                                <div class="col-md-3 ">
                                    <div class="form-group">
                                        <label>@lang('modules.members.new_session_id')</label>
                                        <input type="text" name="session_id" id="new_session_id" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="related_fields" style="display: none">
                                <div class="col-xs-6 col-md-3">
                                    <div class="form-group">
                                        <label>@lang('modules.members.related_session_id')</label>
                                        <select name="" id="related_session_id" class="form-control">
                                        {{-- @foreach($session_ids as $session_id)
                                                <option value="{{ $session_id }}">{{ ucwords($session_id) }}</option>
                                            @endforeach -- }}
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <div class="checkbox checkbox-info">
                                        <input id="repeat-event" name="repeat" value="yes"
                                               type="checkbox">
                                        <label for="repeat-event">@lang('modules.events.repeat')</label>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row" id="repeat-fields" style="display: none">
                            <div class="col-xs-6 col-md-3 ">
                                <div class="form-group">
                                    <label>@lang('modules.events.repeatEvery')</label>
                                    <input type="number" min="1" value="1" name="repeat_count" class="form-control">
                                </div>
                            </div>
                            <div class="col-xs-6 col-md-3">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <select name="repeat_type" id="" class="form-control">
                                        <option value="day">@lang('app.day')</option>
                                        <option value="week">@lang('app.week')</option>
                                        <option value="month">@lang('app.month')</option>
                                        <option value="year">@lang('app.year')</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-6 col-md-3">
                                <div class="form-group">
                                    <label>@lang('modules.events.cycles') <a class="mytooltip" href="javascript:void(0)"> <i class="fa fa-info-circle"></i><span class="tooltip-content5"><span class="tooltip-text3"><span class="tooltip-inner2">@lang('modules.events.cyclesToolTip')</span></span></span></a></label>
                                    <input type="text" name="repeat_cycles" id="repeat_cycles" value="0" class="form-control">
                                </div>
                            </div>
                        </div>

                    </div>
                    {!! Form::close() !!}

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white waves-effect" data-dismiss="modal">@lang('app.close')</button>
                    <button type="button" class="btn btn-success save-event waves-effect waves-light">@lang('app.submit')</button>
                </div>
            </div>
        </div>
    </div>
</div> --}}

   <!-- END MODAL -->


   
@endsection

@push('footer-script')
    <script src="{{ asset('plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script>
    <script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('js/datatables/buttons.server-side.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/moment/moment.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/daterange-picker/daterangepicker.js') }}"></script>
    {!! $dataTable->scripts() !!}

    <script>
        var table;
        $(function () {
            $('body').on('click', '.sa-params', function () {
                // var id = $(this).data('user-id');
                var id = $(this).data('user-id');

                swal({
                    title: "@lang('messages.sweetAlertTitle')",
                    text: "@lang('messages.confirmation.recoverDeleteUser')",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "@lang('messages.deleteConfirmation')",
                    cancelButtonText: "@lang('messages.confirmNoArchive')",
                    closeOnConfirm: true,
                    closeOnCancel: true
                }, function(isConfirm){
                    if (isConfirm) {

                        var url = "{{ route('admin.area-rents.destroy',':id') }}";
                        url = url.replace(':id', id);

                        var token = "{{ csrf_token() }}";

                        $.easyAjax({
                            type: 'POST',
                            url: url,
                            data: {'_token': token, '_method': 'DELETE'},
                            success: function (response) {
                                if (response.status == "success") {
                                    $.easyBlockUI('#members-table');
                                    window.LaravelDataTables["members-table"].draw();
                                    $.easyUnblockUI('#members-table');
                                }
                            }
                        });
                    }
                });
            });

        });

        $('#location_id').click(function () {
            var url = '{{ route('admin.area-rents.create')}}';
            $('#modelHeading').html('...');
            $.ajaxModal('#clientCategoryModal', url);
        })

        $('.toggle-filter').click(function () {
            $('#ticket-filters').toggle('slide');
        })

        
        // $('#apply-filters').click(function () {
        //     $('#members-table').on('preXhr.dt', function (e, settings, data) {
        //         var location = $('#location').val();
        //         var capacity = $('#capacity').val();
        //         var guardian = $('#guardian').val();

        //         data['location'] = location;
        //         data['capacity'] = capacity;
        //         data['guardian'] = guardian;

        //     });
        //     $.easyBlockUI('#members-table');
        //     window.LaravelDataTables["members-table"].draw();
        //     $.easyUnblockUI('#members-table');
        // });

        // $('#reset-filters').click(function () {
        //     $('#filter-form')[0].reset();
        //     $('.select2').val('all');
        //     $('#filter-form').find('select').select2();

        //     $.easyBlockUI('#members-table');
        //     $('#start-date').val('');
        //     $('#end-date').val('');
        //     $('#reportrange span').html('');

        //     window.LaravelDataTables["members-table"].draw();
        //     $.easyUnblockUI('#members-table');
        // })

        // function exportData(){

        //     var member = $('#member').val();
        //     var status = $('#status').val();

        //     var url = '{{ route('admin.clients.export', [':status', ':client']) }}';
        // // var url = '{{ route('admin.attendances.export', [':startDate' ,':endDate' ,':employee']) }}';

        //     url = url.replace(':member', member);
        //     url = url.replace(':status', status);

        //     window.area-rents.href = url;
        // }

    </script>
@endpush