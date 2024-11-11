@extends('layouts.app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 bg-title-left">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __($pageTitle) }}</h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12 text-right bg-title-right">
            @if($user->cans('add_inventories'))
                <a href="{{ route('admin.stocks.request-create',['request_type' => 'withdraw'])}}" class="btn btn-outline btn-success btn-sm">@lang('modules.stocks.withdraw') @lang('modules.stocks.request')  <i class="fa fa-plus" aria-hidden="true"></i></a>
                <a href="{{ route('admin.stocks.request-create', ['request_type' => 'consumed']) }}" class="btn btn-outline btn-inverse btn-sm">@lang('modules.stocks.consume') @lang('modules.stocks.request')<i class="fa fa-plus" aria-hidden="true"></i></a>
                <a href="{{ route('admin.stocks.request-create', ['request_type' => 'retrieved']) }}" class="btn btn-outline btn-success btn-sm">@lang('modules.stocks.retrieve') @lang('modules.stocks.request')<i class="fa fa-plus" aria-hidden="true"></i></a>
                <a href="{{ route('admin.stocks.request-create', ['request_type' => 'scraped']) }}" class="btn btn-outline btn-success btn-sm">@lang('modules.stocks.scrape') @lang('modules.stocks.request')<i class="fa fa-plus" aria-hidden="true"></i></a>
            @endif

            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}">@lang('app.menu.home')</a></li>
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
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/dropzone-master/dist/dropzone.css') }}">
    <link rel="stylesheet"
        href="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/daterange-picker/daterangepicker.css') }}" />

    <style>
        /*#invoices-table_wrapper .dt-buttons{*/
        /*    display: none !important;*/
        /*}*/

    </style>
