@extends('layouts.app')
@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12" style="width: fit-content">
            <h4 class="page-title" {{__('accounting::modules.accounting.rtl')}}><i class="{{ $pageIcon }}"></i> {{ $pageTitle }}</h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}" {{__('accounting::modules.accounting.rtl')}}>@lang('app.menu.home')</a></li>
                <li class="active" {{__('accounting::modules.accounting.rtl')}}>{{ $pageTitle }}</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection

@push('head-script')

<link href = "https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.2/themes/smoothness/jquery-ui.min.css" rel = "stylesheet">

@endpush



@section('content')
<div class="row">

    <div class="col-md-12">
        <div class="white-box">


@if ($errors->any())
    <div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    </div><br />
@endif

<form method="post">
    @csrf
            <div class="form-group mb-2" {{__('accounting::modules.accounting.rtl')}}>
                <label for="date"><i class='fa fa-calendar'></i> {{__('accounting::modules.accounting.startDate')}}</label>
                <input type="text" class="form-control datepicker"   name="startDate" value="{{old('startDate')}}" placeholder="{{__('accounting::modules.accounting.startDate')}}"  required/>
            </div>

            <div class="form-group mb-2" {{__('accounting::modules.accounting.rtl')}}>
                <label for="date"><i class='fa fa-calendar'></i> {{__('accounting::modules.accounting.endDate')}}</label>
                <input type="text" class="form-control datepicker"  name="endDate" value="{{old('endDate')}}" placeholder="{{__('accounting::modules.accounting.endDate')}}"  required/>
            </div>

            <button type="submit" class="btn btn-primary mb-5"> {{__('accounting::modules.accounting.submit')}}</button>


</form>


</div>
</div>
</div>
    </div>
    </div>

@endsection

@push('footer-script')

<!-- others -->
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<script type="text/javascript">

         $(function() {
            $( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true, changeYear: true @if (App::isLocale('ar')) , isRTL : true @endif});
        
        });
    
</script>
    

@endpush    
