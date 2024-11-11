@section('page-title')
    <style> .bg-title{display:flex} </style>
    <div class="row bg-title" {{__('accounting::modules.accounting.rtl')}} >
        <!-- .page title -->
        <div class="col-md-3 col-sm-12 bg-title-left">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ $pageTitle }}</h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-md-9 col-sm-12" id="btns-container">
            @if (!(isset($addTopButton) && !$addTopButton))
                <a href="@yield('createRoute','#')" class="btn btn-outline btn-success btn-sm">
                    @lang('app.add')
                    <i class="fa fa-plus" aria-hidden="true"></i>
                </a>
            @endif
            
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}">@lang('app.menu.home')</a></li>
                <li class="active">{{ __($pageTitle) }}</li>
            </ol>
            
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection
