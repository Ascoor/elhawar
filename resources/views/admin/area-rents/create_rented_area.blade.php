@extends('layouts.app')

@section('page-title')
<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 bg-title-left">
        <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __($pageTitle) }}</h4>
    </div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12 bg-title-right">
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}">@lang('app.menu.home')</a></li>
            <li><a href="{{ route('admin.area-rents.create') }}">{{ __($pageTitle) }}</a></li>
            <li class="active">@lang('app.addNew')</li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
    {{-- rola  --}}
    {{--  added the launages setting" --}} 
    {{-- @include('admin.dashboard-header.header_others'); --}}
</div>
@endsection

@push('head-script')

<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/summernote/dist/summernote.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bootstrap-colorselector/bootstrap-colorselector.min.css') }}">
<style>
    .salutation .form-control {
        padding: 2px 2px;
    }

    .select-category button {
        background-color: white !important;
        font-size: 13px;
        color: #565656;
        border: 1px solid #e4e7ea !important;
    }

    .select-category button:hover {
        color: #565656;
        opacity: 1;
    }

    .bootstrap-select .dropdown-toggle:focus {
        outline: none !important;
    }
</style>

@endpush




{{--  --}}

@section('content')



<div class="row">
    <div class="col-xs-12">

        <div class="panel panel-inverse">
            <div class="panel-heading"> @lang('modules.members.createMember')</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    @if (session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif
                    {!! Form::open(['id'=>'createRentedArea','class'=>'ajax-form','method'=>'POST']) !!}

                    {{-- <form id='formId' class="form" action="{{ route('admin.area-rents.store') }}" method="POST"
                        enctype="multipart/form-data"> --}}
                    <!-- .row -->

                    <!-- BEGIN MODAL -->
                    {{-- <div class="modal fade bs-modal-md in" id="my-event" role="dialog"
                        aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" id="modal-data-application">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                    <h4 class="modal-title"><i class="icon-plus"></i> @lang('modules.events.addEvent')
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    {!! Form::open(['id'=>'createEvent','class'=>'ajax-form','method'=>'POST']) !!} --}}
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label class="control-label">@lang('modules.rentarea.hall_name')
                                                        {{-- <a href="javascript:;" id="hall_name"
                                                            class="btn btn-xs btn-success btn-outline" ><i
                                                                class="fa fa-plus"></i></a> --}}
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

                                        </div>
                                        {{-- {!! Form::close() !!--}}

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-white waves-effect"
                                            data-dismiss="modal">@lang('app.close')</button>
                                            {{-- id="save-event" --}}
                                        <button type="submit"  id="save-form" 
                                            class="btn btn-success save-event waves-effect waves-light">@lang('app.submit')</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {{-- </div> --}}

                    <!-- END MODAL -->

                {{-- </form> --}}

                    {!! Form::close() !!}

                    
                </div>
            </div>
        </div>
    </div>
</div> <!-- .row -->


</div>
  {{--  --}}
</div>

{{-- Ajax Modal--}}
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
{{-- Ajax Modal Ends--}}
{{-- <div class='row '>
    <label for="first_name">First Name</label>
    <input type="text" name="name" id="name" />
    
    {{-- <label for="surname">Surname</label>
    <input type="text" name="surname" /> -- }}
    
    <label for="firstname">Firstname</label>
    <input type="text" name="firstname" id="firstname" disabled="disabled" />
    </div> --}}
@endsection
{{-- ------------------------------------------------------------------------------ --}}



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


    <script>
        calender();
        var getEventDetail = function (id, start, end) {
            var url = '{{ route('admin.sportActivity.show', ':id')}}?start='+start+'&end='+end;
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
         $('#new_session').change(function () {
            if($(this).is(':checked')){
                $('#new_fields').show();
                $('#related_fields').hide();
                $('#related_session_id').prop("name" , "");
                $('#new_session_id').prop("name" , "session_id");
            }
            else{
                $('#new_fields').hide();
                $('#related_session_id').prop("name" , "session_id");
            }
        })
        $('#related_session').change(function () {
            if($(this).is(':checked')){
                $('#related_fields').show();
                $('#new_fields').hide();
                $('#new_session_id').prop("name" , "");
                $('#related_session_id').prop("name" , "session_id");
            }
            else{
                $('#related_fields').hide();
                $('#new_session_id').prop("name" , "session_id");
            }
        })

        $(".select2").select2({
            formatNoMatches: function () {
                return "{{ __('messages.noRecordFound') }}";
            }
        });
        $('#sport').click(function () {
            var url = '{{ route('admin.sportAcademy.create')}}';
            $('#modelHeading').html('...');
            $.ajaxModal('#projectCategoryModal', url);
        })
        $('#level').click(function () {
            var url = '{{ route('admin.level.create')}}';
            $('#modelHeading').html('...');
            $.ajaxModal('#projectCategoryModal', url);
        })
        $('#group').click(function () {
            var url = '{{ route('admin.playerGroup.create')}}';
            $('#modelHeading').html('...');
            $.ajaxModal('#projectCategoryModal', url);
        })
        $('#location').click(function () {
            var url = '{{ route('admin.location.create')}}';
            $('#modelHeading').html('...');
            $.ajaxModal('#projectCategoryModal', url);
        })


        var url = '{{route('admin.area-rents.get-filter')}}';
        var employee = '';
        var client = '';
        var category = '';
        var event_type = '';
        var sport ='';
        var level = '';
        var group ='';
        var coach = '';
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
                container: '#createRentedArea',
                type: "POST",
                data: $('#createRentedArea').serialize(),
               
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

        function calender(sport,level,group,location_id,coach){

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
                url: '{{ route("admin.area-rents.get-filter") }}',
                extraParams: function() { // a function that returns an object
                    return {
                        // sport: sport,
                        // level: level,
                        // group: group,
                        // coach: coach,
                        // location_id: location_id
                        hall_name_id:hall_name_id,
                    };
                }

            }

        });
        $('#reset-filters').click(function () {
            $('.select2').val('all');
            $('.select2').trigger('change')
            sport = $('#sportID').val();
            level = $('#levelID').val();
            group = $('#groupID').val();
            location_id = $('#locationID').val();
            coach = $('#coachID').val();
            calendar.refetchEvents();
        });
        $('#apply-filters').click(function () {
            sport = $('#sportID').val();
            level = $('#levelID').val();
            group = $('#groupID').val();
            coach = $('#coachID').val();
            location_id = $('#locationID').val();

            calendar.refetchEvents();
            url = url+'?sport=' + sport + '&level=' + level + '&group=' + group + '&coach=' + coach + '&location_id=' + location_id;
        });
        document.addEventListener('DOMContentLoaded', function() {
            calendar.render();
        });

    </script>


@endpush
