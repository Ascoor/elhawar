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
            <a href="{{ route('admin.members.create-recurring-invoice') }}" class="btn btn-outline btn-success btn-sm">@lang('app.add') @lang('app.automatic_membership_renew') <i class="fa fa-plus" aria-hidden="true"></i></a>
            <a href="{{ route('admin.members.renew-settings') }}" class="btn btn-outline btn-success btn-sm">@lang('app.renew_membership_items_setting') <i class="fa fa-plus" aria-hidden="true"></i></a>

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
    <link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/dropzone-master/dist/dropzone.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/daterange-picker/daterangepicker.css') }}" />

    <style>
        .table td {
            text-align: center;
        }
        .table th {
            text-align: center;
        }
        /*#invoices-recurring-table_wrapper .dt-buttons{*/
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
                                <h5 >@lang('app.selectDateRange')</h5>
                                <div class="form-group">
                                    <div id="reportrange" class="form-control reportrange">
                                        <i class="fa fa-calendar"></i>&nbsp;
                                        <span></span> <i class="fa fa-caret-down pull-right"></i>
                                    </div>

                                    <input type="hidden" class="form-control" id="start-date" placeholder="@lang('app.startDate')"
                                           value=""/>
                                    <input type="hidden" class="form-control" id="end-date" placeholder="@lang('app.endDate')"
                                           value=""/>
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <h5 class="box-title m-t-30">@lang('app.member_id')</h5>

                                <div class="form-group">
                                    <div class="row">
                                        <div class=" col-xs-12">
                                            <input type="text" id="memberID" name="member_id" class="form-control" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <h5 class="box-title m-t-30">@lang('app.category')</h5>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <select class="select2 form-control" name="category_id" id="category_id">
                                                <option value="all">@lang('app.all')</option>
                                                @foreach($categories as $category)
                                                    <option value="{{$category->id}}">{{ ucwords($category->category_name) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-xs-12">&nbsp;</label>
                                    <button type="button" id="apply-filters" class="btn btn-success col-md-6"><i class="fa fa-check"></i> @lang('app.apply')</button>
                                    <button type="button" id="reset-filters" class="btn btn-inverse col-md-5 col-md-offset-1"><i class="fa fa-refresh"></i> @lang('app.reset')</button>
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

    {{--Ajax Modal--}}
    <div class="modal fade bs-modal-md in" id="invoiceUploadModal" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-md" id="modal-data-application">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <span class="caption-subject font-red-sunglo bold uppercase" id="modelHeading">@lang('modules.invoices.uploadInvoice')</span>
                </div>
                <div class="modal-body">
                    <div class="row" id="file-dropzone">
                        <div class="row m-b-20" id="file-dropzone">
                            <div class="col-xs-12">
                                <form action="{{route('admin.invoiceFile.store')}}"
                                      class="dropzone"
                                      id="file-upload-dropzone">
                                    {{ csrf_field() }}
                                    <div class="fallback">
                                        <input name="file" type="file" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn default" data-dismiss="modal">@lang('app.close')</button>
                    <button type="button" class="btn blue" data-dismiss="modal">@lang('app.save')</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{--Ajax Modal Ends--}}
    <div class="modal fade bs-modal-md in" id="offlinePaymentDetails" role="dialog" aria-labelledby="myModalLabel"
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
        $(function() {
            var dateformat = '{{ $global->moment_format }}';

            var start = '';
            var end = '';

            function cb(start, end) {
                if(start){
                    $('#start-date').val(start.format(dateformat));
                    $('#end-date').val(end.format(dateformat));
                    $('#reportrange span').html(start.format(dateformat) + ' - ' + end.format(dateformat));
                }

            }
            moment.locale('{{ $global->locale }}');
            $('#reportrange').daterangepicker({
                // startDate: start,
                // endDate: end,
                locale: {
                    language: '{{ $global->locale }}',
                    format: '{{ $global->moment_format }}',
                },
                linkedCalendars: false,
                ranges: dateRangePickerCustom
            }, cb);

            cb(start, end);

        });
        $(".select2").select2({
            formatNoMatches: function () {
                return "{{ __('messages.noRecordFound') }}";
            }
        });

        $('#invoices-recurring-table').on('preXhr.dt', function (e, settings, data) {
            var startDate = $('#start-date').val();

            if (startDate == '') {
                startDate = null;
            }

            var endDate = $('#end-date').val();

            if (endDate == '') {
                endDate = null;
            }

            var status = $('#status').val();
            var projectID = $('#projectID').val();
            if (!projectID) {
                projectID = 'all';
            }
            var clientID = $('#clientID').val();
            var employeeID = $('#employeeID').val();
            var memberID = $('#memberID').val();
            var category_id = $('#category_id').val();

            data['startDate'] = startDate;
            data['endDate'] = endDate;
            data['status'] = status;
            data['projectID'] = projectID;
            data['clientID'] = clientID;
            data['employeeID'] = employeeID;
            data['memberID'] = memberID;
            data['category_id'] = category_id;
        });

        var table;
        $(function() {
            loadTable();

            $('body').on('click', '.sa-params', function () {
                var id = $(this).data('invoice-id');
                swal({
                    title: "@lang('messages.sweetAlertTitle')",
                    text: "@lang('messages.confirmation.recoverRecurringInvoice')",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "@lang('messages.deleteConfirmation')",
                    cancelButtonText: "@lang('messages.confirmNoArchive')",
                    closeOnConfirm: true,
                    closeOnCancel: true
                }, function (isConfirm) {
                    if (isConfirm) {

                        var url = "{{ route('admin.members.membership-renew-delete',':id') }}";
                        url = url.replace(':id', id);

                        var token = "{{ csrf_token() }}";

                        $.easyAjax({
                            type: 'POST',
                            url: url,
                            data: {'_token': token, '_method': 'DELETE'},
                            success: function (response) {
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

        function loadTable(){
            window.LaravelDataTables["invoices-recurring-table"].draw();
        }

        $('.toggle-filter').click(function () {
            $('#ticket-filters').toggle('slide');
        })

        $('#apply-filters').click(function () {
            loadTable();
        });

        $('#reset-filters').click(function () {
            $('#filter-form')[0].reset();
            $('#projectID').val('all');
            $('#clientID').val('all');
            $('#employeeID').val('all');
            $('#category_id').val('all');
            $('#status').selectpicker('render');
            $('#projectID').select2();
            $('#clientID').select2();
            $('#employeeID').select2();
            $('#category_id').select2();
            $('#start-date').val('');
            $('#end-date').val('');
            $('#reportrange span').html('');
            loadTable();
        })

        function exportData(){

            var startDate = $('#start-date').val();

            if (startDate == '') {
                startDate = null;
            }

            var endDate = $('#end-date').val();

            if (endDate == '') {
                endDate = null;
            }

            var status = $('#status').val();
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

        // Change recurring status
        $(document).on('click', '.change-status', function () {
            var url = "{{route('admin.invoice-recurring.changeStatus')}}";
            var token = "{{ csrf_token() }}";
            var id =  $(this).data('invoice-id');
            var status =  $(this).data('status');

            $.easyAjax({
                url: url,
                type: "POST",
                data: {'_token': token, invoiceId: id, status: status},
                success: function (data) {
                    if (data.status == "success") {
                        loadTable();
                    }
                }
            })
        })

    </script>
@endpush
