@extends('layouts.app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 bg-title-left">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __($pageTitle) }}
                <span class="m-l-10 text-info" id="total-employee">{{ 2 }}</span> <span
                        class="font-12 text-muted m-l-5">@lang('modules.stocks.inventories')</span>
            </h4>

        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12 text-right bg-title-right">
            
            <a href="{{ route('admin.stocks.request-create',['request_type' => 'withdraw'])}}" class="btn btn-outline btn-success btn-sm">@lang('modules.stocks.withdraw') @lang('modules.stocks.request')  <i class="fa fa-plus" aria-hidden="true"></i></a>
            <a href="{{ route('admin.stocks.request-create', ['request_type' => 'consumed']) }}" class="btn btn-outline btn-inverse btn-sm">@lang('modules.stocks.consume') @lang('modules.stocks.request')<i class="fa fa-plus" aria-hidden="true"></i></a>
            <a href="{{ route('admin.stocks.request-create', ['request_type' => 'retrieved']) }}" class="btn btn-outline btn-success btn-sm">@lang('modules.stocks.retrieve') @lang('modules.stocks.request')<i class="fa fa-plus" aria-hidden="true"></i></a>
            <a href="{{ route('admin.stocks.request-create', ['request_type' => 'scraped']) }}" class="btn btn-outline btn-success btn-sm">@lang('modules.stocks.scrape') @lang('modules.stocks.request')<i class="fa fa-plus" aria-hidden="true"></i></a>
                    
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}">@lang('app.menu.stocks')</a></li>
                <li class="active">{{ __($pageTitle) }}</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection

@push('head-script')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/multiselect/css/multi-select.css') }}">
@endpush

@section('content')

    <div class="row">

        <div class="col-xs-12">
            <div class="white-box">
                <button data-toggle="collapse" data-target="#collapseInventory" aria-controls="collapseInventory"
                    class="btn btn-primary m-b-10">@lang('modules.stocks.new_inventory')</button>
                <div id="collapseInventory" class="collapse row" aria-labelledby="headingOne">
                    <form class="row d-flex" method="POST" action="{{ route('admin.stocks.store') }}">
                        @csrf
                        <div class="form-group col-md-6">
                            <label for="name"> @lang('modules.stocks.name') </label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="@lang('modules.stocks.name')">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="descrption"> @lang('modules.stocks.description')</label>
                            <input type="text" name="description" class="form-control" id="descrption"
                                placeholder="@lang('modules.stocks.description')">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="location">  @lang('modules.stocks.location')</label>
                            <input type="text" name="location" class="form-control" id="location" placeholder="@lang('modules.stocks.location')">
                        </div>
                         <div class="col-md-12">

                        <button type="submit" class="btn btn-primary m-b-10">@lang('modules.stocks.add')</button>
                         </div>
                    </form>
                </div>
                <div class="table-responsive">
                    {!! $dataTable->table(['class' => 'table table-bordered table-hover toggle-circle default footable-loaded footable']) !!}
                </div>


            </div>

        </div>
    </div>
    <!-- .row -->

@endsection

@push('footer-script')
    <script src="{{ asset('plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script>
    <script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/multiselect/js/jquery.multi-select.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('js/datatables/buttons.server-side.js') }}"></script>
    {!! $dataTable->scripts() !!}


@endpush
