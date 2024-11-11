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
            <a class="logo hidden-xs text-center" href="{{ route('member.dashboard') }}">
                <span class="visible-md"><img src="{{ $global->logo_url }}" alt="home" class=" admin-logo"/></span>
                <span class="visible-sm"><img src="{{ $global->logo_url }}" alt="home" class=" admin-logo"/></span>
            </a>

        </div>
        <!-- /Logo -->

        <!-- This is the message dropdown -->
        <ul class="nav navbar-top-links navbar-right pull-right visible-xs">



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
        <a class="logo hidden-xs hidden-sm text-center" href="{{ route('member.dashboard') }}">
            <img src="{{ $global->logo_url }}" alt="home" class=" admin-logo" style="border-radius: 5px; margin-left: auto; margin-right: auto; display: block;"/>
        </a>
    </div>
    <div class="sidebar-nav navbar-collapse slimscrollsidebar ">
        <!-- .User Profile -->
        <ul class="nav" id="side-menu">
            {{--<li class="sidebar-search hidden-sm hidden-md hidden-lg">--}}
                {{--<!-- / Search input-group this is only view in mobile-->--}}
                {{--<div class="input-group custom-search-form">--}}
                    {{--<input type="text" class="form-control" placeholder="Search...">--}}
                        {{--<span class="input-group-btn">--}}
                        {{--<button class="btn btn-default" type="button"> <i class="fa fa-search"></i> </button>--}}
                        {{--</span>--}}
                {{--</div>--}}
                {{--<!-- /input-group -->--}}
            {{--</li>--}}

            <li class="user-pro  hidden-sm hidden-md hidden-lg">
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
                    <li><a href="{{ route('member.profile.index') }}"><i class="ti-user"></i> @lang("app.menu.profileSettings")</a></li>
                    @if($user->hasRole('admin'))
                        <li>
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="fa fa-sign-in"></i>  @lang("app.loginAsAdmin")
                            </a>
                        </li>
                    @endif
                        <li role="separator" class="divider"></li>
                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                        ><i class="fa fa-power-off"></i> @lang('app.logout')</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </li>
            @if(
                    $user->cans('view_members') ||
                    $user->cans('view_sportAcademies') ||
                    $user->cans('view_sportTeams') ||
                    $user->cans('view_players') ||
                    $user->cans('view_trips') ||
                    $user->cans('view_projects') ||
                    $user->cans('view_employees') ||
                    $user->cans('view_clients') ||
                    $user->cans('view_estimates') ||
                    $user->cans('view_invoices') ||
                    $user->cans('view_payments') ||
                    $user->cans('view_expenses') ||
                    $user->cans('view_tickets')
                    )

            <li><a href="{{ route('admin.dashboard') }}" class="waves-effect"><i class="icon-speedometer fa-fw"></i> <span class="hide-menu"> @lang('app.menu.dashboard') <span class="fa arrow"></span> </span></a>
                <ul class="nav nav-second-level">
                    @if(in_array('projects',$modules) && $user->cans('view_projects'))
                        <li>
                            <a href="{{ route('admin.projectDashboard') }}" class="waves-effect">
                                @lang('app.menu.projectDashboard')
                            </a>
                        </li>
                    @endif
                    @if(in_array('clients',$modules) && $user->cans('view_clients'))
                        <li>
                            <a href="{{ route('admin.clientDashboard') }}" class="waves-effect">
                                @lang('app.menu.clientDashboard')
                            </a>
                        </li>
                    @endif
                    @if(in_array('members',$modules)&&( $user->cans('view_members') ||$user->cans('view_sportAcademies') || $user->cans('view_sportTeams') || $user->cans('view_players')))
                        <li>
                            <a href="{{ route('admin.memberDashboard') }}" class="waves-effect">
                                @lang('app.menu.memberDashboard')
                            </a>
                        </li>
                    @endif
                    @if(in_array('employees', $modules) &&(
                                $user->cans('view_employees')
                            )
                        )
                        <li>
                            <a href="{{ route('admin.hrDashboard') }}" class="waves-effect">
                                @lang('app.menu.hrDashboard')
                            </a>
                        </li>
                    @endif
                    @if(in_array("tickets", $modules) &&($user->cans('view_tickets')))
                        <li>
                            <a href="{{ route('admin.ticketDashboard') }}" class="waves-effect">
                                @lang('app.menu.ticketDashboard')
                            </a>
                        </li>
                    @endif
                    @if((in_array("estimates", $modules)  || in_array("invoices", $modules)  || in_array("payments", $modules) || in_array("expenses", $modules) )&&( $user->cans('view_estimates') ||
                    $user->cans('view_invoices') ||
                    $user->cans('view_payments') ||
                    $user->cans('view_expenses')))
                        <li>
                            <a href="{{ route('admin.financeDashboard') }}" class="waves-effect">
                                @lang('app.menu.financeDashboard')
                            </a>
                        </li>
                    @endif
                </ul>
            </li>

            @endif
            @if (in_array('members', $modules) && ($user->cans('view_members') || $user->cans('add_members')) )
            <li><a href="{{ route('admin.members.index') }}" class="waves-effect "><i
                                class="icon-people fa-fw"></i><span class="hide-menu">@lang('app.menu.members')<span
                                    class="fa arrow"></span> </span></a>
                    <ul class="nav nav-second-level ">
                        @if($user->cans('view_members'))
                        <li><a href="{{ route('admin.members.index') }}">@lang('app.menu.membersList')</a></li>
                        @endif
                        @if($user->cans('add_members'))
                        <li><a href="{{ route('admin.members.create')  }}">@lang('app.menu.create_new_member')</a></li>
                        @endif
                        @if($user->cans('add_members'))
                        <li><a href="{{ route('admin.members.add_to_family') }}">@lang('app.menu.add_to_family')</a></li>
                        @endif
                        @if($user->cans('view_members'))
                        <li><a href="{{ route('admin.members.family_index') }}">@lang('app.menu.family_list')</a></li>
                        @endif
                        @if($user->cans('edit_members'))
                        <li><a href="{{ route('admin.members.penalties') }}">@lang('app.menu.penalties')</a></li>
                        @endif
                        @if($user->cans('edit_members'))
                        <li><a href="{{ route('admin.assembly.index') }}">@lang('app.menu.general_assembly')</a></li>
                        @endif
                        @if($user->cans('edit_members'))
                        <li><a href="{{ route('admin.members.invoices') }}">@lang('app.menu.invoices')</a></li>
                        @endif
                        <li><a href="{{ route('admin.members.membership-renew') }}">@lang('app.menu.membership_renew')</a></li>

                    </ul>
                </li>
            @endif
            @if(
                (
                        in_array('sportAcademies',$modules) ||
                        in_array('sportTeams',$modules) ||
                        in_array('players',$modules) ||
                        in_array('championships',$modules))&&
                    (
                        $user->cans('view_sportAcademies') ||
                        $user->cans('view_sportTeams') ||
                        $user->cans('view_players') ||
                        $user->cans('view_championships')||
                        $user->cans('add_sportAcademies') ||
                        $user->cans('add_sportTeams') ||
                        $user->cans('add_players') ||
                        $user->cans('add_championships')||
                        $user->cans('edit_sportAcademies') ||
                        $user->cans('edit_sportTeams') ||
                        $user->cans('edit_players') ||
                        $user->cans('edit_championships')||
                        $user->cans('delete_sportAcademies') ||
                        $user->cans('delete_sportTeams') ||
                        $user->cans('delete_players') ||
                        $user->cans('delete_championships')
                    )
                )
                <li><a href="#" class="waves-effect "><i class="icon-trophy fa-fw"></i><span class="hide-menu">@lang('app.menu.sport_activities_departement')<span class="fa arrow"></span> </span></a>
                    <ul class="nav nav-second-level ">
                        @if((in_array('sportAcademies',$modules) || in_array('sportTeams',$modules)) && ($user->cans('view_sportTeams')))
                                <li><a href="{{ route('admin.location.index') }}" class="waves-effect"><i class="icon-layers fa-fw"></i> <span class="hide-menu">@lang('app.menu.locations') </span></a> </li>
                        @endif
                        @if(in_array('sportAcademies',$modules) && ($user->cans('view_sportAcademies')||$user->cans('add_sportAcademies')) )
                            <li><a href="{{ route('admin.sportAcademy.index') }}" class="waves-effect "><i class="icon-people fa-fw"></i><span class="hide-menu">@lang('app.menu.sport_academies')<span class="fa arrow"></span> </span></a>
                                <ul class="nav nav-third-level ">
                                    @if($user->cans('view_sportAcademies'))
                                    <li><a href="{{ route('admin.sportAcademy.index') }}">@lang('app.menu.sports_list')</a></li>
                                    @endif
                                        @if($user->cans('add_sportAcademies'))
                                    <li><a href="{{ route('admin.sportActivity.create')  }}">@lang('app.menu.sessions_calender')</a>
                                    </li>
                                        @endif
                                        @if($user->cans('add_sportAcademies'))
                                    <li><a href="{{ route('admin.subscribers.index')  }}">@lang('app.menu.subscribers')</a>
                                    </li>
                                        @endif

                                </ul>
                            </li>
                        @endif

                        @if(in_array('sportTeams',$modules) && ($user->cans('view_sportTeams') || $user->cans('add_sportTeams')))
                            <li><a href="{{ route('admin.sportsTeams.index') }}" class="waves-effect "><i class="icon-people fa-fw"></i><span class="hide-menu">@lang('app.menu.sports_teams')<span class="fa arrow"></span> </span></a>
                                <ul class="nav nav-third-level ">
                                    @if($user->cans('view_sportTeams'))
                                    <li><a href="{{ route('admin.sportsTeams.index') }}">@lang('app.menu.teams_list')</a></li>
                                    @endif
                                        @if($user->cans('add_sportTeams'))
                                    <li><a href="{{ route('admin.sportsTeams.create') }}">@lang('app.menu.create_team')</a></li>
                                        @endif
                                        @if($user->cans('view_sportTeams'))
                                    <li><a href="{{ route('admin.sports.index') }}">@lang('app.menu.sports_list')</a></li>
                                        @endif
                                        @if($user->cans('add_sportTeams'))
                                    <li><a href="{{ route('admin.training.create') }}">@lang('app.menu.teams_calender')</a></li>
                                        @endif
                                </ul>
                            </li>
                        @endif
                        @if(in_array('players',$modules) && ($user->cans('view_players') || $user->cans('add_players')))
                            <li><a href="{{ route('admin.players.index') }}" class="waves-effect "><i class="icon-pie-chart fa-fw"></i><span class="hide-menu">@lang('app.menu.players')<span class="fa arrow"></span> </span></a>
                                <ul class="nav nav-third-level ">
                                    @if($user->cans('view_players'))
                                    <li><a href="{{ route('admin.players.index') }}">@lang('app.menu.players_list')</a></li>
                                    @endif
                                        @if($user->cans('add_players'))
                                        <li><a href="{{ route('admin.players.create') }}">@lang('app.menu.create_player')</a></li>
                                        @endif
                                        @if($user->cans('add_players'))
                                        <li><a href="{{ route('admin.players.createFromMember')  }}">@lang('app.menu.add_member_player')</a></li>
                                        @endif
                                        @if($user->cans('view_players'))
                                        <li><a href="{{ route('admin.attendances.playersSummary')  }}">@lang('app.menu.attendance')</a></li>
                                        @endif
                                        @if($user->cans('view_players'))
                                        <li><a href="{{ route('admin.playersLeaves.all-leaves')  }}">@lang('app.menu.leaves')</a></li>
                                        @endif
                                        @if($user->cans('view_players'))
                                        <li><a href="{{ route('admin.assessments.index') }}">@lang('app.menu.assessments_list')</a></li>
                                        @endif
                                        @if($user->cans('add_players'))
                                        <li><a href="{{ route('admin.assessments.create') }}">@lang('app.menu.create_assessment')</a></li>
                                        @endif
                                </ul>
                            </li>
                        @endif
                        @if(in_array('championships',$modules))
                                @if($user->cans('view_championships'))
                            <li><a href="{{ route('admin.championships.create') }}" class="waves-effect "><i class="icon-trophy fa-fw"></i><span class="hide-menu">@lang('app.menu.championships')</span></a>
                                @endif
                            </li>
                        @endif
                    </ul>
            @endif
            @if(in_array('trips',$modules) && $user->cans('view_trips'))
                <li><a href="{{ route('admin.players.index') }}" class="waves-effect "><i class="icon-compass fa-fw"></i><span class="hide-menu">@lang('app.menu.trips')<span class="fa arrow"></span> </span></a>
                    <ul class="nav nav-second-level ">
                        <li><a href="{{ route('admin.trips.create') }}">@lang('app.menu.trips_calender')</a></li>
                        <li><a href="{{ route('admin.tripSubscribers.index') }}">@lang('app.menu.trips_subscribers')</a></li>
                    </ul>
                </li>
            @endif

            @if(
                    in_array('employees',$modules) &&(
                        $user->cans('view_employees') ||
                        $user->cans('edit_employees') ||
                        $user->cans('add_employees') ||
                        $user->cans('delete_employees')

                    )

                )

                @if(in_array('employees', $modules) || in_array('attendance', $modules) || in_array('holidays', $modules) || in_array('leaves', $modules))
                    <li><a href="{{ route('admin.employees.index') }}" class="waves-effect
                    {{ request()->is('admin/leave*') ? 'active' : '' }}
                                "><i class="ti-user fa-fw"></i> <span class="hide-menu"> @lang('app.menu.hr') <span class="fa arrow"></span> </span></a>
                        <ul class="nav nav-second-level {{ request()->is('admin/leave*') ? 'collapse in' : '' }}">
                            @if(in_array('employees',$modules))
                                <li><a href="{{ route('admin.employees.index') }}">@lang('app.menu.employeeList')</a></li>
                                <li><a href="{{ route('admin.teams.index') }}">@lang('app.department')</a></li>
                                <li><a href="{{ route('admin.designations.index') }}">@lang('app.menu.designation')</a></li>
                            @endif
                            @if(in_array('attendance',$modules))
                                <li><a href="{{ route('admin.attendances.summary') }}" class="waves-effect">@lang('app.menu.attendance')</a> </li>
                            @endif
                            @if(in_array('holidays',$modules))
                                <li><a href="{{ route('admin.holidays.index') }}" class="waves-effect">@lang('app.menu.holiday')</a>
                                </li>
                            @endif
                            @if(in_array('leaves',$modules))
                                <li><a href="{{ route('admin.leave.all-leaves') }}" class="waves-effect  {{ request()->is('admin/leave*') ? 'active' : '' }}">@lang('app.menu.leaves')</a> </li>
                            @endif
                            <li><a href="{{ route('admin.employees.assessments.index') }}">@lang('app.menu.assessments_list')</a></li>
                            <li><a href="{{ route('admin.employees.assessments.create') }}">@lang('app.menu.create_assessment')</a></li>

                            <li><a href="{{ route('admin.employees.employees-assessment-setting') }}">@lang('app.menu.employees_assessment_setting')</a></li>


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

