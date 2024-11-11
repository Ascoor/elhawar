@extends('layouts.app')
@section('page-title')
    <div class="row bg-title" {{__('accounting::modules.accounting.rtl')}}>
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12" style="width: fit-content" {{__('accounting::modules.accounting.rtl')}}>
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ $pageTitle }}</h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12" {{__('accounting::modules.accounting.rtl')}}>
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}">@lang('app.menu.home')</a></li>
                <li class="active">{{ $pageTitle }}</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-inverse" {{__('accounting::modules.accounting.rtl')}}>
            <div class="panel-heading"></div>

            <div class="vtabs customvtab m-t-10">

                @include('accounting::sections.accounting_setting_menu')
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


<form method="post"  {{__('accounting::modules.accounting.rtl')}}>
    @csrf
<div class="form-group" >
    <label for="">@lang('accounting::modules.accounting.code')</label>
    <select class='form-select form-input select2' style='width:100%' name='code_id' required><option value="">{{__('accounting::modules.accounting.code')}}</option></select>
</div>

<button type="submit" class="btn btn-primary mb-2" id='formSubmit'><i class="fa fa-floppy-o" aria-hidden="true"></i> {{__('app.save')}}</button>

</form>

</div>
</div>
</div>
    </div>
</div>
</div>
@endsection

{{-- Other Independant Blocks --}}
@php ($select2URL=route('admin.accounting.dailyrecords.ajax',['credibtors','selCodeAll']))
@php ($select2SentData="type:'CREDIBTOR'")
@include('accounting::sections.blocks.select2')




