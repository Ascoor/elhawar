@extends('layouts.app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-8 col-md-4 col-sm-4 col-xs-12 bg-title-left">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i>  {{ __($pageTitle) }}
            <span class="m-l-10 text-info" id="total-employee">{{ $totalCategories }}</span> <span
                    class="font-12 text-muted m-l-5">@lang('modules.stocks.categories')</span>
            </h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-4 col-sm-8 col-md-8 col-xs-12 text-right bg-title-right">

            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}">@lang('app.menu.stocks')</a></li>
                <li class="active">{{ __($pageTitle) }}</li>
            </ol>
            <button onclick="createsubcat()" class="btn btn-outline btn-success btn-sm m-b-10" id="addProjectCategory" type="button">
                <i class="fa fa-plus "></i> @lang('app.add') @lang('modules.stocks.category')
            </button>
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
@section('filter-section')
    <div class="row" id="ticket-filters">

        <form action="" id="filter-form">
            <div class="col-xs-12">
                <div class="form-group">
                    <label class="control-label">@lang('app.status')</label>
                    <select class="form-control select2" name="status" id="status" data-style="form-control">
                        <option value="all">@lang('modules.client.all')</option>
                        <option value="active">@lang('app.active')</option>
                        <option value="deactive">@lang('app.inactive')</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="form-group ">
                    <button type="button" id="apply-filters" class="btn btn-success col-md-6"><i class="fa fa-check"></i>
                        @lang('app.apply')</button>
                    <button type="button" id="reset-filters" class="btn btn-inverse col-md-5 col-md-offset-1"><i
                            class="fa fa-refresh"></i> @lang('app.reset')</button>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('content')
<div class="modal fade bs-modal-md in" id="taxModal" role="dialog" aria-labelledby="myModalLabel"
aria-hidden="true">
<div class="modal-dialog modal-md" id="modal-data-application">
   <div class="modal-content">
       <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
           <span class="caption-subject font-red-sunglo bold uppercase" id="modelHeading"></span>
       </div>
       <div class="modal-body">
           Loading...
       </div>
       <div class="modal-footer">
           <button type="button" class="btn default" data-dismiss="modal">Close</button>
           <button type="button" class="btn blue">Save changes</button>
       </div>
   </div>
   <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
    <div class="row">

        <div class="col-xs-12">
            <div class="white-box">
                
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
<script>
    function createsubcat() {
    var url = '{{ route('admin.categories.create')}}';
    $('#modelHeading').html('Manage Project Category');
    $.ajaxModal('#taxModal', url);
    $('#taxModal').on('hidden.bs.modal', function () {
        location.reload();
        })
    }
</script>