{{--            @if($user->cans('view_employees'))--}}
{{--                <li><a href="{{ route('member.employees.index') }}" class="waves-effect"><i class="icon-user fa-fw"></i> <span class="hide-menu">@lang('app.menu.employees') </span></a> </li>--}}
{{--            @endif--}}
                @if((in_array('clients',$modules) || in_array('purchases',$modules)) && ($user->cans('view_clients')||$user->cans('view_purchases')))
                    <li>
                        <a href="{{ route('member.clients.index') }}" data-toggle="collapse" data-target="#collapsePurchase" aria-controls="collapsePurchase"
                           class="waves-effect">
                            <i class="fa fa-cart-plus" aria-hidden="true"></i>
                            <span class="hide-menu">
                            @lang('modules.purchases.purchases_dept')
                            <span class="fa arrow"></span>
                        </span>
                        </a>
                        <ul id="collapsePurchase" class=" nav nav-second-level collapse toggled" aria-labelledby="headingOne">
                            @if($user->cans('view_clients'))
                            <li><a class="menu-link" href="{{ route('member.clients.index') }}"> @lang('modules.purchases.client_vendor')</a>
                            </li>
                            @endif
                        </ul>
                    </li>
                @endif
                    <li><a class="menu-link" href="{{ route('admin.purchases.show-requests') }}"class="waves-effect"><i class="icon-paper-clip fa-fw"></i> <span class="hide-menu">@lang('modules.purchases.purchase_requests')</a> </li>
                @if (
                        (
                            in_array('inventories', $modules)
                        )&&(
                            $user->cans('view_inventories') ||
                            $user->cans('add_inventories') ||
                            $user->cans('edit_inventories') ||
                            $user->cans('delete_inventories')
                        )
                    )
                    <li>
                        <a data-toggle="collapse" href="{{ route('admin.stocks.index') }}" data-target="#collapseOne" aria-controls="collapseOne"
                           class="waves-effect">
                            <i class="fa fa-cubes" aria-hidden="true"></i>
                            <span class="hide-menu">
                            @lang('app.menu.stocks')
                            <span class="fa arrow"></span>
                        </span>
                        </a>
                        <ul id="collapseOne" class=" nav nav-second-level collapse toggled" aria-labelledby="headingOne">
                                @if($user->cans('view_inventories'))
                                <li><a class="menu-link" href="{{ route('admin.stocks.index') }}">  @lang('modules.stocks.inventories')</a>
                                </li>
                                    <li><a class="menu-link" href="{{ route('admin.categories.index') }}">@lang('modules.stocks.categories')</a>
                                    </li>
                                    <li><a class="menu-link" href="{{ route('admin.items.index') }}">@lang('modules.stocks.products')</a>
                                    </li>
                                    <li><a class="menu-link" href="{{ route('admin.stocks.show-requests') }}">@lang('modules.stocks.requests')</a>
                                    </li>
                                    <li><a class="menu-link"
                                   href="{{ route('admin.transactions.index') }}">@lang('modules.stocks.transactions')</a>
                                    </li>
                                @endif
                        </ul>
                    </li>
                @endif
                @if (
                        (
                            in_array('libraries', $modules)
                        )&&(
                            $user->cans('view_libraries') ||
                            $user->cans('add_libraries') ||
                            $user->cans('edit_libraries') ||
                            $user->cans('delete_libraries')
                        )

                    )
                    {{-- <li><a href="{{ route('member.products.index') }}" class="waves-effect"><i class="icon-basket fa-fw"></i> <span class="hide-menu">@lang('app.menu.products') </span></a> </li> --}}
                    <li>
                        <a data-toggle="collapse" href="{{ route('admin.libraries.index') }}" data-target="#collapseTwo" aria-controls="collapseTwo" class="waves-effect ">
                            <i class="fa fa-book" aria-hidden="true"></i>

                            <span class="hide-menu">
                            @lang('modules.libraries.libraries')
                            <span class="fa arrow"></span>
                        </span>
                        </a>
                        <ul id="collapseTwo" class=" nav nav-second-level collapse toggled" aria-labelledby="headingOne">
                            @if($user->cans('view_libraries'))
                                <li><a class="menu-link" href="{{ route('admin.libraries.index') }}">@lang('modules.libraries.resources')</a>
                                </li>
                                <li><a class="menu-link" href="{{ route('admin.libraries.show-requests') }}">@lang('modules.libraries.borrowings')</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if(
                        (
                            in_array('archives',$modules)
                        )&&(
                            $user->cans('view_archives') ||
                            $user->cans('add_archives') ||
                            $user->cans('edit_archives') ||
                            $user->cans('delete_archives')
                        )
                    )
                    <li><a href="{{ route('admin.orders.index') }}" class="waves-effect ">
                            <i class="icon-list fa-fw"></i><span class="hide-menu">@lang('modules.orders.orders')
                            <span class="fa arrow"></span> </span></a>
                        <ul class="nav nav-second-level ">
                            @if($user->cans('view_archives'))
                            <li><a href="{{ route('admin.orders.index') }}" >@lang('modules.orders.orders')</a></li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if(in_array('legalAffairs',$modules) && ($user->cans('add_legalAffairs') || $user->cans('view_legalAffairs')))
                    <li><a href="{{ route('admin.cases.index')  }}" class="waves-effect "><i class="icon-lock fa-fw"></i><span class="hide-menu">@lang('app.menu.legal_affairs')<span class="fa arrow"></span> </span></a>
                        <ul class="nav nav-second-level ">
                            @if($user->cans('add_legalAffairs'))
                            <li><a href="{{ route('admin.penalties.create') }}">@lang('app.menu.create_penalty')</a></li>
                            @endif
                                @if($user->cans('view_legalAffairs'))
                            <li><a href="{{ route('admin.penalties.index') }}">@lang('app.menu.penalty_list')</a></li>
                                @endif
                                @if($user->cans('add_legalAffairs'))
                            <li><a href="{{ route('admin.cases.create')  }}">@lang('app.menu.create_case')</a></li>
                                @endif
                                @if($user->cans('view_legalAffairs'))
                            <li><a href="{{ route('admin.cases.index')  }}">@lang('app.menu.cases_list')</a></li>
                                @endif
                        </ul>
                    </li>
                @endif
            @endif

            @if ((in_array('projects', $modules) || in_array('tasks', $modules) || in_array('timelogs', $modules) || in_array('contracts', $modules))&&(
                        $user->cans('view_projects') ||
                        $user->cans('view_tasks') ||
                        $user->cans('view_timelogs') ||
                        $user->cans('view_contracts')
                    )
                )
                <li><a href="{{ route('admin.task.index') }}" class="waves-effect"><i
                                class="icon-layers fa-fw"></i> <span class="hide-menu"> @lang('app.menu.work') <span
                                    class="fa arrow"></span> </span></a>
                    <ul class="nav nav-second-level">
                        @if (in_array('contracts', $modules))
                            <li><a href="{{ route('admin.contracts.index') }}"
                                   class="waves-effect">@lang('app.menu.contracts')</a></li>
                        @endif
                        @if (in_array('products', $modules))
                            <li><a href="{{ route('admin.products.index') }}"
                                   class="waves-effect">@lang('app.menu.assets')</a></li>
                        @endif
                        @if (in_array('projects', $modules))
                            <li><a href="{{ route('admin.projects.index') }}"
                                   class="waves-effect">@lang('app.menu.projects') </a> </li>
                        @endif
                        @if (in_array('tasks', $modules))
                            <li><a href="{{ route('admin.all-tasks.index') }}">@lang('app.menu.tasks')</a></li>
                            <li class=""><a
                                        href="{{ route('admin.taskboard.index') }}">@lang('modules.tasks.taskBoard')</a>
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
{{--            @if(--}}
{{--                    in_array('projects',$modules)&&(--}}
{{--                        $user->cans('view_projects') ||--}}
{{--                        $user->cans('add_projects') ||--}}
{{--                        $user->cans('edit_projects') ||--}}
{{--                        $user->cans('delete_projects')--}}
{{--                    )--}}
{{--                )--}}
{{--            <li><a href="{{ route('member.projects.index') }}" class="waves-effect"><i class="icon-layers fa-fw"></i> <span class="hide-menu">@lang("app.menu.projects") </span> @if($unreadProjectCount > 0) <div class="notify notification-color"><span class="heartbit"></span><span class="point"></span></div>@endif</a> </li>--}}
{{--            @endif--}}

