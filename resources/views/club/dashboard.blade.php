@extends('layouts.club_member-app')

@push('head-script')
    <style>
        .fc-event{
            font-size: 10px !important;
        }
        #calendar .fc-view-container .fc-view .fc-more-popover{
            top: 136px !important;
            left: 105px !important;
        }
        @keyframes fa-blink {
            0% { opacity: 1; }
            25% { opacity: 0.25; }
            50% { opacity: 0.5; }
            75% { opacity: 0.75; }
            100% { opacity: 0; }
        }
        .fa-blink {
            -webkit-animation: fa-blink 1.75s linear infinite;
            -moz-animation: fa-blink 1.75s linear infinite;
            -ms-animation: fa-blink 1.75s linear infinite;
            -o-animation: fa-blink 1.75s linear infinite;
            animation: fa-blink 1.75s linear infinite;
        }
        .dashboard-clock {
            font-size: 26px;
            font-weight: 300;
        }
    </style>
@endpush
@section('page-title')


    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 bg-title-left">
            <h4 class="page-title m-l-20"><i class="{{ $pageIcon }}"></i> {{ __($pageTitle) }}</h4>



        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->

        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12 bg-title-right">

            @if(session('impersonate'))
                <a class="btn b-all waves-effect waves-light pull-right" data-toggle="tooltip"
                   data-original-title="{{__('messages.stopImpersonation')}}" data-placement="left" href="{{route('admin.impersonate.stop')}}" >
                    <i class="fa fa-stop fa-blink text-danger"></i>

                </a>
            @endif

            <div class="col-md-4 pull-right hidden-xs hidden-sm  m-r-10">

                @if($global->dashboard_clock)
                    <span id="clock" class="dashboard-clock text-muted m-r-30"></span>
                @endif


                    <select class="selectpicker language-switcher  pull-right" data-width="fit">
                        @if($global->timezone == "Europe/London")
                            <option value="en" @if($global->locale == "en") selected @endif data-content='<span class="flag-icon flag-icon-gb"></span>'>En</option>
                        @else
                            <option value="en" @if($global->locale == "en") selected @endif data-content='<span class="flag-icon flag-icon-us"></span>'>En</option>
                        @endif
                        @foreach($languageSettings as $language)
                            <option value="{{ $language->language_code }}"
                                    @if($user->locale == $language->language_code) selected
                                    @endif  data-content='<span class="flag-icon @if($language->language_code == 'zh-CN') flag-icon-cn @elseif($language->language_code == 'zh-TW') flag-icon-tw @else flag-icon-{{ $language->language_code == 'ar' ? 'eg' :  $language->language_code }} @endif"></span>'>{{ $language->language_code }}</option>
                        @endforeach
                    </select>


                <!-- .breadcrumb -->
                <ol class="breadcrumb">
                    <li class="active">{{ __($pageTitle) }}</li>
                </ol>
                <!-- /.breadcrumb -->

            </div>
        </div>
        @endsection

        @push('head-script')
            <link rel="stylesheet" href="{{ asset('plugins/bower_components/calendar/dist/fullcalendar.css') }}">
            <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
            <link rel="stylesheet" href="{{ asset('plugins/bower_components/morrisjs/morris.css') }}"><!--Owl carousel CSS -->
            <link rel="stylesheet" href="{{ asset('plugins/bower_components/owl.carousel/owl.carousel.min.css') }}"><!--Owl carousel CSS -->
            <link rel="stylesheet" href="{{ asset('plugins/bower_components/owl.carousel/owl.theme.default.css') }}"><!--Owl carousel CSS -->

            <style>
                .col-in {
                    padding: 0 20px !important;

                }

                .fc-event {
                    font-size: 10px !important;
                }

                .dashboard-settings {
                    padding-bottom: 8px !important;
                }
                .front-dashboard .white-box{
                    margin-bottom: 8px;
                }
                @media (min-width: 769px) {
                    #wrapper .panel-wrapper {
                        height: 530px;
                        overflow-y: auto;
                    }
                }

            </style>
        @endpush

        @section('content')

            <div class="white-box">
                @if(session('impersonate'))
                    <div class="col-md-12">
                        <div class="alert alert-danger">
                            {{__('messages.impersonate')}} {{$company->company_name}}
                        </div>
                    </div>
                @endif



                <div class="row dashboard-stats front-dashboard">






                    @if(in_array('invoices',$modules) )
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('club.invoices.index') }}">
                                <div class="white-box">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <div>
                                                <span class="bg-inverse-gradient"><i class="ti-receipt"></i></span>
                                            </div>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <span class="widget-title"> @lang('modules.dashboard.totalUnpaidInvoices')</span><br>
                                            <span class="counter">{{ $counts->totalUnpaidInvoices }}</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                    @if(in_array('members',$modules))
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('club.location.index') }}">
                                <div class="white-box">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <div>
                                                <span class="bg-warning-gradient"><i class="ti-alert"></i></span>
                                            </div>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <span class="widget-title"> @lang('modules.members.locations')</span><br>
                                            <span class="counter">{{ $counts->locations }}</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif


                    @if(in_array('members',$modules) )
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('club.sport.index') }}">
                                <div class="white-box">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <div>
                                                <span class="bg-danger-gradient"><i class="fa fa-percent" style="display: inherit;"></i></span>
                                            </div>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <span class="widget-title"> @lang('app.menu.sports')</span><br>
                                            <span class="counter">{{ $counts->sports }}</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif

                    @if(in_array('members',$modules) )
                        <div class="col-md-3 col-sm-6 front-dashboard dashboard-stats">
                            <a href="{{ route('club.team.index') }}">
                                <div class="white-box">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <div>
                                                <span class="bg-success-gradient"><i class="ti-ticket"></i></span>
                                            </div>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <span class="widget-title"> @lang('app.menu.sports_teams')</span><br>
                                            <span class="counter">{{ floor($counts->teams) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif


                </div>
                <!-- .row -->



                <div class="row">
                    @if(in_array('members',$modules))
                        <div class="col-md-12">
                            <div class="panel panel-inverse">
                                <div class="panel-heading">@lang('app.menu.trips')</div>
                                <div class="panel-wrapper collapse in" style="overflow: auto">
                                    <div class="panel-body">
                                        <div id="calendar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif


                </div>


            </div>

            {{--Ajax Modal--}}
            <div class="modal fade bs-modal-md in" id="eventDetailModal" role="dialog" aria-labelledby="myModalLabel"
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
            <div class="modal fade bs-modal-md in"  id="subTaskModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md" id="modal-data-application">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <span class="caption-subject font-red-sunglo bold uppercase" id="subTaskModelHeading">Sub Task e</span>
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
                <!-- /.modal-dialog -->.
            </div>
            {{--Ajax Modal Ends--}}

        @endsection


        @push('footer-script')
            <script>


                var taskEvents = [
                        @foreach($leaves as $leave)
                    {
                            id : '{{ ucfirst($leave->id) }}',
                    title : '{{ ucfirst($leave->trip_name) }}',
                    className : 'bg-{{ $leave->label_color }}',
                    start : '{{ $leave->start_date_time }}',
                    end : '{{ $leave->end_date_time }}',
                    },
                    @endforeach
                ];


                var getEventDetail = function (id) {
                    var url = '{{ route('club.trips.show', ':id')}}';
                    url = url.replace(':id', id);

                    $('#modelHeading').html('Event');
                    $.ajaxModal('#eventDetailModal', url);
                }

                var calendarLocale = '{{ $global->locale }}';
                var firstDay = '{{ $global->week_start }}';

            </script>


            <script src="{{ asset('plugins/bower_components/raphael/raphael-min.js') }}"></script>
            <script src="{{ asset('plugins/bower_components/morrisjs/morris.js') }}"></script>

            <script src="{{ asset('plugins/bower_components/waypoints/lib/jquery.waypoints.js') }}"></script>
            <script src="{{ asset('plugins/bower_components/counterup/jquery.counterup.min.js') }}"></script>

            <!-- jQuery for carousel -->
            <script src="{{ asset('plugins/bower_components/owl.carousel/owl.carousel.min.js') }}"></script>
            <script src="{{ asset('plugins/bower_components/owl.carousel/owl.custom.js') }}"></script>

            <!--weather icon -->
            <script src="{{ asset('plugins/bower_components/skycons/skycons.js') }}"></script>

            <script src="{{ asset('plugins/bower_components/moment/moment.js') }}"></script>
            <script src="{{ asset('plugins/bower_components/calendar/dist/fullcalendar.min.js') }}"></script>
            <script src="{{ asset('plugins/bower_components/calendar/dist/jquery.fullcalendar.js') }}"></script>
            <script src="{{ asset('plugins/bower_components/calendar/dist/locale-all.js') }}"></script>
            <script src="{{ asset('js/event-calendar.js') }}"></script>
            <script src="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
            <script src="{{ asset('js/moment-timezone.js') }}"></script>
            <script>


                $('.keep-open .dropdown-menu').on({
                    "click":function(e){
                        e.stopPropagation();
                    }
                });
                $('[data-toggle="tooltip"]').tooltip();

                function hidePopUp () {
                    $.easyAjax({
                        url: '{{route('admin.dashboard.stripe-pop-up-close')}}',
                        type: "GET",
                    })
                }
                /** clock timer start here */
                function currentTime() {
                    let date = new Date();
                    date = moment.tz(date, "{{ $global->timezone }}");

                    // console.log(moment.tz(date, "America/New_York"));

                    let hour = date.hour();
                    let min = date.minutes();
                    let sec = date.seconds();
                    let midday = "AM";
                    midday = (hour >= 12) ? "PM" : "AM";
                    @if($global->time_format == 'h:i A')
                        hour = (hour == 0) ? 12 : ((hour > 12) ? (hour - 12): hour); /* assigning hour in 12-hour format */
                    @endif
                        hour = updateTime(hour);
                    min = updateTime(min);
                    document.getElementById("clock").innerText = `${hour} : ${min} ${midday}`
                    const time = setTimeout(function(){ currentTime() }, 1000);
                }

                function updateTime(timer) {
                    if (timer < 10) {
                        return "0" + timer;
                    }
                    else {
                        return timer;
                    }
                }

                currentTime();
            </script>
    @endpush

