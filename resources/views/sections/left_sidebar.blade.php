<style>
    .slimScrollDiv {
        overflow: initial !important;
    }

    .leftNavName {
        color: white !important;
        font-weight: 600 !important;
        letter-spacing: 0.01rem !important;
        font-size: 1.5rem !important;
    } 

    .leftNavSubName {
        color: white !important;
        /* font-weight: 600 !important; */
        letter-spacing: 0.01rem !important;
        font-size: 1.4rem !important;
    }
     .leftNavSubName:active,  .leftNavSubName:hover {
        color: rgb(159, 131, 131) !important;
        /* font-weight: 600 !important; */ 
        letter-spacing: 0.01rem !important;
        font-size: 1.4rem !important;
    }
</style>
<div class="navbar-default sidebar" role="navigation">
    <div class="navbar-header">
        <!-- Toggle icon for mobile view -->
        <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse"
            data-target=".navbar-collapse"><i class="ti-menu"></i></a>

        <div class="top-left-part">
            <!-- Logo -->
            <a class="logo hidden-xs text-center " href="{{ route('admin.dashboard') }}">
                <span class="visible-lg"><img src="{{ $global->logo_url }}" alt="home" class=" admin-logo"
                        style="border-radius: 5px;" /></span>
                <span class="visible-sm"><img src="{{ $global->logo_url }}" alt="home" class=" admin-logo"
                        style="border-radius: 5px;" /></span>
            </a>
        </div>
        <!-- /Logo -->

        <!-- This is the message dropdown -->
        <ul class="nav navbar-top-links navbar-right pull-right visible-xs">
            @if(isset($activeTimerCount))
            <li class="dropdown hidden-xs">
                <span id="timer-section">
                    <div class="nav navbar-top-links navbar-right pull-right m-t-10">
                        <a class="btn btn-rounded btn-default timer-modal"
                            href="javascript:;">@lang("modules.projects.activeTimers")
                            <span class="label label-danger" id="activeCurrentTimerCount">@if($activeTimerCount > 0) {{
                                $activeTimerCount }} @else 0 @endif</span>
                        </a>
                    </div>
                </span>
            </li>
            @endif


            <li class="dropdown">
                <select class="selectpicker language-switcher" data-width="fit">
                    @if($global->timezone == "Europe/London")
                    <option value="en" @if($global->locale == "en") selected @endif data-content='<span
                            class="flag-icon flag-icon-gb"></span>'>En</option>
                    @else
                    <option value="en" @if($global->locale == "en") selected @endif data-content='<span
                            class="flag-icon flag-icon-us"></span>'>En</option>
                    @endif
                    @foreach($languageSettings as $language)
                    <option value="{{ $language->language_code }}" @if($global->locale == $language->language_code)
                        selected @endif data-content='<span
                            class="flag-icon flag-icon-{{ $language->language_code == 'ar' ? 'eg' :  $language->language_code }}"></span>
                        {{ $language->language_code }}'>{{ $language->language_code }}</option>
                    @endforeach
                </select>
            </li>
            {{-- <li>ROLORLORL</li> --}}

            <!-- .Task dropdown -->
            <li class="dropdown" id="top-notification-dropdown">
                <a class="dropdown-toggle waves-effect waves-light show-user-notifications" data-toggle="dropdown"
                    href="#">
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
                                                    document.getElementById('logout-form').submit();"><i
                        class="fa fa-power-off"></i>
                </a>
            </li>



        </ul>

    </div>
    <!-- /.navbar-header -->

    <div class="top-left-part">
        <a class="logo hidden-xs hidden-sm text-center leftNavName" href="{{ route('admin.dashboard') }}">
            <img src="{{ $global->logo_url }}" alt="home" class=" admin-logo"
                style="border-radius: 5px; margin-left: auto; margin-right: auto; display: block;" />
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
                    </span>
                </div>
                <!-- /input-group -->
            </li>

            <li class="user-pro hidden-sm hidden-md hidden-lg">
                @if(is_null($user->image))
                <a href="#" class="waves-effect"><img src="{{ asset('img/default-profile-3.png') }}" alt="user-img"
                        class="img-circle"> <span class="hide-menu">{{ (strlen($user->name) > 24) ?
                        substr(ucwords($user->name), 0, 20).'..' : ucwords($user->name) }}
                        <span class="fa arrow"></span></span>
                </a>
                @else
                <a href="#" class="waves-effect"><img src="{{ asset_url('avatar/'.$user->image) }}" alt="user-img"
                        class="img-circle"> <span class="hide-menu">{{ ucwords($user->name) }}
                        <span class="fa arrow"></span></span>
                </a>
                @endif
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('member.dashboard') }}">
                            <i class="fa fa-sign-in"></i> @lang('app.loginAsEmployee')
                        </a>
                    </li>
                    <li role="separator" class="divider"></li>
                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();"><i
                                class="fa fa-power-off"></i> @lang('app.logout')</a>

                    </li>
                </ul>
            </li>

            {{-- dashbord section in left navbar --}}
            <li><a href="{{ route('admin.dashboard') }}" class="waves-effect leftNavName"><i
                        class="icon-speedometer fa-fw"></i> <span class="hide-menu"> @lang('app.menu.dashboard') <span
                            class="fa arrow"></span> </span></a>
                <ul class="nav nav-second-level">
                    <li>
                        {{-- sub section in dashboard --}}
                        <a href="{{ route('admin.dashboard') }}" class="waves-effect  leftNavSubName">
                            @lang('app.menu.dashboard')
                        </a>
                    </li>
                    @if(in_array('projects',$modules))
                    <li>
                        {{-- sub section in dashboard --}}
                        <a href="{{ route('admin.projectDashboard') }}" class="waves-effect leftNavSubName">
                            @lang('app.menu.projectDashboard')
                        </a>
                    </li>
                    @endif
                    @if(in_array('clients',$modules) || in_array('leads',$modules))
                    <li>
                        {{-- sub section in dashboard --}}
                        <a href="{{ route('admin.clientDashboard') }}" class="waves-effect leftNavSubName">
                            @lang('app.menu.clientDashboard')
                        </a>
                    </li>
                    @endif
                    @if(in_array('members',$modules) || in_array('members',$modules))
                    <li>
                        {{-- sub section in dashboard --}}
                        <a href="{{ route('admin.memberDashboard') }}" class="waves-effect leftNavSubName">
                            @lang('app.menu.memberDashboard')
                        </a>
                    </li>
                    @endif
                    @if(in_array('employees', $modules) || in_array('attendance', $modules) || in_array('holidays',
                    $modules) || in_array('leaves', $modules))
                    <li>
                        {{-- sub section in dashboard --}}

                        <a href="{{ route('admin.hrDashboard') }}" class="waves-effect leftNavSubName">
                            @lang('app.menu.hrDashboard')
                        </a>
                    </li>
                    @endif
                    @if(in_array("tickets", $modules))
                    <li> {{-- sub section in dashboard --}}
                        <a href="{{ route('admin.ticketDashboard') }}" class="waves-effect leftNavSubName">
                            @lang('app.menu.ticketDashboard')
                        </a>
                    </li>
                    @endif
                    @if((in_array("estimates", $modules) || in_array("invoices", $modules) || in_array("payments",
                    $modules) || in_array("expenses", $modules) ))
                    <li>
                        {{-- sub section in dashboard --}}
                        <a href="{{ route('admin.financeDashboard') }}" class="waves-effect leftNavSubName">
                            @lang('app.menu.financeDashboard')
                        </a>
                    </li>
                    @endif
                </ul>
            </li>

            {{-- members section --}}
            @if (in_array('members', $modules))
            <li><a href="{{ route('admin.members.index') }}" class="waves-effect leftNavName"><i
                        class="icon-people fa-fw"></i><span class="hide-menu">@lang('app.menu.members')<span
                            class="fa arrow"></span> </span></a>
                {{-- members sub section --}}
                <ul class="nav nav-second-level ">
                    <li><a href="{{ route('admin.members.index') }}"
                            class="waves-effect leftNavSubName">@lang('app.menu.membersList')</a></li>
                    <li><a href="{{ route('admin.members.create')  }}"
                            class="waves-effect leftNavSubName">@lang('app.menu.create_new_member')</a></li>
                    <li><a href="{{ route('admin.members.add_to_family') }}"
                            class="waves-effect leftNavSubName">@lang('app.menu.add_to_family')</a></li>
                    <li><a href="{{ route('admin.members.family_index') }}"
                            class="waves-effect leftNavSubName">@lang('app.menu.family_list')</a></li>
                    <li><a href="{{ route('admin.members.penalties') }}"
                            class="waves-effect leftNavSubName">@lang('app.menu.penalties')</a></li>
                    <li><a href="{{ route('admin.assembly.index') }}"
                            class="waves-effect leftNavSubName">@lang('app.menu.general_assembly')</a></li>
                    <li><a href="{{ route('admin.members.invoices') }}"
                            class="waves-effect leftNavSubName">@lang('app.menu.invoices')</a></li>
                    <li><a href="{{ route('admin.members.membership-renew') }}"
                            class="waves-effect leftNavSubName">@lang('app.menu.membership_renew')</a></li>
                </ul>
            </li>
            @endif
            {{-- subtitles --}}
            @if(in_array('sportAcademies',$modules) || in_array('sportTeams',$modules) || in_array('players',$modules)
            || in_array('championships',$modules))
            <li><a href="#"
                    class="waves-effect leftNavName {{ (request()->is('admin/sportActivity*') || request()->is('admin/subscribers*') || request()->is('admin/sports*') || request()->is('admin/training*')  || request()->is('admin/attendances/players*') || request()->is('admin/assessments*')) ? 'active' : '' }}"><i
                        class="icon-trophy fa-fw"></i><span
                        class="hide-menu">@lang('app.menu.sport_activities_departement')<span class="fa arrow"></span>
                    </span></a>
                <ul
                    class="nav nav-second-level {{ (request()->is('admin/sportActivity*') || request()->is('admin/subscribers*') || request()->is('admin/sports*')  || request()->is('admin/training*') || request()->is('admin/attendances/players*') || request()->is('admin/assessments*')) ? 'in' : '' }}">
                    @if(in_array('sportAcademies',$modules) || in_array('sportTeams',$modules))
                    <li><a href="{{ route('admin.location.index') }}" class="waves-effect leftNavSubName"><i
                                class="icon-layers fa-fw"></i> <span class="hide-menu">@lang('app.menu.locations')
                            </span></a> </li>
                    @endif
                    @if(in_array('sportAcademies',$modules))
                    <li><a href="{{ route('admin.sportAcademy.index') }}" class="waves-effect leftNavSubName "><i
                                class="icon-people fa-fw"></i><span
                                class="hide-menu">@lang('app.menu.sport_academies')<span class="fa arrow"></span>
                            </span></a>
                        <ul class="nav nav-third-level ">
                            <li><a href="{{ route('admin.sportAcademy.index') }}"
                                    class="waves-effect leftNavSubName">@lang('app.menu.sports_list')</a></li>

                            <li><a href="{{ route('admin.sportActivity.create')  }}"
                                    class="waves-effect leftNavSubName">@lang('app.menu.sessions_calender')</a>
                            </li>
                            <li><a href="{{ route('admin.subscribers.index')  }}"
                                    class="waves-effect leftNavSubName">@lang('app.menu.subscribers')</a>
                            </li>

                        </ul>
                    </li>
                    @endif
                    @if(in_array('sportTeams',$modules))
                    <li><a href="{{ route('admin.sportsTeams.index') }}" class="waves-effect leftNavSubName"><i
                                class="icon-people fa-fw"></i><span
                                class="hide-menu">@lang('app.menu.sports_teams')<span class="fa arrow"></span>
                            </span></a>
                        <ul class="nav nav-third-level ">
                            <li><a href="{{ route('admin.sportsTeams.index') }}"
                                    class="waves-effect">@lang('app.menu.teams_list')</a></li>
                            <li><a href="{{ route('admin.sportsTeams.create') }}"
                                    class="waves-effect">@lang('app.menu.create_team')</a></li>
                            <li><a href="{{ route('admin.sports.index') }}"
                                    class="waves-effect">@lang('app.menu.sports_list')</a></li>
                            <li><a href="{{ route('admin.training.create') }}"
                                    class="waves-effect">@lang('app.menu.teams_calender')</a></li>
                        </ul>
                    </li>
                    @endif
                    @if(in_array('players',$modules))
                    <li><a href="{{ route('admin.players.index') }}" class="waves-effect leftNavSubName"><i
                                class="icon-pie-chart fa-fw"></i><span class="hide-menu">@lang('app.menu.players')<span
                                    class="fa arrow"></span> </span></a>
                        <ul class="nav nav-third-level ">
                            <li><a href="{{ route('admin.players.index') }}" class=" leftNavSubName">@lang('app.menu.players_list')</a></li>
                            <li><a href="{{ route('admin.players.create') }}" class=" leftNavSubName">@lang('app.menu.create_player')</a></li>
                            <li><a
                                    href="{{ route('admin.players.createFromMember')  }}" class=" leftNavSubName">@lang('app.menu.add_member_player')</a>
                            </li>
                            <li><a
                                    href="{{ route('admin.attendances.playersSummary')  }}" class=" leftNavSubName">@lang('app.menu.attendance')</a>
                            </li>
                            <li><a href="{{ route('admin.playersLeaves.all-leaves')  }}" class=" leftNavSubName">@lang('app.menu.leaves')</a>
                            </li>
                            <li><a href="{{ route('admin.assessments.index') }}" class=" leftNavSubName">@lang('app.menu.assessments_list')</a>
                            </li>
                            <li><a
                                    href="{{ route('admin.assessments.create') }}" class=" leftNavSubName">@lang('app.menu.create_assessment')</a>
                            </li>


                        </ul>
                    </li>
                    @endif
                    @if(in_array('championships',$modules))
                    <li><a href="{{ route('admin.championships.create') }}" class="waves-effect "><i
                                class="icon-trophy fa-fw"></i><span
                                class="hide-menu">@lang('app.menu.championships')</span></a>

                    </li>
                    @endif
                </ul>
                @endif
                @if(in_array('trips',$modules))
            <li><a href="{{ route('admin.players.index') }}" class="waves-effect leftNavName"><i
                        class="icon-compass fa-fw"></i><span class="hide-menu">@lang('app.menu.trips')<span
                            class="fa arrow"></span> </span></a>
                <ul class="nav nav-second-level ">
                    <li><a href="{{ route('admin.trips.create') }}" class="leftNavSubName">
                            @lang('app.menu.trips_calender')</a></li>
                    <li><a href="{{ route('admin.tripSubscribers.index') }}"
                            class="leftNavSubName">@lang('app.menu.trips_subscribers')</a></li>
                </ul>
            </li>
            @endif

            {{-- @if(in_array('members',$modules))--}}
            {{-- <li><a href="{{ route('admin.sportAcademy.index') }}" class="waves-effect "><i
                        class="icon-people fa-fw"></i><span class="hide-menu">@lang('app.menu.legal_affairs')<span
                            class="fa arrow"></span> </span></a>--}}
                {{-- <ul class="nav nav-second-level ">--}}
                    {{-- <li><a href="{{ route('admin.penalties.create') }}">@lang('app.menu.create_penalty')</a></li>
                    --}}
                    {{-- <li><a href="{{ route('admin.penalties.index') }}">@lang('app.menu.penalty_list')</a></li>--}}
                    {{-- <li><a href="{{ route('admin.cases.create')  }}">@lang('app.menu.create_case')</a></li>--}}
                    {{-- <li><a href="{{ route('admin.cases.index')  }}">@lang('app.menu.cases_list')</a></li>--}}
                    {{-- </ul>--}}
                {{-- </li>--}}
            {{-- @endif--}}

            {{-- hr department  section employyess section  --}}
            @if(in_array('employees', $modules) || in_array('attendance', $modules) || in_array('holidays', $modules) ||
            in_array('leaves', $modules))
            <li><a href="{{ route('admin.employees.index') }}" class="waves-effect leftNavName
                    {{ request()->is('admin/leave*') ? 'active' : '' }}
                            "><i class="ti-user fa-fw"></i> <span class="hide-menu"> @lang('app.menu.hr') <span
                            class="fa arrow"></span> </span></a>
                <ul class="nav nav-second-level {{ request()->is('admin/leave*') ? 'collapse in' : '' }}">
                    @if(in_array('employees',$modules))
                    <li><a href="{{ route('admin.employees.index') }}" class='leftNavSubName'>@lang('app.menu.employeeList')</a></li>
                    <li><a href="{{ route('admin.teams.index') }}" class='leftNavSubName'>@lang('app.department')</a></li>
                    <li><a href="{{ route('admin.designations.index') }}" class='leftNavSubName' >@lang('app.menu.designation')</a></li>
                    @endif
                    @if(in_array('attendance',$modules))
                    <li><a href="{{ route('admin.attendances.summary') }}" 
                            class="waves-effect leftNavSubName">@lang('app.menu.attendance')</a> </li>
                    @endif
                    @if(in_array('holidays',$modules))
                    <li><a href="{{ route('admin.holidays.index') }}" class="waves-effect leftNavSubName">@lang('app.menu.holiday')</a>
                    </li>
                    @endif
                    @if(in_array('leaves',$modules))
                    <li><a href="{{ route('admin.leave.all-leaves') }}"
                            class="waves-effect leftNavSubName  {{ request()->is('admin/leave*') ? 'active' : '' }}">@lang('app.menu.leavesAndMissions')</a>
                    </li>
                    <!--<li><a href="{{ route('admin.leave.create-mission') }}">@lang('app.menu.employees_missions')</a></li>-->
                    @endif
                    <li><a class=" leftNavSubName"
                            href="{{ route('admin.employees.assessments.index') }}">@lang('app.menu.assessments_list')</a>
                    </li>
                    <li><a  class="leftNavSubName"
                            href="{{ route('admin.employees.assessments.create') }}">@lang('app.menu.create_assessment')</a>
                    </li>

                    <li><a  class=" leftNavSubName"
                            href="{{ route('admin.employees.employees-assessment-setting') }}">@lang('app.menu.employees_assessment_setting')</a>
                    </li>

                    @foreach ($worksuitePlugins as $item)
                    @if(strtolower($item) === 'payroll')
                    @if (in_array(strtolower($item), $modules) || in_array($item, $modules))
                    @if (View::exists(strtolower($item) . '::sections.left_sidebar'))
                    @include(strtolower($item).'::sections.left_sidebar')
                    @endif
                    @endif
                    @endif
                    @endforeach
                </ul>
            </li>
            @endif
            @if(in_array('clients',$modules))
            <li>
                <a href="{{ route('admin.clients.index') }}"
                    class="waves-effect leftNavName {{ (request()->is('admin/clients*') || request()->is('admin/purchases*') ) ? '' : '' }}">
                    <i class="fa fa-cart-plus"></i>
                    <span class="hide-menu">
                        @lang('modules.purchases.purchases_dept')
                        <span class="fa arrow"></span>
                    </span>
                </a>
                <ul class=" nav nav-second-level">
                    <li><a  class="waves-effect leftNavSubName" href="{{ route('admin.clients.index') }}">
                            @lang('modules.purchases.client_vendor')</a>
                    </li>
                    @if(in_array('purchases',$modules))
                    <li><a class="waves-effect leftNavSubName"
                            href="{{ route('admin.purchases.show-requests') }}">@lang('modules.purchases.purchase_requests')</a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif

            @if (in_array('inventories', $modules))
            <li>
                <a href="{{ route('admin.stocks.index') }}"
                    class="waves-effect  leftNavName {{ (request()->is('admin/stocks*') || request()->is('admin/categories*') || request()->is('admin/item*') || request()->is('admin/transactions*')) ? 'active' : '' }}">
                    <i class="fa fa-cubes"></i>
                    <span class="hide-menu">
                        @lang('app.menu.stocks')
                        <span class="fa arrow"></span>
                    </span>
                </a>
                <ul class=" nav nav-second-level">

                    <li><a class="waves-effect {{ request()->is('admin/stocks*') ? 'active' : '' }}"
                            href="{{ route('admin.stocks.index') }}"> @lang('modules.stocks.inventories')</a>
                    </li>
                    <li><a class="waves-effect"
                            href="{{ route('admin.categories.index') }}">@lang('modules.stocks.categories')</a>
                    </li>
                    <li><a class="waves-effect {{ request()->is('admin/item*') ? 'active' : '' }}"
                            href="{{ route('admin.items.index') }}">@lang('modules.stocks.products')</a>
                    </li>
                    <li><a class="waves-effect {{ request()->is('admin/stocks/*') ? 'active' : '' }}"
                            href="{{ route('admin.stocks.show-requests') }}">@lang('modules.stocks.requests')</a>
                    </li>
                    <li><a class="waves-effect"
                            href="{{ route('admin.transactions.index') }}">@lang('modules.stocks.transactions')</a>
                    </li>
                </ul>
            </li>
            @endif
            @if (in_array('libraries', $modules))
            {{-- <li><a href="{{ route('admin.products.index') }}" class="waves-effect"><i
                        class="icon-basket fa-fw"></i> <span class="hide-menu">@lang('app.menu.products') </span></a>
            </li> --}}
            <li>
                <a href="{{ route('admin.libraries.index') }}" class="waves-effect leftNavName ">
                    <i class="fa fa-book"></i>

                    <span class="hide-menu">
                        @lang('modules.libraries.libraries')
                        <span class="fa arrow"></span>
                    </span>
                </a>
                <ul id="collapseTwo" class=" nav nav-second-level">
                    <li><a class="menu-link leftNavSubName"
                            href="{{ route('admin.libraries.index') }}">@lang('modules.libraries.resources')</a>
                    </li>
                    <li><a class="menu-link leftNavSubName"
                            href="{{ route('admin.libraries.show-requests') }}">@lang('modules.libraries.borrowings')</a>
                    </li>
                </ul>
            </li>
            @endif

            {{-- @if(in_array('archives',$modules))--}}
            {{-- <li><a href="{{ route('admin.orders.index') }}" class="waves-effect ">--}}
                    {{-- <i class="icon-list fa-fw"></i><span class="hide-menu">@lang('modules.orders.orders')--}}
                        {{-- <span class="fa arrow"></span> </span></a>--}}
                {{-- <ul class="nav nav-second-level ">--}}
                    {{-- <li><a href="{{ route('admin.orders.index') }}">@lang('modules.orders.orders')</a></li>--}}

                    {{-- </ul>--}}
                {{-- </li>--}}
            {{-- @endif--}}
            @if(in_array('legalAffairs',$modules))
            <li><a href="{{ route('admin.cases.index')  }}" class="waves-effect leftNavName "><i class="icon-lock fa-fw"></i><span
                        class="hide-menu">@lang('app.menu.legal_affairs')<span class="fa arrow"></span> </span></a>
                <ul class="nav nav-second-level ">
                    <li><a class='leftNavSubName' href="{{ route('admin.penalties.create') }}">@lang('app.menu.create_penalty')</a></li>
                    <li><a class='leftNavSubName'
                            href="{{ route('admin.penalties.create-employee-penalty') }}">@lang('modules.employees.create_employee_penalty')</a>
                    </li>
                    <li><a  class='leftNavSubName' href="{{ route('admin.penalties.index') }}">@lang('app.menu.penalty_list')</a></li>
                    <li><a class='leftNavSubName' href="{{ route('admin.cases.create')  }}">@lang('app.menu.create_case')</a></li>
                    <li><a class='leftNavSubName' href="{{ route('admin.cases.index')  }}">@lang('app.menu.cases_list')</a></li>
                </ul>
            </li>
            @endif

            {{-- //rola --}}
            @if(in_array('PublicRelationsDepartment',$modules))
            <li><a href="{{ route('admin.cases.index')  }}" class="waves-effect leftNavName "><i class="icon-lock fa-fw"></i><span
                        class="hide-menu">Public Relations Department<span class="fa arrow"></span> </span></a>
                {{-- <ul class="nav nav-second-level ">
                    <li><a class='leftNavSubName' href="{{ route('admin.penalties.create') }}">@lang('app.menu.create_penalty')</a></li>
                    <li><a class='leftNavSubName'
                            href="{{ route('admin.penalties.create-employee-penalty') }}">@lang('modules.employees.create_employee_penalty')</a>
                    </li>
                    <li><a  class='leftNavSubName' href="{{ route('admin.penalties.index') }}">@lang('app.menu.penalty_list')</a></li>
                    <li><a class='leftNavSubName' href="{{ route('admin.cases.create')  }}">@lang('app.menu.create_case')</a></li>
                    <li><a class='leftNavSubName' href="{{ route('admin.cases.index')  }}">@lang('app.menu.cases_list')</a></li>
                </ul> --}}

                <ul>
                    {{-- leads --}}
                <li>
                    <a href="{{ route('admin.leads.index') }}" class="waves-effect"><i class="icon-doc fa-fw"></i><span
                    class="hide-menu">@lang('app.menu.lead')</span></a>

                </li>


                  {{-- tickets --}}
                  <li><a href="{{ route('admin.tickets.index') }}" class="waves-effect">
                    <i class="ti-ticket fa-fw"></i><span class="hide-menu">@lang('app.menu.tickets')
                    </span>
                    @if ($unreadTicketCount > 0) <div class="notify notification-color"><span
                            class="heartbit"></span><span class="point"></span></div>@endif <span
                        class="fa arrow"></span></a>
                   <ul class="nav nav-second-level ">
                    <li><a href="{{ route('admin.orders.index') }}">@lang('modules.orders.orders')</a></li>
                    <li><a href="{{ route('admin.tickets.index') }}" class="waves-effect">
                            <span class="hide-menu">@lang('app.menu.tickets')</span>
                            @if ($unreadTicketCount > 0) <div class="notify notification-color"><span
                                    class="heartbit"></span><span class="point"></span></div>@endif</a> </li>

                   </ul>
                  </li>
                     
                   {{--events  --}}
                <li><a href="{{ route('admin.events.index') }}" class="waves-effect"><i class="icon-calender fa-fw"></i>
               <span class="hide-menu">@lang('app.menu.Events')</span></a> </li>


                {{--notices  --}}
               <li><a href="{{ route('admin.notices.index') }}" class="waves-effect"><i
                class="ti-layout-media-overlay fa-fw"></i> <span class="hide-menu">@lang('app.menu.noticeBoard')
            </span></a> </li>


            {{--messages  --}}
            <li><a href="{{ route('admin.user-chat.index') }}" class="waves-effect"><i class="icon-envelope fa-fw"></i>
                <span class="hide-menu">@lang('app.menu.messages')
                    @if ($unreadMessageCount > 0)<span class="label label-rouded label-custom pull-right">{{
                        $unreadMessageCount }}</span> @endif</span></a> </li>

             
            {{--area rents  --}}
            <li><a href="{{ route('admin.area-rents.index') }}" class="waves-effect"><i class="icon-envelope fa-fw"></i>
                <span class="hide-menu">area rents
                    @if ($unreadMessageCount > 0)<span class="label label-rouded label-custom pull-right">{{
                        $unreadMessageCount }}</span> @endif</span></a> 
            </li>


            </ul>     



            </li>
            @endif

            @if (in_array('estimates', $modules) || in_array('invoices', $modules) || in_array('payments', $modules) ||
            in_array('expenses', $modules))
            <li><a href="{{ route('admin.finance.index') }}" class="waves-effect">
                    <i class="fa fa-money fa-fw"></i>
                    <span class="hide-menu"> @lang('app.menu.finance')
                        @if ($unreadExpenseCount > 0)
                        <div class="notify notification-color">
                            <span class="heartbit"></span><span class="point"></span>
                        </div>@endif <span class="fa arrow"></span>
                    </span>
                </a>
                <ul class="nav nav-second-level">
                    @if (in_array('estimates', $modules))
                    <li><a href="{{ route('admin.estimates.index') }}">@lang('app.menu.estimates')</a> </li>
                    @endif
                    @if (in_array('invoices', $modules))
                    <li><a href="{{ route('admin.all-invoices.index') }}">@lang('app.menu.invoices')</a></li>
                    <li><a href="{{ route('admin.invoice-recurring.index') }}">@lang('app.invoiceRecurring')</a></li>
                    @endif

                    @if (in_array('payments', $modules))
                    <li><a href="{{ route('admin.payments.index') }}">@lang('app.menu.payments')</a> </li>
                    @endif

                    @if (in_array('expenses', $modules))
                    <li><a href="{{ route('admin.expenses.index') }}">@lang('app.menu.expenses')
                            @if ($unreadExpenseCount > 0) <div class="notify notification-color"><span
                                    class="heartbit"></span><span class="point"></span></div>@endif</a> </li>
                    <li> <a href="{{ route('admin.expenses-recurring.index') }}">@lang('app.menu.expensesRecurring')</a>
                    </li>
                    @endif

                    @if (in_array('invoices', $modules))
                    <li><a href="{{ route('admin.all-credit-notes.index') }}">@lang('app.menu.credit-note')</a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif

            @if (in_array('projects', $modules) || in_array('tasks', $modules) || in_array('timelogs', $modules) ||
            in_array('contracts', $modules))
            <li><a href="{{ route('admin.task.index') }}" class="waves-effect"><i class="icon-layers fa-fw"></i> <span
                        class="hide-menu"> @lang('app.menu.work') <span class="fa arrow"></span> </span></a>
                <ul class="nav nav-second-level">
                    @if (in_array('contracts', $modules))
                    <li><a href="{{ route('admin.contracts.index') }}"
                            class="waves-effect">@lang('app.menu.contracts')</a></li>
                    @endif
                    @if (in_array('products', $modules))
                    <li><a href="{{ route('admin.products.index') }}" class="waves-effect">@lang('app.menu.assets')</a>
                    </li>
                    @endif
                    @if (in_array('projects', $modules))
                    <li><a href="{{ route('admin.projects.index') }}" class="waves-effect">@lang('app.menu.projects')
                        </a> </li>
                    @endif
                    @if (in_array('tasks', $modules))
                    <li><a href="{{ route('admin.all-tasks.index') }}">@lang('app.menu.tasks')</a></li>
                    <li class=""><a href="{{ route('admin.taskboard.index') }}">@lang('modules.tasks.taskBoard')</a>
                    </li>
                    <li><a href="{{ route('admin.task-calendar.index') }}">@lang('app.menu.taskCalendar')</a>
                    </li>
                    @endif
                    @if (in_array('timelogs', $modules))
                    <li><a href="{{ route('admin.all-time-logs.index') }}"
                            class="waves-effect">@lang('app.menu.timeLogs')</a>
                    </li>
                    @endif
                </ul>
                @endif

                {{-- @if (in_array('products', $modules))--}}
                {{-- --}}{{--
            <li><a href="{{ route('admin.products.index') }}" class="waves-effect"><i class="icon-basket fa-fw"></i>
                    <span class="hide-menu">@lang('app.menu.products') </span></a> </li> --}}
            {{-- <li>--}}
                {{-- <a data-toggle="collapse" data-target="#collapseTwo" aria-controls="collapseTwo">--}}
                    {{-- <i class="fa fa-book" aria-hidden="true"></i>--}}

                    {{-- <span class="hide-menu">--}}
                        {{-- Libraries--}}
                        {{-- <span class="fa arrow"></span>--}}
                        {{-- </span>--}}
                    {{-- </a>--}}
                {{-- <ul id="collapseTwo" class=" nav nav-second-level collapse toggled" aria-labelledby="headingOne">
                    --}}
                    {{-- <li><a class="menu-link" href="{{ route('admin.libraries.index') }}">Resources</a>--}}
                        {{-- </li>--}}
                    {{-- <li><a class="menu-link" href="{{ route('admin.libraries.show-requests') }}">Borrowings</a>--}}
                        {{-- </li>--}}
                    {{-- </ul>--}}
                {{-- </li>--}}
            {{-- @endif--}}



{{-- ----rola commented 'leads'---- --}}



            {{-- @if(in_array('leads',$modules))
            <li><a href="{{ route('admin.leads.index') }}" class="waves-effect"><i class="icon-doc fa-fw"></i><span
                        class="hide-menu">@lang('app.menu.lead')</span></a>
            </li>
            @endif --}}

            {{-- ----rola commented 'tickets'---- --}}
            {{-- @if(in_array('tickets',$modules))
            <li><a href="{{ route('admin.tickets.index') }}" class="waves-effect">
                    <i class="ti-ticket fa-fw"></i><span class="hide-menu">@lang('app.menu.tickets')
                    </span>
                    @if ($unreadTicketCount > 0) <div class="notify notification-color"><span
                            class="heartbit"></span><span class="point"></span></div>@endif <span
                        class="fa arrow"></span></a>
                <ul class="nav nav-second-level ">
                    <li><a href="{{ route('admin.orders.index') }}">@lang('modules.orders.orders')</a></li>
                    <li><a href="{{ route('admin.tickets.index') }}" class="waves-effect">
                            <span class="hide-menu">@lang('app.menu.tickets')</span>
                            @if ($unreadTicketCount > 0) <div class="notify notification-color"><span
                                    class="heartbit"></span><span class="point"></span></div>@endif</a> </li>

                </ul>
            </li>
            @endif --}}


            {{-- @if (in_array('messages', $modules))
            <li><a href="{{ route('admin.user-chat.index') }}" class="waves-effect"><i class="icon-envelope fa-fw"></i>
                    <span class="hide-menu">@lang('app.menu.messages')
                        @if ($unreadMessageCount > 0)<span class="label label-rouded label-custom pull-right">{{
                            $unreadMessageCount }}</span> @endif</span></a> </li>
            @endif --}}

            @if (in_array('events', $modules))
            <li><a href="{{ route('admin.events.index') }}" class="waves-effect"><i class="icon-calender fa-fw"></i>
                    <span class="hide-menu">@lang('app.menu.Events')</span></a> </li>
            @endif

            {{-- -NOTICES- --}}
            {{-- @if(in_array("notices", $modules))
            <li><a href="{{ route('admin.notices.index') }}" class="waves-effect"><i
                        class="ti-layout-media-overlay fa-fw"></i> <span class="hide-menu">@lang('app.menu.noticeBoard')
                    </span></a> </li>
            @endif --}}

            @if(in_array("reports", $modules))
            <li><a href="{{ route('admin.reports.index') }}" class="waves-effect"><i class="ti-pie-chart fa-fw"></i>
                    <span class="hide-menu"> @lang('app.menu.reports') <span class="fa arrow"></span> </span></a>
                <ul class="nav nav-second-level">
                    @if(in_array('tasks',$modules))
                    <li><a href="{{ route('admin.task-report.index') }}">@lang('app.menu.taskReport')</a></li>
                    @endif

                    @if(in_array('timelogs',$modules))
                    <li><a href="{{ route('admin.time-log-report.index') }}">@lang('app.menu.timeLogReport')</a></li>
                    @endif

                    @if((in_array("estimates", $modules) || in_array("invoices", $modules) || in_array("payments",
                    $modules) || in_array("expenses", $modules) ))
                    <li><a href="{{ route('admin.finance-report.index') }}">@lang('app.menu.financeReport')</a></li>
                    <li><a
                            href="{{ route('admin.income-expense-report.index') }}">@lang('app.menu.incomeVsExpenseReport')</a>
                    </li>
                    @endif

                    @if(in_array('leaves',$modules))
                    <li><a href="{{ route('admin.leave-report.index') }}">@lang('app.menu.leaveReport')</a></li>
                    @endif

                    @if(in_array('attendance',$modules))
                    <li><a href="{{ route('admin.attendance-report.index') }}">@lang('app.menu.attendanceReport')</a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif

            {{-- @role('admin')--}}
            {{-- <li><a href="{{ route('admin.billing') }}" class="waves-effect"><i class="icon-book-open fa-fw"></i>
                    <span class="hide-menu"> @lang('app.menu.billing')</span></a>--}}
                {{-- </li>--}}
            {{-- @endrole--}}

            @foreach ($worksuitePlugins as $item)
            @if(strtolower($item) != 'payroll')
            @if (in_array(strtolower($item), $modules) || in_array($item, $modules))
            @if (View::exists(strtolower($item) . '::sections.left_sidebar'))
            @include(strtolower($item).'::sections.left_sidebar')
            @endif
            @endif
            @endif
            @endforeach
            <li><a href="{{ route('admin.employee-faq.index') }}" class="waves-effect
                    {{ request()->is('admin/employee-faq*') ? 'active' : '' }}"><i class="icon-docs fa-fw"></i> <span
                        class="hide-menu"> @lang('app.faq') <span class="fa arrow"></span> </span></a>
                <ul class="nav nav-second-level {{ request()->is('admin/employee-faq*') ? 'collapse in' : '' }}">
                    <li><a href="{{ route('admin.faqs.index') }}" class="waves-effect"><i class="icon-docs fa-fw"></i>
                            <span class="hide-menu">
                                @lang('app.myFaq')</span></a></li>
                    <li><a href="{{ route('admin.employee-faq.index') }}" class="waves-effect"><i
                                class="icon-docs fa-fw"></i> <span class="hide-menu">
                                @lang('app.menu.employeeFaq')</span></a></li>

                </ul>
            </li>
            <li><a href="{{ route('admin.settings.index') }}" class="waves-effect"><i class="ti-settings fa-fw"></i>
                    <span class="hide-menu">
                        @lang('app.menu.settings')</span></a>
            </li>

            {{-- <li><a href="" class="waves-effect"><i class="ti-settings fa-fw"></i> <span class="hide-menu">
                        @lang('app.menu.settings') <span class="fa arrow"></span> </span></a>--}}
                {{-- <ul class="nav nav-second-level collapse">--}}
                    {{-- <li><a href="{{ route('admin.settings.index') }}" class="waves-effect"><i
                                class="ti-settings fa-fw"></i> <span class="hide-menu">
                                @lang('app.menu.settings')</span></a>--}}
                        {{-- </li>--}}
                    {{-- --}}{{-- <li><a href="#" class="waves-effect" id="rtl"><i class="ti-settings fa-fw"></i> <span
                                class="hide-menu"> RTL</span></a></li> --}}

                    {{-- </ul>--}}
                {{-- </li>--}}

        </ul>



    </div>

    <div class="menu-footer">
        <div class="menu-user row">
            <div class="col-lg-4 m-b-5">
                <div class="btn-group dropup user-dropdown">

                    <img aria-expanded="false" data-toggle="dropdown" src="{{ $user->image_url }}" alt="user-img"
                        class="img-circle dropdown-toggle h-30 w-30">
                    <ul role="menu" class="dropdown-menu">
                        <li><a class="bg-inverse"><strong class="text-info">{{ ucwords($user->name) }}</strong></a></li>
                        <li>
                            <a href="{{ route('member.dashboard') }}">
                                <i class="fa fa-sign-in"></i> @lang('app.loginAsEmployee')
                            </a>
                        </li>
                        @if($isClient)
                        <li>
                            <a href="{{ route('client.dashboard.index') }}">
                                <i class="fa fa-sign-in"></i> @lang('app.loginAsClient')
                            </a>
                        </li>
                        @endif
                        @if(in_array('ticket support',$modules))
                        <li>
                            <a href="{{ route('admin.support-tickets.index') }}">
                                <i class="fa fa-ticket"></i> @lang('app.supportTicket')
                            </a>
                        </li>
                        @endif
                        <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                                document.getElementById('logout-form').submit();"><i
                                    class="fa fa-power-off"></i> @lang('app.logout')</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-4 text-center  m-b-5">
                <div class="btn-group dropup shortcut-dropdown">
                    <a class="dropdown-toggle waves-effect waves-light text-uppercase" data-toggle="dropdown" href="#">
                        <i class="fa fa-plus"></i>
                    </a>
                    <ul class="dropdown-menu">

                        @if (in_array('projects', $modules))
                        <li>
                            <div class="message-center">
                                <a href="{{ route('admin.projects.create') }}">
                                    <div class="mail-contnet">
                                        <span class="mail-desc m-0">@lang('app.add') @lang('app.project')</span>
                                    </div>
                                </a>
                            </div>
                        </li>
                        @endif

                        @if(in_array('tasks',$modules))
                        <li>
                            <div class="message-center">
                                <a href="{{ route('admin.all-tasks.create') }}">
                                    <div class="mail-contnet">
                                        <span class="mail-desc m-0">@lang('app.add') @lang('app.task')</span>
                                    </div>
                                </a>
                            </div>
                        </li>
                        @endif

                        @if(in_array('clients',$modules))
                        <li>
                            <div class="message-center">
                                <a href="{{ route('admin.clients.create') }}">
                                    <div class="mail-contnet">
                                        <span class="mail-desc m-0">@lang('app.add') @lang('app.client')</span>
                                    </div>
                                </a>
                            </div>
                        </li>
                        @endif

                        @if(in_array('employees',$modules))
                        <li>
                            <div class="message-center">
                                <a href="{{ route('admin.employees.create') }}">
                                    <div class="mail-contnet">
                                        <span class="mail-desc m-0">@lang('app.add') @lang('app.employee')</span>
                                    </div>
                                </a>
                            </div>
                        </li>
                        @endif

                        @if(in_array('payments',$modules))
                        <li>
                            <div class="message-center">
                                <a href="{{ route('admin.payments.create') }}">
                                    <div class="mail-contnet">
                                        <span class="mail-desc m-0">@lang('modules.payments.addPayment')</span>
                                    </div>
                                </a>
                            </div>
                        </li>
                        @endif

                        @if(in_array('tickets',$modules))
                        <li>
                            <div class="message-center">
                                <a href="{{ route('admin.tickets.create') }}">
                                    <div class="mail-contnet">
                                        <span class="mail-desc m-0">@lang('app.add')
                                            @lang('modules.tickets.ticket')</span>
                                    </div>
                                </a>
                            </div>
                        </li>
                        @endif

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
            <a href="javascript:void(0)" class="open-close hidden-xs waves-effect waves-light"><i
                    class="ti-angle-double-right ti-angle-double-left"></i> <span
                    class="collapse-sidebar-text">@lang('app.collapseSidebar')</span></a>
        </div>

    </div>


</div>

<style>
    .slimScrollDiv {
        overflow: initial !important;
    }

    /* .nav>li>a:focus{
    background-color: #041731
} */
</style>