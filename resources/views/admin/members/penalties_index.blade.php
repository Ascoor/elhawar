@extends('layouts.app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 bg-title-left">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __($pageTitle) }} <span class="text-warning b-l p-l-10 m-l-5">{{ $pendingPenalties}}</span> <a class="font-12 text-muted m-l-5"> @lang('modules.members.pendingPenalties')</a></h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12 text-right bg-title-right">

            <ol class="breadcrumb">

            </ol>
        </div>
        <!-- /.breadcrumb -->

{{-- rola  --}}
        <div class="col-lg-2 col-sm-6 col-md-7 col-xs-12 text-right bg-title-right">
            {{--  added the launages setting" --}} 
             @include('admin.dashboard-header.header_others')
         </div>
         
    </div>
    

@endsection

@push('head-script')
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/morrisjs/morris.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/daterange-picker/daterangepicker.css') }}" />

@endpush



@section('filter-section')
    <div class="row m-b-10">
        {!! Form::open(['id'=>'storePayments','class'=>'ajax-form','method'=>'POST']) !!}



        <div class="col-xs-12">
            <h5 class="box-title m-t-30">@lang('app.user') @lang('app.name')</h5>

            <div class="form-group">
                <div class="row">
                    <div class="col-xs-12">
                        <label for="">@lang('app.member_id')
                        </label>
                        <input type="text" id="member_id" name="member_id" class="form-control" value="">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <h5 class="box-title m-t-30">@lang('modules.members.penalty_type')</h5>

            <div class="form-group">
                <div class="row">
                    <div class="col-xs-12">
                        <select class="select2 form-control" data-placeholder="@lang('modules.members.penalty_type')" id="penalty_type">
                            <option value="">--</option>
                                <option value="@lang('modules.members.suspend_membership')">@lang('modules.members.suspend_membership')</option>
                            <option value="@lang('modules.members.financial_penalty')">@lang('modules.members.financial_penalty')</option>

                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12">
            <button type="button" class="btn btn-success" id="filter-results"><i class="fa fa-check"></i> @lang('app.apply')
            </button>
        </div>
        {!! Form::close() !!}

    </div>
@endsection
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="white-box">
            <h3 class="box-title">@lang("app.menu.penalties")</h3>

            <div class="table-responsive">
                <table class="table table-bordered table-hover toggle-circle default footable-loaded footable"
                       id="leave-table">
                    <thead>
                    <tr>
                        <th>@lang('app.id')</th>
                        <th>@lang('app.user')</th>
                        <th>@lang('app.penalty_type')</th>
                        <th>@lang('app.amount')</th>
                        <th>@lang('app.menu.penalties') @lang('app.status')</th>
                        <th>@lang('app.action')</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div>

</div>



<div class="modal fade bs-example-modal-lg" id="leave-details" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">Large modal</h4>
            </div>
            <div class="modal-body">
                Loading...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
{{--Ajax Modal--}}
<div class="modal fade bs-modal-md in" id="eventDetailModal" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" id="modal-data-application">
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

    <script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/raphael/raphael-min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/morrisjs/morris.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script>
    <script src="{{ asset('plugins/bower_components/moment/moment.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/daterange-picker/daterangepicker.js') }}"></script>
    <script>
        {{--$(function() {--}}
        {{--    var dateformat = '{{ $global->moment_format }}';--}}

        {{--    var startDate = '{{ $fromDate->format($global->date_format) }}';--}}
        {{--    var start = moment(startDate, dateformat);--}}

        {{--    var endDate = '{{ $toDate->format($global->date_format) }}';--}}
        {{--    var end = moment(endDate, dateformat);--}}

        {{--    function cb(start, end) {--}}
        {{--        $('#start-date').val(start.format(dateformat));--}}
        {{--        $('#end-date').val(end.format(dateformat));--}}
        {{--        $('#reportrange span').html(start.format(dateformat) + ' - ' + end.format(dateformat));--}}
        {{--    }--}}
        {{--    moment.locale('{{ $global->locale }}');--}}
        {{--    $('#reportrange').daterangepicker({--}}
        {{--        startDate: start,--}}
        {{--        endDate: end,--}}

        {{--        locale: {--}}
        {{--            language: '{{ $global->locale }}',--}}
        {{--            format: '{{ $global->moment_format }}',--}}
        {{--        },--}}
        {{--        ranges: {--}}
        {{--            'Today': [moment(), moment()],--}}
        {{--            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],--}}
        {{--            'Last 7 Days': [moment().subtract(6, 'days'), moment()],--}}
        {{--            'Last 30 Days': [moment().subtract(29, 'days'), moment()],--}}
        {{--            'This Month': [moment().startOf('month'), moment().endOf('month')],--}}
        {{--            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]--}}
        {{--        }--}}
        {{--    }, cb);--}}

        {{--    cb(start, end);--}}

        {{--});--}}

        $('#leave-table').on('click', '.leave-action-reject', function () {
            console.log('test');
            var action = $(this).data('leave-action');
            var leaveId = $(this).data('leave-id');
            var searchQuery = "?leave_action="+action+"&leave_id="+leaveId;
            var url = '{!! route('admin.members.show-reject-modal') !!}'+searchQuery;
            $('#modelHeading').html('Reject Reason');
            $.ajaxModal('#eventDetailModal', url);
        });

        $('#leave-table').on('click', '.leave-action', function() {
            var action = $(this).data('leave-action');
            var leaveId = $(this).data('leave-id');
            var url = '{{ route("admin.members.penaltyAction") }}';

            $.easyAjax({
                type: 'POST',
                url: url,
                data: { 'action': action, 'leaveId': leaveId, '_token': '{{ csrf_token() }}' },
                success: function (response) {
                    if(response.status == 'success'){
                        /*window.location.reload();*/
                        loadTable();
                    }
                }
            });

        })

        $(".select2").select2({
            formatNoMatches: function () {
                return "{{ __('messages.noRecordFound') }}";
            }
        });

        loadTable();
        $('#filter-results').click(function () {
            loadTable();
        });


        function loadTable(){
            var startDate = $('#start-date').val();

            if (startDate == '') {
                startDate = null;
            }

            var endDate = $('#end-date').val();

            if (endDate == '') {
                endDate = null;
            }
            var penalty_type =$('#penalty_type').val();
            var member_id = $('#member_id').val();
            if (!member_id) {
                member_id = 0;
            }

            var url = '{!!  route('admin.members.data', [':member_id']) !!}';

            url = url.replace(':member_id', member_id);

            var table = $('#leave-table').dataTable({
                responsive: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    "url": url,
                    "type": "GET",
                    data: function (d) {
                        // d.startDate = startDate;
                        // d.endDate = endDate;
                        d.penalty_type=penalty_type;
                        d._token = '{{ csrf_token() }}';
                    }
                },
                language: {
                    "url": "<?php echo __("app.datatable") ?>"
                },
                "fnDrawCallback": function( oSettings ) {
                    $("body").tooltip({
                        selector: '[data-toggle="tooltip"]'
                    });
                },
                columns: [
                    { data: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'user', name: 'user' },
                    { data: 'penalty_type', name: 'penalty_type' },
                    { data: 'amount', name: 'amount' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action' }
                ]
            });

        }

        $('body').on('click', '.show-leave', function () {
            var leaveId = $(this).data('leave-id');

            var url = '{{ route('admin.members.show-penalty', ':id') }}';
            url = url.replace(':id', leaveId);

            $('#modelHeading').html('Leave Details');
            $.ajaxModal('#leave-details', url);
        });

    </script>
@endpush