@extends('layouts.club_member-app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 bg-title-left">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __($pageTitle) }}</h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12 text-right bg-title-right">
            <a href="javascript:;" id="toggle-filter" class="btn btn-sm btn-inverse btn-outline toggle-filter"><i class="fa fa-sliders"></i></a>

            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}">@lang('app.menu.home')</a></li>
                <li class="active">{{ __($pageTitle) }}</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection

@push('head-script')
    <link rel="stylesheet" href="{{ asset('css/full-calendar/main.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/timepicker/bootstrap-timepicker.min.css') }}">

    <link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/multiselect/css/multi-select.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-colorselector/bootstrap-colorselector.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/summernote/dist/summernote.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/daterange-picker/daterangepicker.css') }}" />

    <style>
        #my-event{
            overflow-y: scroll;
        }
    </style>
@endpush

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="white-box">
                <div class="row" style="display: none; " id="ticket-filters">
                    <div class="col-xs-12">
                        <h4>@lang('app.filterBy') <a href="javascript:;" class="pull-right toggle-filter"><i class="fa fa-times-circle-o"></i></a></h4>
                    </div>
                    <form action="" id="filter-form">
                        {{--                        <div class="col-xs-12">--}}
                        {{--                            <h5 >@lang('app.selectDateRange')</h5>--}}
                        {{--                            <div class="form-group">--}}
                        {{--                                <div id="reportrange" class="form-control reportrange">--}}
                        {{--                                    <i class="fa fa-calendar"></i>&nbsp;--}}
                        {{--                                    <span></span> <i class="fa fa-caret-down pull-right"></i>--}}
                        {{--                                </div>--}}

                        {{--                                <input type="hidden" class="form-control" id="start-date" placeholder="@lang('app.startDate')"--}}
                        {{--                                       value=""/>--}}
                        {{--                                <input type="hidden" class="form-control" id="end-date" placeholder="@lang('app.endDate')"--}}
                        {{--                                       value=""/>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                        <div class="col-md-3">
                            <h5 >@lang('modules.club.trip')</h5>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <select class="select2 form-control" data-placeholder="@lang('modules.club.trip')"  id="tripID" name="tripID">
                                            <option value="all">@lang('app.all')</option>
                                            @foreach($trips as $trip)
                                                <option value="{{ $trip->id }}">{{ ucwords($trip->trip_name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-3">
                            <h5 >@lang('modules.club.supervisor')</h5>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <select class="select2 form-control" data-placeholder="@lang('modules.club.supervisor')"  id="supervisorID" name="supervisorID">
                                            <option value="all">@lang('app.all')</option>
                                            @foreach($supervisors as $supervisor)
                                                <option value="{{ $supervisor->user_id }}">{{ ucwords($supervisor->user->name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-group m-t-10">
                                <label class="control-label col-xs-12">&nbsp;</label>
                                <button type="button" id="apply-filters" class="btn btn-success btn-sm"><i class="fa fa-check"></i> @lang('app.apply')</button>
                                <button type="button" id="reset-filters" class="btn btn-inverse btn-sm"><i class="fa fa-refresh"></i> @lang('app.reset')</button>
                            </div>
                        </div>
                    </form>
                </div>


                <div id="calendar"></div>
            </div>
        </div>
    </div>
    <!-- .row -->

    <!-- BEGIN MODAL -->
    {{--    <div class="modal fade bs-modal-md in" id="my-event" role="dialog" aria-labelledby="myModalLabel"--}}
    {{--         aria-hidden="true">--}}
    {{--        <div class="modal-dialog modal-lg" id="modal-data-application">--}}
    {{--            <div class="modal-content">--}}
    {{--                <div class="modal-header">--}}
    {{--                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>--}}
    {{--                    <h4 class="modal-title"><i class="icon-plus"></i> @lang('modules.events.addEvent')</h4>--}}
    {{--                </div>--}}
    {{--                <div class="modal-body">--}}
    {{--                    {!! Form::open(['id'=>'createEvent','class'=>'ajax-form','method'=>'POST']) !!}--}}
    {{--                    <div class="form-body">--}}
    {{--                        <div class="row">--}}
    {{--                            <div class="col-md-5 ">--}}
    {{--                                <div class="form-group">--}}
    {{--                                    <label>@lang('modules.club.tripName')</label>--}}
    {{--                                    <input type="text" name="trip_name" id="trip_name" class="form-control">--}}
    {{--                                </div>--}}
    {{--                            </div>--}}

    {{--                            <div class="col-md-1 ">--}}
    {{--                                <div class="form-group">--}}
    {{--                                    <label>@lang('modules.sticky.colors')</label>--}}
    {{--                                    <select id="colorselector" name="label_color">--}}
    {{--                                        <option value="bg-info" data-color="#5475ed" selected>Blue</option>--}}
    {{--                                        <option value="bg-warning" data-color="#f1c411">Yellow</option>--}}
    {{--                                        <option value="bg-purple" data-color="#ab8ce4">Purple</option>--}}
    {{--                                        <option value="bg-danger" data-color="#ed4040">Red</option>--}}
    {{--                                        <option value="bg-success" data-color="#00c292">Green</option>--}}
    {{--                                        <option value="bg-inverse" data-color="#4c5667">Grey</option>--}}
    {{--                                    </select>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}

    {{--                            <div class="col-md-6">--}}
    {{--                                <div class="form-group">--}}
    {{--                                    <label class="control-label">@lang('modules.club.supervisor')--}}
    {{--                                    </label>--}}
    {{--                                    <select class="select2 form-control" data-placeholder="@lang('modules.club.supervisor')"  id="supervisor_id" name="supervisor_id">--}}
    {{--                                        @foreach($supervisors as $supervisor)--}}
    {{--                                            <option value="{{ $supervisor->user_id }}">{{ ucwords($supervisor->user->name) }}</option>--}}
    {{--                                        @endforeach--}}
    {{--                                    </select>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                        <div class="row">--}}

    {{--                            <div class="col-md-3 ">--}}
    {{--                                <div class="form-group">--}}
    {{--                                    <label>@lang('modules.members.member_fees')</label>--}}
    {{--                                    <input type="text" name="member_fees" id="member_fees" class="form-control">--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                            <div class="col-md-3 ">--}}
    {{--                                <div class="form-group">--}}
    {{--                                    <label>@lang('modules.members.non_member_fees')</label>--}}
    {{--                                    <input type="text" name="non_member_fees" id="non_member_fees" class="form-control">--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                            <div class="col-md-3 ">--}}
    {{--                                <div class="form-group">--}}
    {{--                                    <label>@lang('modules.members.escort_fees')</label>--}}
    {{--                                    <input type="text" name="escort_fees" id="escort_fees" class="form-control">--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                            <div class="col-md-3 ">--}}
    {{--                                <div class="form-group salutation">--}}
    {{--                                    <label for="">@lang('app.currency')--}}

    {{--                                    </label>--}}
    {{--                                    <select name="currency" id="training_days" data-placeholder="@lang('app.currency')" class="form-control select2 " >--}}
    {{--                                        @foreach($currencies as $currency)--}}
    {{--                                            <option value="{{ $currency->currency_code }}">{{ ucwords($currency->currency_code) }}</option>--}}
    {{--                                        @endforeach--}}
    {{--                                    </select>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}

    {{--                        </div>--}}
    {{--                        <div class="row">--}}
    {{--                            <div class="col-md-3 ">--}}
    {{--                                <div class="form-group">--}}
    {{--                                    <label>@lang('modules.members.capacity')</label>--}}
    {{--                                    <input type="text" name="capacity" id="capacity" class="form-control">--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                        <div class="row">--}}
    {{--                            <div class="col-xs-6 col-md-3 ">--}}
    {{--                                <div class="form-group">--}}
    {{--                                    <label>@lang('modules.events.startOn')</label>--}}
    {{--                                    <input type="text" name="start_date" id="start_date" class="form-control">--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                            <div class="col-xs-5 col-md-3">--}}
    {{--                                <div class="form-group input-group bootstrap-timepicker timepicker">--}}
    {{--                                    <label>&nbsp;</label>--}}
    {{--                                    <input type="text" name="start_time" id="start_time"--}}
    {{--                                           class="form-control">--}}
    {{--                                </div>--}}
    {{--                            </div>--}}

    {{--                            <div class="col-xs-6 col-md-3">--}}
    {{--                                <div class="form-group">--}}
    {{--                                    <label>@lang('modules.events.endOn')</label>--}}
    {{--                                    <input type="text" name="end_date" id="end_date" class="form-control">--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                            <div class="col-xs-5 col-md-3">--}}
    {{--                                <div class="form-group input-group bootstrap-timepicker timepicker">--}}
    {{--                                    <label>&nbsp;</label>--}}
    {{--                                    <input type="text" name="end_time" id="end_time"--}}
    {{--                                           class="form-control">--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}

    {{--                        <div class="row">--}}
    {{--                            <div class="col-md-12">--}}
    {{--                                <label>@lang('modules.club.program')</label>--}}
    {{--                                <div class="form-group">--}}
    {{--                                    <textarea name="program" id="program" class="form-control summernote" rows="5"></textarea>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}



    {{--                        </div>--}}

    {{--                        <div class="row">--}}
    {{--                            <div class="form-group">--}}
    {{--                                <div class="col-xs-6">--}}
    {{--                                    <div class="checkbox checkbox-info">--}}
    {{--                                        <input id="repeat-event" name="repeat" value="yes"--}}
    {{--                                               type="checkbox">--}}
    {{--                                        <label for="repeat-event">@lang('modules.events.repeat')</label>--}}
    {{--                                    </div>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}


    {{--                        <div class="row" id="repeat-fields" style="display: none">--}}
    {{--                            <div class="col-xs-6 col-md-3 ">--}}
    {{--                                <div class="form-group">--}}
    {{--                                    <label>@lang('modules.events.repeatEvery')</label>--}}
    {{--                                    <input type="number" min="1" value="1" name="repeat_count" class="form-control">--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                            <div class="col-xs-6 col-md-3">--}}
    {{--                                <div class="form-group">--}}
    {{--                                    <label>&nbsp;</label>--}}
    {{--                                    <select name="repeat_type" id="" class="form-control">--}}
    {{--                                        <option value="day">@lang('app.day')</option>--}}
    {{--                                        <option value="week">@lang('app.week')</option>--}}
    {{--                                        <option value="month">@lang('app.month')</option>--}}
    {{--                                        <option value="year">@lang('app.year')</option>--}}
    {{--                                    </select>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}

    {{--                            <div class="col-xs-6 col-md-3">--}}
    {{--                                <div class="form-group">--}}
    {{--                                    <label>@lang('modules.events.cycles') <a class="mytooltip" href="javascript:void(0)"> <i class="fa fa-info-circle"></i><span class="tooltip-content5"><span class="tooltip-text3"><span class="tooltip-inner2">@lang('modules.events.cyclesToolTip')</span></span></span></a></label>--}}
    {{--                                    <input type="text" name="repeat_cycles" id="repeat_cycles" value="0" class="form-control">--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}

    {{--                    </div>--}}
    {{--                    {!! Form::close() !!}--}}

    {{--                </div>--}}
    {{--                <div class="modal-footer">--}}
    {{--                    <button type="button" class="btn btn-white waves-effect" data-dismiss="modal">@lang('app.close')</button>--}}
    {{--                    <button type="button" class="btn btn-success save-event waves-effect waves-light">@lang('app.submit')</button>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
    {{--    </div>--}}
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
                    <button type="button" class="btn blue">Save changes</button>
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
    <script src="{{ asset('plugins/bower_components/summernote/dist/summernote.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/daterange-picker/daterangepicker.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>



    <script>
        calender();
        var getEventDetail = function (id, start, end) {
            var url = '{{ route('club.trips.show', ':id')}}?start='+start+'&end='+end;
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
        $('.summernote').summernote({
            height: 200,                 // set editor height
            minHeight: null,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor
            focus: false,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough']],
                ['fontsize', ['fontsize']],
                ['para', ['ul', 'ol', 'paragraph']],
                ["view", ["fullscreen"]]
            ]
        });

        $(".select2").select2({
            formatNoMatches: function () {
                return "{{ __('messages.noRecordFound') }}";
            }
        });


        var url = '{{route('club.trips.get-family-sessions')}}';
        var employee = '';
        var client = '';
        var category = '';
        var event_type = '';
        var trip ='';
        var supervisor = '';

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


        function calender(trip,supervisor){

        }
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
                url: '{{ route("club.trips.get-family-sessions") }}',
                extraParams: function() { // a function that returns an object
                    return {
                        trip: trip,
                        supervisor: supervisor,

                    };
                }

            }

        });
        $('#reset-filters').click(function () {
            $('.select2').val('all');
            $('.select2').trigger('change')
            trip = $('#tripID').val();
            supervisor = $('#supervisorID').val();
            $('#start-date').val('');
            $('#end-date').val('');
            $('#reportrange span').html('');
            calendar.refetchEvents();
        });
        $('#apply-filters').click(function () {
            trip = $('#tripID').val();
            supervisor = $('#supervisorID').val();


            calendar.refetchEvents();
            url = url+'?trip=' + trip + '&supervisor=' + supervisor ;
        });
        document.addEventListener('DOMContentLoaded', function() {
            calendar.render();
        });

        $(function() {
            var dateformat = '{{ $global->moment_format }}';

            var start = '';
            var end = '';

            function cb(start, end) {
                if(start){
                    $('#start-date').val(start.format(dateformat));
                    $('#end-date').val(end.format(dateformat));
                    $('#reportrange span').html(start.format(dateformat) + ' - ' + end.format(dateformat));
                }

            }
            moment.locale('{{ $global->locale }}');
            $('#reportrange').daterangepicker({
                // startDate: start,
                // endDate: end,
                locale: {
                    language: '{{ $global->locale }}',
                    format: '{{ $global->moment_format }}',
                },
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);

            cb(start, end);

        });
    </script>


@endpush