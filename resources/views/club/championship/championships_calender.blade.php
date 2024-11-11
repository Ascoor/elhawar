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
                    <div class="col-md-3">
                        <h5>@lang('app.select') @lang('app.sport')</h5>

                        <div class="form-group">
                            <select class="select2 form-control" data-placeholder="@lang('app.sport')" id="sportID">
                                <option value="all">@lang('app.all')</option>
                                @foreach($sports as $sport)
                                <option
                                    value="{{ $sport->id }}">{{ ucwords($sport->name) }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <h5 >@lang('modules.club.sport_type')</h5>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <select class="select2 form-control" data-placeholder="@lang('modules.club.sport_type')"  id="sport_typeID" name="sport_typeID">
                                        <option value="all">@lang('app.all')</option>
                                        <option value="group">@lang('modules.members.group')</option>
                                        <option value="single">@lang('modules.members.single')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <h5 >@lang('app.location')</h5>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <select class="select2 form-control" data-placeholder="@lang('app.location')"  id="locationID" name="locationID">
                                        <option value="all">@lang('app.all')</option>
                                        @foreach($locations as $location)
                                        <option value="{{ $location->id }}">{{ ucwords($location->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <h5 >@lang('modules.club.championship')</h5>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <select class="select2 form-control" data-placeholder="@lang('modules.club.championship')"  id="championshipID" name="championshipID">
                                        <option value="all">@lang('app.all')</option>
                                        @foreach($championships as $championship)
                                        <option value="{{ $championship->id }}">{{ ucwords($championship->championship_name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <h5 >@lang('modules.club.championship_type')</h5>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <select class="select2 form-control" data-placeholder="@lang('modules.club.championship_type')"  id="champ_typeID" name="champ_typeID">
                                        <option value="all">@lang('app.all')</option>
                                        <option value="national">@lang('modules.club.National')</option>
                                        <option value="international">@lang('modules.club.International')</option>
                                        <option value="regional">@lang('modules.club.Regional')</option>
                                        <option value="league">@lang('modules.club.League')</option>
                                        <option value="cup">@lang('modules.club.Cup')</option>
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


<script>
    calender();
    var getEventDetail = function (id, start, end) {
        var url = '{{ route('club.championships.show', ':id')}}?start='+start+'&end='+end;
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


    var url = '{{route('club.championships.get-filter')}}';
    var employee = '';
    var client = '';
    var category = '';
    var event_type = '';
    var sport ='';
    var champ = '';
    var champ_type ='all';
    var sport_type = 'all';
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




    function calender(sport,champ,champ_type,location_id,sport_type){

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
            url: '{{ route("club.championships.get-filter") }}',
            extraParams: function() { // a function that returns an object
                return {
                    sport: sport,
                    champ: champ,
                    champ_type: champ_type,
                    sport_type: sport_type,
                    location_id: location_id
                };
            }

        }

    });
    $('#reset-filters').click(function () {
        $('.select2').val('all');
        $('.select2').trigger('change')
        sport = $('#sportID').val();
        champ = $('#championshipID').val();
        champ_type = $('#champ_typeID').val();
        location_id = $('#locationID').val();
        sport_type = $('#sport_typeID').val();
        calendar.refetchEvents();
    });
    $('#apply-filters').click(function () {
        sport = $('#sportID').val();
        champ = $('#championshipID').val();
        champ_type = $('#champ_typeID').val();
        sport_type = $('#sport_typeID').val();
        location_id = $('#locationID').val();

        calendar.refetchEvents();
        url = url+'?sport=' + sport + '&champ=' + champ + '&champ_type=' + champ_type + '&sport_type=' + sport_type + '&location_id=' + location_id;
    });
    document.addEventListener('DOMContentLoaded', function() {
        calendar.render();
    });

</script>


@endpush