@endpush

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="white-box">

            @section('filter-section')
                <div class="row" id="ticket-filters">

                    <form action="" id="filter-form">
                        <div class="col-xs-12">
                            <h5>@lang('app.product')</h5>
                            <div class="form-group">
                                {{-- <label class="control-label">@lang('app.status')</label> --}}
                                <select class="form-control selectpicker" name="product" id="product"
                                    data-style="form-control">
                                    <option value="all">@lang('app.all')</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->product }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <h5>@lang('modules.stocks.inventory')</h5>
                            <div class="form-group">
                                {{-- <label class="control-label">@lang('app.status')</label> --}}
                                <select class="form-control selectpicker" name="inventory" id="inventory"
                                        data-style="form-control">
                                    <option value="all">@lang('app.all')</option>
                                    @foreach ($inventories as $inventory)
                                        <option value="{{ $inventory->id }}">{{ $inventory->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <h5>@lang('app.startDate')</h5>
                            <div class="form-group">
                                <input class="form-control selectpicker" type="date" name="startDate" id="startDate"
                                        data-style="form-control"
                               />
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <h5>@lang('app.endDate')</h5>
                            <div class="form-group">
                                <input class="form-control selectpicker" type="date" name="endDate" id="endDate"
                                       data-style="form-control"
                                />
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label class="control-label col-xs-12">&nbsp;</label>
                                <button type="button" id="apply-filters" class="btn btn-success col-md-6"><i
                                        class="fa fa-check"></i> @lang('app.apply')</button>
                                <button type="button" id="reset-filters" class="btn btn-inverse col-md-5 col-md-offset-1"><i
                                        class="fa fa-refresh"></i> @lang('app.reset')</button>
                            </div>
                        </div>
                    </form>
                </div>
            @endsection

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
<script src="{{ asset('plugins/bower_components/dropzone-master/dist/dropzone.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('js/datatables/buttons.server-side.js') }}"></script>
<script src="{{ asset('plugins/bower_components/moment/moment.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/daterange-picker/daterangepicker.js') }}"></script>
{!! $dataTable->scripts() !!}
<script>

    $(".select2").select2({
        formatNoMatches: function() {
            return "{{ __('messages.noRecordFound') }}";
        }
    });

    $('#invoices-table').on('preXhr.dt', function(e, settings, data) {


        var product = $('#product').val();
        data['product'] = product;
        var inventory = $('#inventory').val();
        data['inventory'] = inventory;
        var startDate = $('#startDate').val();
        data['startDate'] = startDate;
        var endDate = $('#endDate').val();
        data['endDate'] = endDate;
    });


    var table;
    $(function() {
        loadTable();
        jQuery('#date-range').datepicker({
            toggleActive: true,
            format: '{{ $global->date_picker_format }}',
            language: '{{ $global->locale }}',
            autoclose: true,
            weekStart: '{{ $global->week_start }}',
        });
        $('body').on('click', '.sa-params', function() {
            var id = $(this).data('invoice-id');
            swal({
                title: "@lang('messages.sweetAlertTitle')",
                text: "@lang('messages.confirmation.deleteRecoverInvoice')",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "@lang('messages.deleteConfirmation')",
                cancelButtonText: "@lang('messages.confirmNoArchive')",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function(isConfirm) {
                if (isConfirm) {

                    var url = "{{ route('admin.all-invoices.destroy', ':id') }}";
                    url = url.replace(':id', id);

                    var token = "{{ csrf_token() }}";

                    $.easyAjax({
                        type: 'POST',
                        url: url,
                        data: {
                            '_token': token,
                            '_method': 'DELETE'
                        },
                        success: function(response) {
                            if (response.status == "success") {
                                $.unblockUI();
                                loadTable();
                            }
                        }
                    });
                }
            });
        });
    });

    function loadTable() {
        window.LaravelDataTables["invoices-table"].draw();
    }

    function toggleShippingAddress(invoiceId) {
        let url = "{{ route('admin.all-invoices.toggleShippingAddress', ':id') }}";
        url = url.replace(':id', invoiceId);

        $.easyAjax({
            url: url,
            type: 'GET',
            success: function(response) {
                if (response.status === 'success') {
                    loadTable();
                }
            }
        })
    }

    function addShippingAddress(invoiceId) {
        let url = "{{ route('admin.all-invoices.shippingAddressModal', ':id') }}";
        url = url.replace(':id', invoiceId);

        $.ajaxModal('#invoiceUploadModal', url);
    }

    //    $('#file-upload-dropzone').dropzone({
    Dropzone.options.fileUploadDropzone = {
        paramName: "file", // The name that will be used to transfer the file
        dictDefaultMessage: "@lang('modules.projects.dropFile')",
        uploadMultiple: false,
        dictCancelUpload: "Cancel",
        accept: function(file, done) {
            done();
        },
        init: function() {
            this.on('addedfile', function() {
                if (this.files.length > 1) {
                    this.removeFile(this.files[0]);
                }
            });
            this.on("success", function(file, response) {});
            var newDropzone = this;

            $('#invoiceUploadModal').on('hide.bs.modal', function() {
                newDropzone.removeAllFiles(true);
            });

        }
    };
    //    });

    $('.toggle-filter').click(function() {
        $('#ticket-filters').toggle('slide');
    })

    $('#apply-filters').click(function() {
        loadTable();
    });

    $('#reset-filters').click(function() {
        $('#filter-form')[0].reset();
        $('#product').val('all');
        $('#inventory').val('all');

        loadTable();
    })

    function exportData() {

        var startDate = $('#start-date').val();

        if (startDate == '') {
            startDate = null;
        }

        var endDate = $('#end-date').val();

        if (endDate == '') {
            endDate = null;
        }

        var status = $('#product').val();
        var projectID = $('#projectID').val();
        if (!projectID) {
            projectID = 'all';
        }

        var url = '{{ route('admin.all-invoices.export', [':startDate', ':endDate', ':status', ':projectID']) }}';
        url = url.replace(':startDate', startDate);
        url = url.replace(':endDate', endDate);
        url = url.replace(':status', status);
        url = url.replace(':projectID', projectID);

        window.location.href = url;
    }

</script>
@endpush
