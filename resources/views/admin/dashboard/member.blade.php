@extends('layouts.app')

@push('head-script')
    <style>
        .list-group{
            margin-bottom:0px !important;
        }
    </style>
@endpush
{{-- @section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 bg-title-left">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> @lang($pageTitle)</h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->

        <div class="col-lg-9 col-sm-4 col-md-4 col-xs-12 bg-title-right">
            <div class="col-lg-12 col-md-12 pull-right hidden-xs hidden-sm">
                {!! Form::open(['id'=>'createProject','class'=>'ajax-form','method'=>'POST']) !!}
                {!! Form::hidden('dashboard_type', 'admin-member-dashboard') !!}
                <div class="btn-group dropdown keep-open pull-right m-l-10">
{{--                    <button aria-expanded="true" data-toggle="dropdown"--}}
{{--                            class="btn bg-white b-all dropdown-toggle waves-effect waves-light"--}}
{{--                            type="button"><i class="icon-settings"></i>--}}
{{--                    </button>-- }}
                    <ul role="menu" class="dropdown-menu  dropdown-menu-right dashboard-settings">
                        <li class="b-b"><h4>@lang('modules.dashboard.dashboardWidgets')</h4></li>

                        @foreach ($widgets as $widget)
                            @php
                                $wname = \Illuminate\Support\Str::camel($widget->widget_name);
                            @endphp
                            <li>
                                <div class="checkbox checkbox-info ">
                                    <input id="{{ $widget->widget_name }}" name="{{ $widget->widget_name }}" value="true"
                                           @if ($widget->status)
                                           checked
                                           @endif
                                           type="checkbox">
                                    <label for="{{ $widget->widget_name }}">@lang('modules.dashboard.' . $wname)</label>
                                </div>
                            </li>
                        @endforeach

                        <li>
                            <button type="button" id="save-form" class="btn btn-success btn-sm btn-block">@lang('app.save')</button>
                        </li>

                    </ul>
                </div>
                {!! Form::close() !!}

                <select class="selectpicker language-switcher  pull-right" data-width="fit">
                    @if($global->timezone == "Europe/London")
                        <option value="en" @if($global->locale == "en") selected @endif data-content='<span class="flag-icon flag-icon-gb"></span>'>En</option>
                    @else
                        <option value="en" @if($global->locale == "en") selected @endif data-content='<span class="flag-icon flag-icon-us"></span>'>En</option>
                    @endif
                    @foreach($languageSettings as $language)
                        <option value="{{ $language->language_code }}" @if($global->locale == $language->language_code) selected @endif  data-content='<span class="flag-icon flag-icon-{{ $language->language_code == 'ar' ? 'eg' :  $language->language_code }}" title="{{ ucfirst($language->language_name) }}"></span>'>{{ $language->language_code }}</option>
                    @endforeach
                </select>
            </div>
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}">@lang('app.menu.home')</a></li>
                <li class="active">@lang($pageTitle)</li>
            </ol>

        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection --}}


@section('page-title')
    {{-- rola  --}}
    {{--  removed the header name "Dashboard and time and launages into an indvidual file" --}} 
    @include('admin.dashboard-header.dashboard_header');
@endsection

@push('head-script')
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/calendar/dist/fullcalendar.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">

    <link rel="stylesheet" href="{{ asset('plugins/bower_components/morrisjs/morris.css') }}"><!--Owl carousel CSS -->
    <link rel="stylesheet"
          href="{{ asset('plugins/bower_components/owl.carousel/owl.carousel.min.css') }}"><!--Owl carousel CSS -->
    <link rel="stylesheet"
          href="{{ asset('plugins/bower_components/owl.carousel/owl.theme.default.css') }}"><!--Owl carousel CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/daterange-picker/daterangepicker.css') }}" />

    <style>
        .col-in {padding: 0 20px !important;}
        .fc-event {font-size: 10px !important;}
        .dashboard-settings {padding-bottom: 8px !important;}
        .customChartCss { height: 100% !important; }
        .customChartCss svg { height: 400px; }
        @media (min-width: 769px) {
            #wrapper .panel-wrapper {height: 530px;overflow-y: auto;}
        }
    </style>
@endpush

@section('content')


    <div class="white-box" id="dashboard-content"></div>

@endsection


@push('footer-script')

    <script src="{{ asset('plugins/bower_components/raphael/raphael-min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/morrisjs/morris.js') }}"></script>

    <script src="{{ asset('plugins/bower_components/waypoints/lib/jquery.waypoints.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/counterup/jquery.counterup.min.js') }}"></script>

    <!-- jQuery for carousel -->
    <script src="{{ asset('plugins/bower_components/owl.carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/owl.carousel/owl.custom.js') }}"></script>

    <!--weather icon -->

    <script src="{{ asset('plugins/bower_components/calendar/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/moment/moment.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/calendar/dist/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/calendar/dist/jquery.fullcalendar.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/calendar/dist/locale-all.js') }}"></script>
    {{-- <script src="{{ asset('js/event-calendar.js') }}"></script> --}}
    <script src="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/Chart.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/moment/moment.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/daterange-picker/daterangepicker.js') }}"></script>
    <script>
        $(function() {
            var dateformat = '{{ $global->moment_format }}';

            var startDate = '{{ \Carbon\Carbon::parse($fromDate)->timezone($global->timezone)->format($global->date_format) }}';
            var start = moment(startDate, dateformat);

            var endDate = '{{ \Carbon\Carbon::parse($toDate)->timezone($global->timezone)->format($global->date_format) }}';
            var end = moment(endDate, dateformat);

            function cb(start, end) {
                $('#start-date').val(start.format(dateformat));
                $('#end-date').val(end.format(dateformat));
                $('#reportrange span').html(start.format(dateformat) + ' - ' + end.format(dateformat));
            }
            moment.locale('{{ $global->locale }}');
            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,

                locale: {
                    language: '{{ $global->locale }}',
                    format: '{{ $global->moment_format }}',
                },
                linkedCalendars: false,
                ranges: dateRangePickerCustom
            }, cb);

            cb(start, end);

        });
        $(document).ready(function () {
            loadData();
        })
        $('.keep-open .dropdown-menu').on({
            "click":function(e){
                e.stopPropagation();
            }
        });

        $('#save-form').click(function () {
            $.easyAjax({
                url: '{{route('admin.dashboard.widget', "admin-member-dashboard")}}',
                container: '#createProject',
                type: "POST",
                redirect: true,
                data: $('#createProject').serialize(),
                success: function(){
                    window.location.reload();
                }
            })
        });

        $('#apply-filters').click(function() {
            loadData();
        })
        function loadData () {

            var startDate = $('#start-date').val();
            if (startDate == '') { startDate = null; }
            var endDate = $('#end-date').val();
            if (endDate == '') { endDate = null; }
            var url = '{{route('admin.memberDashboard')}}';

            $.easyAjax({
                url: url,
                container: '#dashboard-content',
                type: "GET",
                success: function (response) {
                    $('#dashboard-content').html(response.view);
                }
            })

        }
    </script>

@endpush
