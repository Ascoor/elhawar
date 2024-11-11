@extends('layouts.app')
<script src='https://cdn.jsdelivr.net/npm/@6.1.8/index.global.min.js'></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>

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
{{-- <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core/main.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid/main.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid/main.css" rel="stylesheet" /> --}}

    <link rel="stylesheet" href="{{ asset('css/full-calendar/main.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/timepicker/bootstrap-timepicker.min.css') }}">

    <link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/multiselect/css/multi-select.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-colorselector/bootstrap-colorselector.min.css') }}">
    <style>
        #my-event{
            overflow-y: scroll;
        }
    </style>
@endpush

@section('content')



<div class="row">

    {{-- button --}}
        <div class="sttabs tabs-style-line col-md-12">
            <div class="white-box">
                <nav>
                    <ul>
                        <li class="tab-current"><a href="{{ route('admin.calender') }}"><span>@lang('app.calender')</span></a>
    
                        <li ><a href="{{ route('admin.area-rents.index') }}"><span>@lang('modules.area-rents.rentedarea_datatabe')</span></a>
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
                


                <div id="calendar"></div>
            </div>
        </div>
    </div>
    <!-- .row -->

    <!-- BEGIN MODAL -->
    <div class="modal fade bs-modal-md in" id="my-event" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
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
                                    <div class="form-group">
                                        <label class="control-label">@lang('modules.rentarea.hall_name')
                                            <a href="javascript:;" id="hall_name"
                                                class="btn btn-xs btn-success btn-outline" ><i
                                                    class="fa fa-plus"></i></a>
                                        </label>
                                        {{-- onchange="updateLocationVal()" --}}
                                        <select  onchange="getVal('{{ $AreaRents }}')" class="select2 form-control"
                                            data-placeholder="@lang('modules.rentarea.hall_name')"
                                            id="hall_name_id" name="hall_name_id"   >
                                            @forelse($AreaRents as $item)
                                           
                                        <option   onchange="saveSubTask('{{ $item->id }}')" class='getValBtnID'  value="{{ $item->id }}">
                                            {{ $item->area_name }}
                                        </option>
                                        @empty
                                        <option value="">@lang('messages.noCategoryAdded')</option>
                                        @endforelse 
                                        </select>
                                      
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-1 ">
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
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">@lang('modules.members.location')
                                        {{-- <a href="javascript:;" id="location"
                                            class="btn btn-xs btn-success btn-outline"><i
                                                class="fa fa-plus"></i></a> --}}
                                    </label>
                                    <select class="select2 form-control"
                                        data-placeholder="@lang('modules.members.location')"
                                        id="location_id" name="location_id">
                                        @forelse($AreaRents as $item)
                                        <option value="{{ $item->id }}">{{ ucwords($item->location)
                                            }}</option>
                                        @empty
                                        <option value="">@lang('messages.noCategoryAdded')</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>

                            {{-- <div class="row"> --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label
                                            class="control-label">@lang('modules.arearent.clientname')
                                            {{-- <a href="javascript:;" id="clientname"
                                            class="btn btn-xs btn-success btn-outline"><i
                                                class="fa fa-plus"></i></a> --}}
                                        </label>
                                        
                                        <input type="text" name="clientname_id" placeholder="@lang('modules.arearent.clientname')" id="clientname_id" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label
                                            class="control-label">@lang('modules.arearent.phonenumber')
                                        </label>
                                        <input type="text" name="phonenumber_id" placeholder="@lang('modules.arearent.phonenumber')" id="phonenumber_id" class="form-control">
                                    </div>
                                </div>


                                {{--
                            </div> --}}
                            {{-- <div class="row"> --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label
                                            class="control-label">@lang('modules.members.capacity')
                                        </label>
                                        <input type="text"  readonly name="capacity" id="capacity" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label
                                            class="control-label">@lang('modules.members.fees')
                                        </label>
                                        <input type="text" name="fees" id="fees" class="form-control">
                                    </div>
                                </div>
                              
                                
                              

                                {{--
                            </div> --}}
                            {{-- <div class="row"> --}}
                                <div class="col-xs-6 col-md-3 ">
                                    <div class="form-group">
                                        <label>@lang('modules.events.startOn')</label>
                                        <input type="text" name="start_date" id="start_date" placeholder="@lang('modules.events.startOn')"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-5 col-md-3">
                                    <div class="form-group input-group bootstrap-timepicker timepicker">
                                         {{-- <label>&nbsp;</label> --}}
                                        <label>@lang('modules.events.start_time')</label>
                                        <input type="text" name="start_time" id="start_time"
                                            class="form-control">
                                    </div>
                                </div>

                                <div class="col-xs-6 col-md-3">
                                    <div class="form-group">
                                        <label>@lang('modules.events.endOn')</label>
                                        <input type="text" name="end_date" id="end_date"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-5 col-md-3">
                                    <div class="form-group input-group bootstrap-timepicker timepicker">
                                        {{-- <label>&nbsp;</label> --}}
                                        <label> @lang('modules.events.end_time')</label>
                                        <input type="text" name="end_time" id="end_time"
                                            class="form-control">
                                    </div>
                                </div>
                            {{-- </div> --}}

                           
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-xs-6">
                                        <div class="checkbox checkbox-info">
                                            <input id="guardian_employee" name="guardian_employee" value="yes"
                                                type="checkbox">
                                            <label
                                                for="guardian_employee">@lang('modules.area-rents.guardian')</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group">
                                    <div class="col-xs-6">
                                        <div class="checkbox checkbox-info">
                                            <input id="repeat-event" name="repeat" value="yes"
                                                type="checkbox">
                                            <label
                                                for="repeat-event">@lang('modules.events.repeat')</label>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row" id="repeat-fields" style="display: none">
                                <div class="col-xs-6 col-md-3 ">
                                    <div class="form-group">
                                        <label>@lang('modules.events.repeatEvery')</label>
                                        <input type="number" min="1" value="1" name="repeat_count"
                                            class="form-control">
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
                                        <label>@lang('modules.events.cycles') <a class="mytooltip"
                                                href="javascript:void(0)"> <i
                                                    class="fa fa-info-circle"></i><span
                                                    class="tooltip-content5"><span
                                                        class="tooltip-text3"><span
                                                            class="tooltip-inner2">@lang('modules.events.cyclesToolTip')</span></span></span></a></label>
                                        <input type="text" name="repeat_cycles" id="repeat_cycles"
                                            value="0" class="form-control">
                                    </div>
                                </div>
                            </div>



                        </div>   {{-- end or row --}}
                       

                     




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
    {{--Ajax Modal--}}
    <div class="modal fade bs-modal-md in" id="sessionDetailModal" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" id="modal-data-application">
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
                    <button type="button" class="btn blue">Save changesrrrr</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{--Ajax Modal Ends--}}
    {{--Ajax Modal--}}
    <div class="modal fade bs-modal-md in" id="projectCategoryModal" role="dialog" aria-labelledby="myModalLabel"
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
    {{--Ajax Modal Ends--}}

@endsection
@push('footer-script')

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.8/index.min.js" integrity="sha512-xCMh+IX6X2jqIgak2DBvsP6DNPne/t52lMbAUJSjr3+trFn14zlaryZlBcXbHKw8SbrpS0n3zlqSVmZPITRDSQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.8/index.global.js" integrity="sha512-i1QYxrZ2eJKNdGkTdSVfokfaXHQEpcjj5CfnWhJ6dQ0X76aG9rIaWvB77GpqFtVp83iRzE/b6e20weGSZpecjQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.8/index.global.min.js" integrity="sha512-R2ktoX0ULWEVnA5+oE1kuNEl3KZ9SczXbJk4aT7IgPNfbgTqMG7J14uVqPsdQmZfyTjh0rddK9sG/Mlj97TMEw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.8/index.js" integrity="sha512-bBl4oHIOeYj6jgOLtaYQO99mCTSIb1HD0ImeXHZKqxDNC7UPWTywN2OQRp+uGi0kLurzgaA3fm4PX6e2Lnz9jQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="{{ asset('plugins/bower_components/moment/moment.js') }}"></script>

    <script src='{{ asset('js/full-calendar/rrule.min.js') }}'></script>
    <script src="{{ asset('js/full-calendar/main.min.js') }}"></script>
    <script src="{{ asset('js/full-calendar/locales-all.min.js') }}"></script>
    <script src='{{ asset('js/full-calendar/main.global.min.js') }}'></script>


    <script src="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/timepicker/bootstrap-timepicker.min.js') }}"></script>

    <script src="{{ asset('js/cbpFWTabs.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/multiselect/js/jquery.multi-select.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap-colorselector/bootstrap-colorselector.min.js') }}"></script>


    <script>
        // calender();
        var getEventDetail = function (id, start, end) {
            var url = '{{ route('admin.area-rents.show', ':id')}}?start='+start+'&end='+end;
            url = url.replace(':id', id);

            $('#modelHeading').html('Event');
            $.ajaxModal('#sessionDetailModal', url);
        }

        var calendarLocale = '{{ $global->locale }}';
        var firstDay = '{{ $global->week_start }}';
        jQuery('#start_date, #end_date').datepicker({
            autoclose: true,
            todayHighlight: true,
            weekStart:'{{ $global->week_start }}',
            format: '{{ $global->date_picker_format }}',

        }).on('changeDate', function (selected) {
            $('#end_date').datepicker({
                autoclose: true,
                todayHighlight: true,
                weekStart:'{{ $global->week_start }}',
                format: '{{ $global->date_picker_format }}',
            });
            var minDate = new Date(selected.date.valueOf());
            $('#end_date').datepicker("update", minDate);
            $('#end_date   ').datepicker('setStartDate', minDate);
        });

        $('#colorselector').colorselector();

        $('#start_time, #end_time').timepicker({

            @if($global->time_format == 'H:i')

            showMeridian: false
            @endif
        });


        $(".select2").select2({
            formatNoMatches: function () {
                return "{{ __('messages.noRecordFound') }}";
            }
        });
        // $('#sport').click(function () {
        //     var url = '{{ route('admin.sports.create')}}';
        //     $('#modelHeading').html('...');
        //     $.ajaxModal('#projectCategoryModal', url);
        // })

        // $('#location').click(function () {
        //     var url = '{{ route('admin.location.create')}}';
        //     $('#modelHeading').html('...');
        //     $.ajaxModal('#projectCategoryModal', url);
        // })


        var url = '{{route('admin.training.get-filter')}}';
        var employee = '';
        var client = '';
        var category = '';
        var event_type = '';
        var sport ='';
        var training = '';

        var location_id = '';
        function addEventModal(start, end, allDay){
            if(start){

                var sd = new Date(start);
                var momemtFormat = "{{ $global->moment_format }}";
                if(momemtFormat!= null ){
                    var mDate = moment(sd).format("{{ $global->moment_format }}");
                }else{
                    $('#start_date').val('{{ \Carbon\Carbon::now()->format($global->date_format) }}');
                    $('#end_date').val('{{ \Carbon\Carbon::now()->format($global->date_format) }}');
                }

                var curr_date = sd.getDate();
                if(curr_date < 10){
                    curr_date = '0'+curr_date;
                }
                var curr_month = sd.getMonth();
                curr_month = curr_month+1;
                if(curr_month < 10){
                    curr_month = '0'+curr_month;
                }
                var curr_year = sd.getFullYear();

                $('#start_date').val(mDate);

                var ed = new Date(start);
                var curr_date = sd.getDate();
                if(curr_date < 10){
                    curr_date = '0'+curr_date;
                }
                var curr_month = sd.getMonth();
                curr_month = curr_month+1;
                if(curr_month < 10){
                    curr_month = '0'+curr_month;
                }
                var curr_year = ed.getFullYear();
                $('#end_date').val(mDate);

                // $('#start_date, #end_date').datepicker('destroy');
                jQuery('#start_date, #end_date').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    weekStart:'{{ $global->week_start }}',
                    format: '{{ $global->date_picker_format }}',
                })
            }

            $('#my-event').modal('show');

        }
        $('.toggle-filter').click(function () {
            $('#ticket-filters').slideToggle();
        })
        $('.save-event').click(function () {
            $.easyAjax({
                url: '{{route('admin.area-rents.store')}}',
                container: '#createEvent',
                type: "POST",
                data: $('#createEvent').serialize(),
                success: function (response) {
                    if(response.status == 'success'){
                        window.location.reload();
                    }
                }
            })
        })

        $('#repeat-event').change(function () {
            if($(this).is(':checked')){
                $('#repeat-fields').show();
            }
            else{
                $('#repeat-fields').hide();
            }
        })

        // function calender(sport,training,location_id){

        // }
//         function calender(training){

// }
        var initialTimeZone = 'UTC';
        var initialLocaleCode = '{{ $global->locale }}';
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            firstDay: firstDay,
            locale: initialLocaleCode,
            timeZone: initialTimeZone,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
            },

            // initialDate: '2020-09-12',
            navLinks: true, // can click day/week names to navigate views
            selectable: true,
            selectMirror: true,
            select: function(arg) {
                addEventModal(arg.start, arg.end, arg.allDay);
                calendar.unselect()
            },
            eventClick: function(arg) {
                getEventDetail(arg.event.id, arg.event.startStr, arg.event.endStr);
            },

            editable: false,
            dayMaxEvents: true, // allow "more" link when too many events
            events: {
                url: '{{ route("admin.area-rents.get-filter") }}',
                // className:
                //   [  r:'rrrrrrrrrrrrrrrrrrrrrrrrrr'],
               
                extraParams:{
                        locatiron:'rrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr',
                        // sport: sport,
                        // training: training,
                        // location_id: location_id
                },
                extendedProps:{
                        location:'rrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr',  
                    
                }

            }

        });
        calendar.render();
        $('#reset-filters').click(function () {
            $('.select2').val('all');
            $('.select2').trigger('change')
            sport = $('#sportID').val();
            training = $('#trainingID').val();
            location_id = $('#locationID').val();
            calendar.refetchEvents();
        });
        $('#apply-filters').click(function () {
            sport = $('#sportID').val();
            training = $('#trainingID').val();
            location_id = $('#locationID').val();

            calendar.refetchEvents();
            url = url+'?sport=' + sport + '&training=' + training + '&location_id=' + location_id;
        });
        // document.addEventListener('DOMContentLoaded', function() {
        //     calendar.render();
        // });

    </script>


@endpush
