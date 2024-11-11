<link rel="stylesheet" href="{{ asset('plugins/bower_components/morrisjs/morris.css') }}">
<div class="row">
    <div class="col-md-6 col-sm-6">
        <div class="row dashboard-stats front-dashboard">
            <div class="col-md-6 col-sm-6">
                <a href="{{route('admin.members.dashboardIndex','affiliate_member')}}">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-xs-3">
                                <div><span class="bg-info-gradient"><i class="icon-people"></i></span></div>
                            </div>
                            <div class="col-xs-9 text-right">
                                <span class="widget-title"> @lang('app.affiliate_member')</span><br>
                                <i class="icon-user"></i>
                                <span class="counter">{{ $totalAffiliateMemberMaleMembers }}</span>
                                &emsp;
                                <i class="icon-user-female"></i>
                                <span class="counter">{{ $totalAffiliateMemberFemaleMembers }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-sm-6">
                <a href="{{route('admin.members.dashboardIndex','working_member')}}">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-xs-3">
                                <div><span class="bg-success-gradient"><i class="icon-people"></i></span></div>
                            </div>
                            <div class="col-xs-9 text-right">
                                <span class="widget-title"> @lang('app.working_member')</span><br>
                                <i class="icon-user"></i>
                                <span class="counter">{{ $totalWorkingMemberMaleMembers }}</span>
                                &emsp;
                                <i class="icon-user-female"></i>
                                <span class="counter">{{ $totalWorkingMemberFemaleMembers }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row dashboard-stats front-dashboard">
            <div class="col-md-6 col-sm-6">
                <a href="{{route('admin.members.dashboardIndex','founding_member')}}">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-xs-3">
                                <div><span class="bg-success-gradient"><i class="icon-anchor"></i></span></div>
                            </div>
                            <div class="col-xs-9 text-right">
                                <span class="widget-title"> @lang('app.founding_member')</span><br>
                                <i class="icon-user"></i>
                                <span class="counter">{{ $totalFoundingMemberMaleMembers }}</span>
                                &emsp;
                                <i class="icon-user-female"></i>
                                <span class="counter">{{ $totalFoundingMemberFemaleMembers }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-sm-6">
                <a href="{{route('admin.members.dashboardIndex','seasonal_member')}}">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-xs-3">
                                <div><span class="bg-success-gradient"><i class="icon-people"></i></span></div>
                            </div>
                            <div class="col-xs-9 text-right">
                                <span class="widget-title"> @lang('app.seasonal_member')</span><br>
                                <span class="counter">{{ $totalSeasonalMembers }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row dashboard-stats front-dashboard">
            <div class="col-md-6 col-sm-6">
                <a href="{{route('admin.members.dashboardIndex','honorary_member')}}">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-xs-3">
                                <div><span class="bg-warning-gradient"><i class="icon-badge"></i></span></div>
                            </div>
                            <div class="col-xs-9 text-right">
                                <span class="widget-title"> @lang('app.honorary_member')</span><br>
                                <span class="counter">{{ $totalHonoraryMembers }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-sm-6">
                <a href="{{route('admin.members.dashboardIndex','athletic_member')}}">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-xs-3">
                                <div><span class="bg-success-gradient"><i class="icon-people"></i></span></div>
                            </div>
                            <div class="col-xs-9 text-right">
                                <span class="widget-title"> @lang('app.athletic_member')</span><br>
                                <span class="counter">{{ $totalAthleticMembers }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row dashboard-stats front-dashboard">
            <div class="col-md-6">
                <a href="{{route('admin.members.dashboardIndex','sonsOver25')}}">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-xs-3">
                                <div><span class="bg-warning-gradient"><i class="icon-drop"></i></span></div>
                            </div>
                            <div class="col-xs-9 text-right">
                                <span class="widget-title"> @lang('app.affiliate_member_removed_from_membership_25_years_old')</span><br>
                                <span class="counter">{{ $totalSonsOver25Members }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row dashboard-stats front-dashboard">
            <div class="col-md-6 col-sm-6">
                <a href="{{route('admin.members.dashboardIndex','total_active_members')}}">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-xs-3">
                                <div><span class="bg-info-gradient"><i class="icon-people"></i></span></div>
                            </div>
                            <div class="col-xs-9 text-right">
                                <span class="widget-title"> @lang('app.total_active_members')</span><br>
                                <span class="counter">{{ $totalActiveMemberMembers }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-sm-6">
                <a href="{{route('admin.members.dashboardIndex','total_affiliate_members_dropped')}}">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-xs-3">
                                <div><span class="bg-danger-gradient"><i class="icon-drop"></i></span></div>
                            </div>
                            <div class="col-xs-9 text-right">
                                <span class="widget-title"> @lang('app.total_affiliate_members_dropped')</span><br>
                                <span class="counter">{{ $totalDroppedAffiliatedMembers }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row dashboard-stats front-dashboard">
            <div class="col-md-6 col-sm-6">
                <a href="{{route('admin.members.dashboardIndex','total_employed_members_dropped')}}">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-xs-3">
                                <div><span class="bg-danger-gradient"><i class="icon-drop"></i></span></div>
                            </div>
                            <div class="col-xs-9 text-right">
                                <span class="widget-title"> @lang('app.total_employed_members_dropped')</span><br>
                                <span class="counter">{{ $totalDroppedMainMembers }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-sm-6">
                <a href="{{route('admin.members.dashboardIndex','total_deceased_members')}}">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-xs-3">
                                <div><span class="bg-danger-gradient"><i class="icon-user-unfollow"></i></span></div>
                            </div>
                            <div class="col-xs-9 text-right">
                                <span class="widget-title"> @lang('app.total_deceased_members')</span><br>
                                <span class="counter">{{ $totalDeadMembers }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row dashboard-stats front-dashboard">
            <div class="col-md-6 col-sm-6">
                <a href="{{route('admin.members.dashboardIndex','total_unpaid_members')}}">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-xs-3">
                                <div><span class="bg-inverse-gradient"><i class="icon-people"></i></span></div>
                            </div>
                            <div class="col-xs-9 text-right">
                                <span class="widget-title"> @lang('app.total_unpaid_members')</span><br>
                                <span class="counter">{{ $totalUnpaidMembers }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-sm-6">
                <a href="{{route('admin.members.dashboardIndex','total_paid_members')}}">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-xs-3">
                                <div><span class="bg-success-gradient"><i class="icon-people"></i></span></div>
                            </div>
                            <div class="col-xs-9 text-right">
                                <span class="widget-title"> @lang('app.total_paid_members')</span><br>
                                <span class="counter">{{ $totalPaidMembers }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

    </div>
    <div class="col-md-6 col-sm-6">
        <div class="panel panel-inverse">
            <div class="panel-heading">@lang('app.excluded_categories')
                <a href="javascript:;" data-chart-id="excluded_categories" class="text-dark pull-right download-chart">
                    <i class="fa fa-download"></i> @lang('app.download')
                </a>
            </div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12">
                            @if(!empty(json_decode($chartData)))
                                <div>
                                    <canvas id="excluded_categories"></canvas>
                                </div>
                            @else
                                <div class="text-center">
                                    <div class="empty-space" style="height: 100px;">
                                        <div class="empty-space-inner">
                                            <div class="icon" style="font-size:30px"><i class="icon-user"></i></div>
                                            <div class="title m-b-15">@lang('app.no_excluded_categories_record_found')</div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: -105px">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="row" style="text-align: center;font-size: small">
                    <div class="col-md-1" style="background: #9fcdff;color: #14321b"><a href="{{route('admin.members.dashboardIndex','police')}}">@lang('app.police')</a><label for=""></label></div>
                    <div class="col-md-1" style="background: #0fe7c6;color: #290d2d"><a href="{{route('admin.members.dashboardIndex','judges')}}">@lang('app.judges')</a><label for=""></label></div>
                    <div class="col-md-1" style="background: #afc3d9;color: #f30000"><a href="{{route('admin.members.dashboardIndex','journalists')}}">@lang('app.journalists')</a><label for=""></label></div>
                    <div class="col-md-2" style="background: #541d4d;color: #f8c90a"><a href="{{route('admin.members.dashboardIndex','warrior_forces')}}">@lang('app.warrior_forces')</a><label for=""></label></div>
                    <div class="col-md-2" style="background: #B995A9;color: #2f0440"><a href="{{route('admin.members.dashboardIndex','sports_affairs')}}">@lang('app.sports_affairs')</a><label for=""></label></div>
                    <div class="col-md-2" style="background: #73cf0a;color: #ffffff"><a href="{{route('admin.members.dashboardIndex','armed_forces')}}">@lang('app.armed_forces')</a><label for=""></label></div>
                    <div class="col-md-2" style="background: #6ec481;color: #070741"><a href="{{route('admin.members.dashboardIndex','people_with_needs')}}">@lang('app.people_with_needs')</a><label for=""></label></div>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>

    </div>
</div>




<script src="{{ asset('js/Chart.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/raphael/raphael-min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/morrisjs/morris.js') }}"></script>
<script src="{{ asset('plugins/bower_components/waypoints/lib/jquery.waypoints.js') }}"></script>
<script src="{{ asset('plugins/bower_components/counterup/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/calendar/jquery-ui.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/moment/moment.js') }}"></script>
<script src="{{ asset('plugins/bower_components/calendar/dist/fullcalendar.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/calendar/dist/jquery.fullcalendar.js') }}"></script>
<script src="{{ asset('plugins/bower_components/calendar/dist/locale-all.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/Chart.min.js') }}"></script>
<script>
    $(document).ready(function () {
        @if(!empty(json_decode($chartData)))
        function excludedCat(chartData) {
            var ctx2 = document.getElementById("excluded_categories");
            var data = new Array();
            var color = new Array();
            var labels = new Array();
            var total = 0;
            $.each(chartData, function(key,val){
                labels.push(val.name);
                data.push(parseInt(val.count));
                total = total+parseInt(val.count);
                color.push(getRandomColor());
            });
            var chart = new Chart(ctx2,{
                "type":"doughnut",
                "data":{
                    "labels":labels,
                    "datasets":[{
                        "data":data,
                        "backgroundColor":color
                    }]
                }
            });
            chart.canvas.parentNode.style.height = '300px';
        }
        excludedCat(jQuery.parseJSON('{!! $chartData !!}'));
        @endif
        function getRandomColor() {
            var letters = '0123456789ABCDEF'.split('');
            var color = '#';
            for (var i = 0; i < 6; i++ ) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }
        $('.download-chart').click(function() {
            var id = $(this).data('chart-id');
            this.href = $('#'+id)[0].toDataURL();// Change here
            this.download = id+'.png';
        });
    });
</script>