{{--            @if(in_array('contracts',$modules) && $user->cans('view_contract'))--}}
{{--                <li><a href="{{ route('member.contracts.index') }}" class="waves-effect"><i class="icon-layers fa-fw"></i> <span class="hide-menu">@lang("app.menu.contract") </span> </a> </li>--}}
{{--            @endif--}}

{{--            @if(in_array('products',$modules) && $user->cans('view_product'))--}}
{{--                <li><a href="{{ route('member.products.index') }}" class="waves-effect"><i class="icon-basket fa-fw"></i> <span class="hide-menu">@lang('app.menu.products') </span></a> </li>--}}
{{--            @endif--}}

{{--            @if(--}}
{{--                    in_array('tasks',$modules)&&(--}}
{{--                        $user->cans('view_tasks') ||--}}
{{--                        $user->cans('add_tasks') ||--}}
{{--                        $user->cans('edit_tasks') ||--}}
{{--                        $user->cans('delete_tasks')--}}
{{--                    )--}}
{{--                )--}}
{{--            <li><a href="{{ route('member.task.index') }}" class="waves-effect"><i class="ti-layout-list-thumb fa-fw"></i> <span class="hide-menu"> @lang('app.menu.tasks') <span class="fa arrow"></span> </span></a>--}}
{{--                <ul class="nav nav-second-level">--}}
{{--                    <li><a href="{{ route('member.all-tasks.index') }}">@lang('app.menu.tasks')</a></li>--}}
{{--                    <li><a href="{{ route('member.task-label.index') }}">@lang('app.menu.taskLabel')</a></li>--}}
{{--                    <li class="hidden-sm hidden-xs"><a href="{{ route('member.taskboard.index') }}">@lang('modules.tasks.taskBoard')</a></li>--}}
{{--                    <li><a href="{{ route('member.task-calendar.index') }}">@lang('app.menu.taskCalendar')</a></li>--}}
{{--                </ul>--}}
{{--            </li>--}}
{{--            @endif--}}

