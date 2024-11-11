<style>
    .slimScrollDiv{
        overflow: initial !important;
    }
</style>
<div class="navbar-default sidebar" role="navigation">
    <div class="navbar-header">
        <!-- Toggle icon for mobile view -->
        <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse"
           data-target=".navbar-collapse"><i class="ti-menu"></i></a>

        <div class="top-left-part">
            <!-- Logo -->
            <a class="logo hidden-xs text-center" href="{{ route('club.dashboard') }}">
                <span class="visible-md"><img src="{{ $global->logo_url }}" alt="home" class=" admin-logo" style="object-fit: contain;"/></span>
                <span class="visible-sm"><img src="{{ $global->logo_url }}" alt="home" class=" admin-logo" style="object-fit: contain;"/></span>
            </a>

        </div>
        <!-- /Logo -->

        <!-- This is the message dropdown -->
        <ul class="nav navbar-top-links navbar-right pull-right visible-xs">
            @if(isset($activeTimerCount))
                <li class="dropdown hidden-xs">
            <span id="timer-section">
                <div class="nav navbar-top-links navbar-right pull-right m-t-10">
                    <a class="btn btn-rounded btn-default timer-modal" href="javascript:;">@lang("modules.projects.activeTimers")
                        <span class="label label-danger" id="activeCurrentTimerCount">@if($activeTimerCount > 0) {{ $activeTimerCount }} @else 0 @endif</span>
                    </a>
                </div>
            </span>
                </li>
            @endif


            <li class="dropdown">
                <select class="selectpicker language-switcher" data-width="fit">
                    @if($global->timezone == "Europe/London")
                        <option value="en" @if($global->locale == "en") selected @endif data-content='<span class="flag-icon flag-icon-gb"></span>'>En</option>
                    @else
                        <option value="en" @if($global->locale == "en") selected @endif data-content='<span class="flag-icon flag-icon-us"></span>'>En</option>
                    @endif
                    @foreach($languageSettings as $language)
                        <option value="{{ $language->language_code }}" @if($global->locale == $language->language_code) selected @endif  data-content='<span class="flag-icon flag-icon-{{ $language->language_code == 'ar' ? 'eg' :  $language->language_code }}"></span> {{ $language->language_code }}'>{{ $language->language_code }}</option>
                    @endforeach
                </select>
            </li>

            <!-- .Task dropdown -->
            <li class="dropdown" id="top-notification-dropdown">
                <a class="dropdown-toggle waves-effect waves-light show-user-notifications" data-toggle="dropdown" href="#">
                    <i class="icon-bell"></i>
                    @if($unreadNotificationCount > 0)
                        <div class="notify"><span class="heartbit"></span><span class="point"></span></div>
                    @endif
                </a>
                <ul class="dropdown-menu  dropdown-menu-right mailbox animated slideInDown">
                    <li>
                        <a href="javascript:;">...</a>
                    </li>

                </ul>
            </li>
            <!-- /.Task dropdown -->


            <li class="dropdown">
                <a href="{{ route('logout') }}" title="Logout" onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();"
                ><i class="fa fa-power-off"></i>
                </a>
            </li>



        </ul>

    </div>
    <!-- /.navbar-header -->

    <div class="top-left-part">
        <a class="logo hidden-xs hidden-sm text-center" href="{{ route('club.dashboard') }}">
            <img src="{{ $global->logo_url }}" alt="home" class=" admin-logo" style="border-radius: 5px; margin-left: auto; margin-right: auto; display: block;""/>
        </a>
    </div>
    <div class="sidebar-nav navbar-collapse slimscrollsidebar">

        <!-- .User Profile -->
        <ul class="nav" id="side-menu">
            <li class="sidebar-search hidden-sm hidden-md hidden-lg">
                <!-- input-group -->
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Search..."> <span class="input-group-btn">
                            <button class="btn btn-default" type="button"> <i class="fa fa-search"></i> </button>
                            </span> </div>
                <!-- /input-group -->
            </li>

            <li class="user-pro hidden-sm hidden-md hidden-lg">
                @if(is_null($user->image))
                    <a href="#" class="waves-effect"><img src="{{ asset('img/default-profile-3.png') }}" alt="user-img" class="img-circle"> <span class="hide-menu">{{ (strlen($user->name) > 24) ? substr(ucwords($user->name), 0, 20).'..' : ucwords($user->name) }}
                    <span class="fa arrow"></span></span>
                    </a>
                @else
                    <a href="#" class="waves-effect"><img src="{{ asset_url('avatar/'.$user->image) }}" alt="user-img" class="img-circle"> <span class="hide-menu">{{ ucwords($user->name) }}
                            <span class="fa arrow"></span></span>
                    </a>
                @endif
                <ul class="nav nav-second-level">

                    <li role="separator" class="divider"></li>
                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();"
                        ><i class="fa fa-power-off"></i> @lang('app.logout')</a>

                    </li>
                </ul>
            </li>

            <li><a href="{{ route('club.dashboard') }}" class="waves-effect"><i class="icon-speedometer fa-fw"></i> <span class="hide-menu"> @lang('app.menu.dashboard')  </span></a>
            </li>
{{--            @if(in_array('members',$modules))--}}
{{--                <li><a href="{{ route('club.club.familyMembers') }}" class="waves-effect "><i class="icon-people fa-fw"></i><span class="hide-menu">@lang('app.menu.familyMembers') </span></a>--}}

