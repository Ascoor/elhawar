@extends('layouts.app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 bg-title-left">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __($pageTitle) }}
                <span class="m-l-10 text-info" id="total-employee">{{ $totalInventories }}</span> <span
                        class="font-12 text-muted m-l-5">@lang('modules.stocks.inventories')</span>
            </h4>

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
                @if($user->cans('add_inventories'))
                    <button data-toggle="collapse" data-target="#collapseInventory" aria-controls="collapseInventory"
                    class="btn btn-primary m-b-10">@lang('modules.stocks.new_inventory')
                    </button>
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
                @endif
                <div class="table-responsive">
                    {!! $dataTable->table(['class' => 'table table-bordered table-hover toggle-circle default footable-loaded footable']) !!}
                </div>


            </div>

        </div>
    </div>
        <!-- .row -->
    {{--Ajax Modal--}}
    <div class="modal fade bs-modal-md in" id="followUpModal" role="dialog" aria-labelledby="myModalLabel"
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
    {{--Ajax Modal Ends--}}

@endsection

@push('footer-script')
<script src="{{ asset('plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
<script src="//cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
<script src="//cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
<script src="//cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>

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
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);

    });
    var table;
    function tableLoad() {
        window.LaravelDataTables["invoices-table"].draw();
    }

    $(function() {
        tableLoad();
        $('#reset-filters').click(function () {
            $('#filter-form')[0].reset();
            $('#start-date').val('');
            $('#end-date').val('');
            $('#filter-form').find('select').selectpicker('render');
            $.easyBlockUI('#invoices-table');
            $('#reportrange span').html('');
            tableLoad();
            $.easyUnblockUI('#invoices-table');
        })
        var table;
        $('#apply-filters').click(function () {
            $('#invoices-table').on('preXhr.dt', function (e, settings, data) {
                var startDate = $('#start-date').val();

                if (startDate == '') {
                    startDate = null;
                }

                var endDate = $('#end-date').val();

                if (endDate == '') {
                    endDate = null;
                }

                var client = $('#client').val();
                var agent = $('#agent_id').val();
                var followUp = $('#followUp').val();
                var category_id = $('#category_id').val();
                var source_id = $('#source_id').val();

                data['startDate'] = startDate;
                data['endDate'] = endDate;
                data['client'] = client;
                data['agent'] = agent;
                data['followUp'] = followUp;
                data['category_id'] = category_id;
                data['source_id'] = source_id;

            });
            $.easyBlockUI('#invoices-table');
            tableLoad();
            $.easyUnblockUI('#invoices-table');
        });

        $('body').on('click', '.sa-params', function(){
            var id = $(this).data('user-id');
            swal({
                title: "@lang('messages.sweetAlertTitle')",
                text: "@lang('messages.confirmation.deleteLead')",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "@lang('messages.deleteConfirmation')",
                cancelButtonText: "@lang('messages.confirmNoArchive')",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function(isConfirm){
                if (isConfirm) {

                    var url = "{{ route('admin.stocks.destroy',':id') }}";
                    url = url.replace(':id', id);

                    var token = "{{ csrf_token() }}";

                    $.easyAjax({
                        type: 'POST',
                        url: url,
                        data: {'_token': token, '_method': 'DELETE'},
                        success: function (response) {
                            if (response.status == "success") {
                                var leadData = response.data;
                                $('#totalLeads').html(response.data.totalLeadsCount);
                                $('#totalClientConverted').html(response.data.totalClientConverted);
                                $('#pendingLeadFollowUps').html(response.data.pendingLeadFollowUps);
                                $.easyBlockUI('#invoices-table');
                                tableLoad();
                                $.easyUnblockUI('#invoices-table');
                            }
                        }
                    });
                }
            });
        });
    });

   function changeStatus(leadID, statusID){
       var url = "{{ route('admin.leads.change-status') }}";
       var token = "{{ csrf_token() }}";

       $.easyAjax({
           type: 'POST',
           url: url,
           data: {'_token': token,'leadID': leadID,'statusID': statusID},
           success: function (response) {
               if (response.status == "success") {
                $.easyBlockUI('#invoices-table');
                tableLoad();
                $.easyUnblockUI('#invoices-table');
               }
           }
       });
    }

    $('.edit-column').click(function () {
        var id = $(this).data('column-id');
        var url = '{{ route("admin.taskboard.edit", ':id') }}';
        url = url.replace(':id', id);

        $.easyAjax({
            url: url,
            type: "GET",
            success: function (response) {
                $('#edit-column-form').html(response.view);
                $(".colorpicker").asColorPicker();
                $('#edit-column-form').show();
            }
        })
    })

    function followUp (leadID) {

        var url = '{{ route('admin.leads.follow-up', ':id')}}';
        url = url.replace(':id', leadID);

        $('#modelHeading').html('Add Follow Up');
        $.ajaxModal('#followUpModal', url);
    }
    $('.toggle-filter').click(function () {
        $('#ticket-filters').toggle('slide');
    })
    function exportData(){

        var client = $('#client').val();
        var followUp = $('#followUp').val();

        var url = '{{ route('admin.leads.export', [':followUp', ':client']) }}';
        url = url.replace(':client', client);
        url = url.replace(':followUp', followUp);

        window.location.href = url;
    }
</script>
@endpush