{{--            @if(--}}
{{--                    in_array('leads',$modules)&&(--}}
{{--                        $user->cans('view_leads') ||--}}
{{--                        $user->cans('add_leads') ||--}}
{{--                        $user->cans('edit_leads') ||--}}
{{--                        $user->cans('delete_leads')--}}
{{--                    )--}}
{{--                )--}}
{{--                <li><a href="{{ route('member.leads.index') }}" class="waves-effect"><i class="icon-doc fa-fw"></i> <span class="hide-menu">@lang('app.menu.lead') </span></a> </li>--}}
{{--            @endif--}}

{{--            @if(--}}
{{--                    in_array('timelogs',$modules)&&(--}}
{{--                        $user->cans('view_timelogs') ||--}}
{{--                        $user->cans('add_timelogs') ||--}}
{{--                        $user->cans('edit_timelogs') ||--}}
{{--                        $user->cans('delete_timelogs')--}}
{{--                    )--}}
{{--                )--}}
{{--                <li><a href="{{ route('member.all-time-logs.index') }}" class="waves-effect"><i class="icon-clock fa-fw"></i> <span class="hide-menu">@lang('app.menu.timeLogs') </span></a> </li>--}}
{{--            @endif--}}

            @if(in_array('attendance',$modules))
                @if($user->cans('view_attendance'))
                    <li><a href="{{ route('member.attendances.summary') }}" class="waves-effect"><i class="icon-clock fa-fw"></i> <span class="hide-menu">@lang("app.menu.attendance") </span></a> </li>
                @else
                    <li><a href="{{ route('member.attendances.index') }}" class="waves-effect"><i class="icon-clock fa-fw"></i> <span class="hide-menu">@lang("app.menu.attendance") </span></a> </li>
                @endif
            @endif

            @if(in_array('holidays',$modules))
            <li><a href="{{ route('member.holidays.index') }}" class="waves-effect"><i class="icon-calender fa-fw"></i> <span class="hide-menu">@lang("app.menu.holiday") </span></a> </li>
            @endif