{{--            @endif--}}
            @if(in_array('members',$modules))
                <li><a href="{{ route('club.club.familyMembers') }}" class="waves-effect "><i class="icon-people fa-fw"></i><span class="hide-menu">@lang('app.menu.family')<span class="fa arrow"></span> </span></a>
                    <ul class="nav nav-second-level ">
                        <li><a href="{{ route('club.club.familyMembers') }}">@lang('app.menu.familyMembers')</a></li>
                        @php      $member=App\memberDetails::where('user_id' , auth()->user()->id)->first();
                            $family=App\memberDetails::where('player' , 1)->where('family_id' , $member->family_id)->get();
                            $i=0;
                            foreach ($family as $familyMember){
                                if ($familyMember->player==1){
                                    $i++;
                                }
                            }
                        @endphp
                        @if($i != 0)
                        <li><a href="{{ route('club.club.familyAttendanceByPlayer') }}">@lang('app.menu.attendance')</a></li>
                        @endif
                    </ul>
                </li>
            @endif
            @if(in_array('members',$modules))
                <li><a href="{{ route('club.club.index') }}" class="waves-effect "><i class="icon-people fa-fw"></i><span class="hide-menu">@lang('app.menu.sport_academies')<span class="fa arrow"></span> </span></a>
                    <ul class="nav nav-second-level ">
                        <li><a href="{{ route('club.club.index') }}">@lang('app.menu.sessions_calender')</a></li>
                        <li><a href="{{ route('club.club.mySessions') }}">@lang('app.menu.my_sessions')</a></li>
                        <li><a href="{{ route('club.club.familySessions') }}">@lang('app.menu.family_sessions')</a></li>
                    </ul>
                </li>
            @endif
            @if(in_array('members',$modules))
                <li><a href="{{ route('admin.sportsTeams.index') }}" class="waves-effect "><i class="icon-people fa-fw"></i><span class="hide-menu">@lang('app.menu.sports_teams')<span class="fa arrow"></span> </span></a>
                    <ul class="nav nav-second-level ">
                        <li><a href="{{ route('club.team.index') }}">@lang('app.menu.teams_list')</a></li>
                        <li><a href="{{ route('club.location.index') }}">@lang('modules.members.locations')</a></li>
                        <li><a href="{{ route('club.sport.index') }}">@lang('app.menu.sports_list')</a></li>
                            @php      $member=App\memberDetails::where('user_id' , auth()->user()->id)->first();
                            $family=App\memberDetails::where('player' , 1)->where('family_id' , $member->family_id)->get();
                            $i=0;
                            foreach ($family as $familyMember){
                                if ($familyMember->player==1){
                                    $i++;
                                }
                            }
                            @endphp
                            @if($i != 0)
                        <li><a href="{{ route('club.training.index') }}">@lang('app.menu.teams_calender')</a></li>
                            @endif
                    </ul>
                </li>
            @endif
            @if(in_array('members',$modules))
                @php      $member=App\memberDetails::where('user_id' , auth()->user()->id)->first();
                            $family=App\memberDetails::where('player' , 1)->where('family_id' , $member->family_id)->get();
                            $i=0;
                            foreach ($family as $familyMember){
                                if ($familyMember->player==1){
                                    $i++;
                                }
                            }
                @endphp
                @if($i != 0)
                <li><a href="{{ route('club.championships.index') }}" class="waves-effect "><i class="icon-calender fa-fw"></i><span class="hide-menu">@lang('app.menu.championships_calender')</span></a>
                    @endif
                </li>
            @endif
            @if(in_array('members',$modules))
                <li><a href="{{ route('club.trips.index') }}" class="waves-effect "><i class="icon-calender fa-fw"></i><span class="hide-menu">@lang('app.menu.trips')<span class="fa arrow"></span> </span></a>
                    <ul class="nav nav-second-level ">
                        <li><a href="{{ route('club.trips.index') }}">@lang('app.menu.trips_calender')</a></li>
                        <li><a href="{{ route('club.trips.mySessions') }}">@lang('app.menu.my_trips')</a></li>
                        <li><a href="{{ route('club.trips.familySessions') }}">@lang('app.menu.family_trips')</a></li>
                    </ul>
                </li>
            @endif
                <li><a href="{{ route('club.notice.index') }}" class="waves-effect"><i class="ti-layout-media-overlay"></i> <span class="hide-menu">@lang('app.menu.noticeBoard') </span> </a> </li>

                @if(in_array('invoices',$modules))
                    <li><a href="{{ route('club.invoices.index') }}" class="waves-effect"><i class="ti-receipt fa-fw"></i> <span class="hide-menu">@lang('app.menu.invoices') </span> @if($unreadInvoiceCount > 0) <div class="notify notification-color"><span class="heartbit"></span><span class="point"></span></div>@endif</a> </li>

                @endif
                @if(in_array('payments',$modules))
                    <li><a href="{{ route('club.payments.index') }}" class="waves-effect"><i class="fa fa-money fa-fw"></i> <span class="hide-menu">@lang('app.menu.payments') </span> @if($unreadPaymentCount > 0) <div class="notify notification-color"><span class="heartbit"></span><span class="point"></span></div>@endif</a> </li>
                @endif


            @foreach ($worksuitePlugins as $item)
                @if(in_array(strtolower($item), $modules) || in_array($item, $modules))
                    @if(View::exists(strtolower($item).'::sections.left_sidebar'))
                        @include(strtolower($item).'::sections.left_sidebar')
                    @endif
                @endif
            @endforeach


            {{--            <li><a href="" class="waves-effect"><i class="ti-settings fa-fw"></i> <span class="hide-menu"> @lang('app.menu.settings') <span class="fa arrow"></span> </span></a>--}}
            {{--                    <ul class="nav nav-second-level collapse">--}}
            {{--                        <li><a href="{{ route('admin.settings.index') }}" class="waves-effect"><i class="ti-settings fa-fw"></i> <span class="hide-menu"> @lang('app.menu.settings')</span></a>--}}
            {{--                        </li>--}}
            {{--                        --}}{{-- <li><a href="#" class="waves-effect" id="rtl"><i class="ti-settings fa-fw"></i> <span class="hide-menu"> RTL</span></a></li> --}}

            {{--                    </ul>--}}
            {{--                </li>--}}

        </ul>



    </div>

    <div class="menu-footer">
        <div class="menu-user row">
            <div class="col-lg-4 m-b-5">
                <div class="btn-group dropup user-dropdown">

                    <img aria-expanded="false" data-toggle="dropdown" src="{{ $user->image_url }}" alt="user-img" class="img-circle dropdown-toggle h-30 w-30">
                    <ul role="menu" class="dropdown-menu">
                        <li><a class="bg-inverse"><strong class="text-info">{{ ucwords($user->name) }}</strong></a></li>
                        <li><a href="{{ route('club.profile.index') }}"><i class="ti-user"></i> @lang("app.menu.profileSettings")</a></li>


                        <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                                document.getElementById('logout-form').submit();"
                            ><i class="fa fa-power-off"></i> @lang('app.logout')</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>

                    </ul>
                </div>
            </div>



            <div class="col-lg-4 text-right m-b-5">
                <div class="btn-group dropup notification-dropdown">
                    <a class="dropdown-toggle show-user-notifications" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell"></i>
                        @if($unreadNotificationCount > 0)

                            <div class="notify"><span class="heartbit"></span><span class="point"></span></div>
                        @endif
                    </a>
                    <ul class="dropdown-menu mailbox ">
                        <li>
                            <a href="javascript:;">...</a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>

        <div class="menu-copy-right">
            <a href="javascript:void(0)" class="open-close hidden-xs waves-effect waves-light"><i class="ti-angle-double-right ti-angle-double-left"></i> <span class="collapse-sidebar-text">@lang('app.collapseSidebar')</span></a>
        </div>

    </div>


</div>

<style>
    .slimScrollDiv{
        overflow: initial !important;
    }
    /* .nav>li>a:focus{
        background-color: #041731
    } */
</style>
