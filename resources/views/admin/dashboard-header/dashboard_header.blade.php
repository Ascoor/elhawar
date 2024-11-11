<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 bg-title-left">
        <h4 class="page-title"><i class="{{ $pageIcon }}"></i> @lang($pageTitle)</h4>
    </div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
  
    <div class="col-lg-9 col-sm-4 col-md-4 col-xs-12 bg-title-right">
        
        @if(session('impersonate'))
        <a class="btn b-all waves-effect waves-light pull-right" data-toggle="tooltip" 
    data-original-title="{{__('messages.stopImpersonation')}}" data-placement="left" href="{{route('admin.impersonate.stop')}}" >
                <i class="fa fa-stop fa-blink text-danger"></i>
                     
            </a>
        @endif

        <div class="col-lg-12 col-md-12 pull-left hidden-xs hidden-sm">
            {!! Form::open(['id'=>'createProject','class'=>'ajax-form','method'=>'POST']) !!}
            {!! Form::hidden('dashboard_type', 'admin-client-dashboard') !!}
            <div class="btn-group dropdown keep-open pull-right m-l-10 ">
                <button aria-expanded="true" data-toggle="dropdown"
                        class="btn bg-white b-all dropdown-toggle waves-effect waves-light"
                        type="button"><i class="icon-settings"></i>
                </button>
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

    @if($global->dashboard_clock)
        <span id="clock" class="dashboard-clock text-muted m-r-50"></span>
    @endif
            
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