{{--            @if(in_array('tickets',$modules))--}}
{{--            <li><a href="{{ route('member.tickets.index') }}" class="waves-effect"><i class="ti-ticket fa-fw"></i> <span class="hide-menu">@lang("app.menu.tickets") </span></a> </li>--}}
{{--            @endif--}}

            @if((in_array('estimates',$modules)|| in_array('invoices',$modules) || in_array('payments',$modules) ||in_array('expenses',$modules)) &&(
                $user->cans('view_estimates') ||
                $user->cans('view_invoices') ||
                $user->cans('view_payments') ||
                $user->cans('view_expenses')

            )
            )
            <li><a href="{{ route('member.finance.index') }}" class="waves-effect"><i class="fa fa-money fa-fw"></i> <span class="hide-menu"> @lang('app.menu.finance') @if($unreadExpenseCount > 0) <div class="notify notification-color"><span class="heartbit"></span><span class="point"></span></div>@endif <span class="fa arrow"></span> </span></a>
                <ul class="nav nav-second-level">
                    @if(in_array('estimates',$modules))
                    @if($user->cans('view_estimates'))
                        <li><a href="{{ route('member.estimates.index') }}">@lang('app.menu.estimates')</a> </li>
                    @endif
                    @endif

                    @if(in_array('invoices',$modules))
                    @if($user->cans('view_invoices'))
                        <li><a href="{{ route('member.all-invoices.index') }}">@lang('app.menu.invoices')</a> </li>
                        <li><a href="{{ route('member.invoice-recurring.index') }}">@lang('app.invoiceRecurring') </a></li>
                    @endif
                    @endif

                    @if(in_array('payments',$modules))
                    @if($user->cans('view_payments'))
                        <li><a href="{{ route('member.payments.index') }}">@lang('app.menu.payments')</a> </li>
                    @endif
                    @endif

                    @if(in_array('expenses',$modules))
                        <li><a href="{{ route('member.expenses.index') }}">@lang('app.menu.expenses') @if($unreadExpenseCount > 0) <div class="notify notification-color"><span class="heartbit"></span><span class="point"></span></div>@endif</a> </li>
                        <li> <a href="{{ route('member.expenses-recurring.index') }}">@lang('app.menu.expensesRecurring')</a> </li>
                        @endif
                    @if(in_array('invoices',$modules))
                        @if($user->cans('view_invoices'))
                            <li><a href="{{ route('member.all-credit-notes.index') }}">@lang('app.menu.credit-note') </a> </li>
                        @endif
                    @endif
                </ul>
            </li>
            @endif
{{--            @if(in_array("reports", $modules))--}}
{{--                <li><a href="{{ route('admin.reports.index') }}" class="waves-effect"><i class="ti-pie-chart fa-fw"></i> <span class="hide-menu"> @lang('app.menu.reports') <span class="fa arrow"></span> </span></a>--}}
{{--                    <ul class="nav nav-second-level">--}}
{{--                        @if(in_array('tasks',$modules))--}}
{{--                            <li><a href="{{ route('admin.task-report.index') }}">@lang('app.menu.taskReport')</a></li>--}}
{{--                        @endif--}}

