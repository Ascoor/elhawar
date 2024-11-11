
<li><a href="" class="waves-effect"><i class="fa fa-money fa-fw"></i> <span class="hide-menu">
            @lang('accounting::modules.accounting.accounting') <span class="fa arrow"></span> </span></a>
    
    <ul class="nav nav-second-level">
        
        <li class="tab @if((\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.accounting.credibtors.index'))  active @endif">
            <a href="{{route('admin.accounting.credibtors.index')}}">@lang('accounting::modules.accounting.CreDebtors')</a>
        </li>
    
        <li><a href="#" class="waves-effect"><i class="fa fa-file-text-o"></i> <span class="hide-menu"> @lang('accounting::modules.accounting.sidebar.dailyrecord') <span class="fa arrow"></span> </span></a>
            <ul class="nav nav-second-level">
                <li class='tab @if((\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.accounting.dailyrecords.index') and (\Illuminate\Support\Facades\Route::getCurrentRoute()->parameter('type')=="revenue"))  active @endif'><a href="{{route('admin.accounting.dailyrecords.index',['type'=>'revenue'])}}">@lang('accounting::modules.accounting.sidebar.dailyrecord_reven')</a></li>
                <li class='tab @if((\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.accounting.dailyrecords.index') and (\Illuminate\Support\Facades\Route::getCurrentRoute()->parameter('type')=="expenses"))  active @endif'><a href="{{route('admin.accounting.dailyrecords.index',['type'=>'expenses'])}}">@lang('accounting::modules.accounting.sidebar.dailyrecord_expen')</a></li>
            </ul>
        </li>

        <li><a href="#" class="waves-effect"><i class="fa fa-file-text-o"></i> <span class="hide-menu"> @lang('accounting::modules.accounting.sidebar.deprecation') <span class="fa arrow"></span> </span></a>
            <ul class="nav nav-second-level">
                <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.accounting.assetsdeprecations.index') active @endif"> <a href="{{route('admin.accounting.assetsdeprecations.index')}}">@lang('accounting::modules.accounting.sidebar.deprecationPercentages')</a></li>
                <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.codes.depreciation_statements') active @endif"> <a href="{{route('admin.accounting.depreciationsheet')}}">@lang('accounting::modules.accounting.sidebar.deprecationSheet')</a></li>
            </ul>
        </li>

        <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.accounting.report.revenexpen') active @endif">
            <a href="{{route('admin.accounting.report.revenexpen')}}">@lang('accounting::modules.accounting.sidebar.expenrevenreport')</a></li>

        <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.accounting.report.receiptpayments') active @endif">
            <a href="{{route('admin.accounting.report.receiptpayments')}}">@lang('accounting::modules.accounting.receiptpaymentsheet')</a></li>
    
        <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.accounting.lettersofguarantee.index') active @endif">
            <a href="{{route('admin.accounting.lettersofguarantee.index')}}">@lang('accounting::modules.accounting.sidebar.letters_of_guarantee')</a></li>
        <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.codes.Construction_process_extracts') active @endif">
            <a href="#">@lang('accounting::modules.accounting.sidebar.Construction_process_extracts')</a></li>
        <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.accounting.balancesheet') active @endif">
            <a href="{{route('admin.accounting.balancesheet')}}">@lang('accounting::modules.accounting.sidebar.balanceSheet')</a></li>
    
        <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.accounting.trialbalance') active @endif">
        <a href="{{route('admin.accounting.report.trialbalance')}}">@lang('accounting::modules.accounting.sidebar.trialbalance')</a></li>
                
        <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.accounting.loans.index') active @endif">
            <a href="{{route('admin.accounting.loans.index')}}">@lang('accounting::modules.accounting.sidebar.loans')</a></li>
        <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.accounting.banktransfers') active @endif">
            <a href="{{route('admin.accounting.banktransfers.index')}}">@lang('accounting::modules.accounting.sidebar.bank_transfers')</a></li>
        <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.accounting.checks.index') active @endif">
            <a href="{{route('admin.accounting.checks.index')}}">@lang('accounting::modules.accounting.sidebar.checks')</a></li>
        <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.accounting.insurances.index') active @endif">
                  <a href="{{route('admin.accounting.insurances.index')}}">@lang('accounting::modules.accounting.sidebar.insurances')</a></li>
        <li class="tab  @if((\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.accounting.inout.index') and (\Illuminate\Support\Facades\Route::getCurrentRoute()->parameter('type')=="out")) active @endif">
            <a href="{{route('admin.accounting.inout.index',['type'=>'out'])}}">@lang('accounting::modules.accounting.sidebar.outgoing')</a></li>
        <li class="tab  @if((\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.accounting.inout.index') and (\Illuminate\Support\Facades\Route::getCurrentRoute()->parameter('type')=="in")) active @endif">
            <a href="{{route('admin.accounting.inout.index',['type'=>'in'])}}">@lang('accounting::modules.accounting.sidebar.received')</a></li>
    
        </ul>
</li>
