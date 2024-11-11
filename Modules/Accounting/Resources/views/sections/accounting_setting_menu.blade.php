@section('other-section')

<ul class="nav tabs-vertical">
    <li class="tab">
    {{--    return to settings --}}
        <a href="{{ route('admin.settings.index') }}" class="text-danger"><i class="ti-arrow-left"></i> @lang('app.menu.settings')</a></li>
    {{--    codesettings accounts--}}
    <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.accounting.codesettings.index')
        @if(\Illuminate\Support\Facades\Route::getCurrentRoute()->parameter('type')=="accounts") active @endif @endif">
        <a href="{{route('admin.accounting.codesettings.index',['type'=>'accounts'])}}">@lang('accounting::modules.accounting.sidebar.codesettings_acc')</a></li>
    {{--    codesettings revenue--}}
    <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.accounting.codesettings.index')
            @if (\Illuminate\Support\Facades\Route::getCurrentRoute()->parameter('type')=="revenue")  active @endif @endif">
        <a href="{{route('admin.accounting.codesettings.index',['type'=>'revenue'])}}">@lang('accounting::modules.accounting.sidebar.codesettings_reven')</a></li>
    {{--    codesettings revenue--}}
    <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.accounting.codesettings.index')
            @if (\Illuminate\Support\Facades\Route::getCurrentRoute()->parameter('type')=="expenses"))  active @endif @endif">
        <a href="{{route('admin.accounting.codesettings.index',['type'=>'expenses'])}}">@lang('accounting::modules.accounting.sidebar.codesettings_expen')</a></li>
    {{--    codesettings credibtors--}}
    <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.accounting.codesettings.index')
            @if (\Illuminate\Support\Facades\Route::getCurrentRoute()->parameter('type')=="credibtors"))  active @endif @endif">
        <a href="{{route('admin.accounting.codesettings.index',['type'=>'credibtors'])}}">@lang('accounting::modules.accounting.credibtorCodes')</a></li>


    <li class="tab @if((\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.accounting.budgetterms.index') and (\Illuminate\Support\Facades\Route::getCurrentRoute()->parameter('type')=="accounts"))  active @endif">
        <a href="{{route('admin.accounting.budgetterms.index',['type'=>'expenses'])}}">@lang('accounting::modules.accounting.expenses_term')</a></li>
    <li class="tab @if((\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.accounting.budgetterms.index') and (\Illuminate\Support\Facades\Route::getCurrentRoute()->parameter('type')=="accounts"))  active @endif">
        <a href="{{route('admin.accounting.budgetterms.misc',['type'=>'expenses'])}}">@lang('accounting::modules.accounting.misc_expenses_term')</a></li>
    <li class="tab @if((\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.accounting.budgetterms.index') and (\Illuminate\Support\Facades\Route::getCurrentRoute()->parameter('type')=="accounts")) active @endif">
        <a href="{{route('admin.accounting.budgetterms.index',['type'=>'revenue'])}}">@lang('accounting::modules.accounting.revenue_term')</a></li>
    <li class="tab @if((\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.accounting.budgetterms.index') and (\Illuminate\Support\Facades\Route::getCurrentRoute()->parameter('type')=="accounts"))  active @endif">
        <a href="{{route('admin.accounting.budgetterms.misc',['type'=>'revenue'])}}">@lang('accounting::modules.accounting.misc_revenue_term')</a></li>
      
        <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.accounting.capital')  active @endif">
            <a href="{{route('admin.accounting.capital')}}" >@lang('accounting::modules.accounting.capital')</a></li>
    
            <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.accounting.revenexpencodes')  active @endif">
                <a href="{{route('admin.accounting.revenexpencodes')}}" >@lang('accounting::modules.accounting.revenexpencodes')</a></li>
    </ul>

{{--<script src="{{ asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>--}}
{{--<script>--}}
{{--    var screenWidth = $(window).width();--}}
{{--    if(screenWidth <= 768){--}}

{{--        $('.tabs-vertical').each(function() {--}}
{{--            var list = $(this), select = $(document.createElement('select')).insertBefore($(this).hide()).addClass('settings_dropdown form-control');--}}

{{--            $('>li a', this).each(function() {--}}
{{--                var target = $(this).attr('target'),--}}
{{--                    option = $(document.createElement('option'))--}}
{{--                        .appendTo(select)--}}
{{--                        .val(this.href)--}}
{{--                        .html($(this).html())--}}
{{--                        .click(function(){--}}
{{--                            if(target==='_blank') {--}}
{{--                                window.open($(this).val());--}}
{{--                            }--}}
{{--                            else {--}}
{{--                                window.location.href = $(this).val();--}}
{{--                            }--}}
{{--                        });--}}

{{--                if(window.location.href == option.val()){--}}
{{--                    option.attr('selected', 'selected');--}}
{{--                }--}}
{{--            });--}}
{{--            list.remove();--}}
{{--        });--}}

{{--        $('.settings_dropdown').change(function () {--}}
{{--            window.location.href = $(this).val();--}}
{{--        })--}}

{{--    }--}}
{{--</script>--}}
@endsection
