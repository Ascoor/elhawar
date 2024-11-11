@extends('layouts.app')
@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12" style="width: fit-content">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ $pageTitle }}</h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
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
        <div class="panel panel-inverse">
            <div class="panel-heading">@lang('modules.accountSettings.updateTitle')</div>

            <div class="vtabs customvtab m-t-10">

                @include('accounting::sections.accounting_setting_menu')

        <div class="white-box">

@if(session()->get('success'))
<div class="alert alert-success">
  {{ session()->get('success') }}
</div><br />
@endif

<a class='btn btn-primary mb-3' href='{{route('admin.accounting.revenexpencodes.create')}}'><i class="fa fa-plus-circle" aria-hidden="true"></i> {{__('accounting::modules.accounting.add')}}</a>
<br><br>
<div class="table-responsive-lg">
<table class="table table-bordered data-table">
    <thead>
        <tr>
            <th>{{__('accounting::modules.accounting.code')}}</th>
            <th>{{__('accounting::modules.accounting.name')}}</th>
            <th class='p-2'><i class="fa fa-cogs" aria-hidden="true"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($codes as $code)
            <tr>
                <td>{{$code->code->code}}</td>
                <td>{{$code->code->breadcrumb}}</td>
                <td><a href="#" class='btn btn-danger' onclick="confirmDelete('{{$code->id}}')"><i class="fa fa-trash-o"></i></a></td>
            </tr>
        @endforeach
    </tbody>
</table>
</div>

</div>
</div>
</div>
    </div>
    </div>

@endsection
@section('destroyRoute'){{route('admin.accounting.revenexpencodes.delete')}}@endsection
@push('footer-script')
    @include('accounting::sections.blocks.deleteConfirmSwal')
@endpush