{{--                        @if(in_array('timelogs',$modules))--}}
{{--                            <li><a href="{{ route('admin.time-log-report.index') }}">@lang('app.menu.timeLogReport')</a></li>--}}
{{--                        @endif--}}

{{--                        @if((in_array("estimates", $modules)  || in_array("invoices", $modules)  || in_array("payments", $modules) || in_array("expenses", $modules)  ))--}}
{{--                            <li><a href="{{ route('admin.finance-report.index') }}">@lang('app.menu.financeReport')</a></li>--}}
{{--                            <li><a href="{{ route('admin.income-expense-report.index') }}">@lang('app.menu.incomeVsExpenseReport')</a></li>--}}
{{--                        @endif--}}

{{--                        @if(in_array('leaves',$modules))--}}
{{--                            <li><a href="{{ route('admin.leave-report.index') }}">@lang('app.menu.leaveReport')</a></li>--}}
{{--                        @endif--}}

{{--                        @if(in_array('attendance',$modules))--}}
{{--                            <li><a href="{{ route('admin.attendance-report.index') }}">@lang('app.menu.attendanceReport')</a></li>--}}
{{--                        @endif--}}
{{--                    </ul>--}}
{{--                </li>--}}
{{--            @endif--}}

{{--            --}}{{--            @role('admin')--}}
{{--            --}}{{--            <li><a href="{{ route('admin.billing') }}" class="waves-effect"><i class="icon-book-open fa-fw"></i> <span class="hide-menu"> @lang('app.menu.billing')</span></a>--}}
{{--            --}}{{--            </li>--}}   
{{--            --}}{{--            @endrole--}}
            @if((in_array('accounting',$modules)) &&(
                $user->cans('view_accounting')
            )
            )
            @foreach ($worksuitePlugins as $item)
                @if(strtolower($item) != 'payroll')
                    @if (in_array(strtolower($item), $modules) || in_array($item, $modules))
                        @if (View::exists(strtolower($item) . '::sections.left_sidebar'))
                            @include(strtolower($item).'::sections.left_sidebar')
                        @endif
                    @endif
                @endif
            @endforeach
            @endif
            @if(in_array('messages',$modules))
            <li><a href="{{ route('member.user-chat.index') }}" class="waves-effect"><i class="icon-envelope fa-fw"></i> <span class="hide-menu">@lang("app.menu.messages") @if($unreadMessageCount > 0)<span class="label label-rouded label-custom pull-right">{{ $unreadMessageCount }}</span> @endif
                    </span>
                </a>
            </li>
            @endif

            @if(in_array('events',$modules))
            <li><a href="{{ route('member.events.index') }}" class="waves-effect"><i class="icon-calender fa-fw"></i> <span class="hide-menu">@lang('app.menu.Events')</span></a> </li>
            @endif

            @if(in_array('leaves',$modules))
            <li><a href="{{ route('member.leaves.index') }}" class="waves-effect"><i class="icon-logout fa-fw"></i> <span class="hide-menu">@lang('app.menu.leaves')</span></a> </li>
            @endif

            @if(in_array('notices',$modules))
                <li><a href="{{ route('member.notices.index') }}" class="waves-effect"><i class="ti-layout-media-overlay fa-fw"></i> <span class="hide-menu">@lang("app.menu.noticeBoard") </span></a> </li>
            @endif
            @if(!is_null($faqs))
                <li><a href="{{ route('member.faqs.index') }}" class="waves-effect"><i class="icon-docs fa-fw"></i> <span class="hide-menu">@lang('app.menu.employeeFaq')</span></a> </li>
            @endif

            {{-- <li><a href="#" class="waves-effect" id="rtl"><i class="ti-settings fa-fw"></i> <span class="hide-menu"> RTL</span></a></li> --}}

            @foreach ($worksuitePlugins as $item)
                @if(in_array(strtolower($item), $modules) || in_array($item, $modules))
                    @if(View::exists(strtolower($item).'::sections.member_left_sidebar'))
                        @include(strtolower($item).'::sections.member_left_sidebar')
                    @endif
                @endif
            @endforeach


        </ul>


    </div>
    <div class="menu-footer">
        <div class="menu-user row">
            <div class="col-lg-6 m-b-5">
                <div class="btn-group dropup user-dropdown">
                    @if(is_null($user->image))
                        <img  aria-expanded="false" data-toggle="dropdown" src="{{ asset('img/default-profile-3.png') }}" alt="user-img" class="img-circle dropdown-toggle h-30 w-30">

                    @else
                        <img aria-expanded="false" data-toggle="dropdown" src="{{ asset_url('avatar/'.$user->image) }}" alt="user-img" class="img-circle dropdown-toggle h-30 w-30">

                    @endif

                    <ul role="menu" class="dropdown-menu">
                        <li><a class="bg-inverse"><strong class="text-info">{{ ucwords($user->name) }}</strong></a></li>
                        @if($user->hasRole('admin'))
                            <li>
                                <a href="{{ route('admin.dashboard') }}">
                                    <i class="fa fa-sign-in"></i>  @lang("app.loginAsAdmin")
                                </a>
                            </li>
                        @endif
                        <li><a href="{{ route('member.profile.index') }}"><i class="ti-user"></i> @lang("app.menu.profileSettings")</a></li>                            <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                                document.getElementById('logout-form').submit();"
                            ><i class="fa fa-power-off"></i> @lang('app.logout')</a>

                        </li>

                    </ul>
                </div>
            </div>


            <div class="col-lg-6 text-center m-b-5">
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
