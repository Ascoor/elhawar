@extends('layouts.club_member-app')

@section('page-title')
    <div class="row bg-title">

        <!-- .page title -->
        <div class="col-lg-8 col-md-5 col-sm-6 col-xs-12 bg-title-left">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __($pageTitle) }}
                <span class="text-info b-l p-l-10 m-l-5">{{ $totalLocations }}</span> <span
                        class="font-12 text-muted m-l-5"> @lang('modules.dashboard.totalLocations')</span>
            </h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-4 col-sm-6 col-md-7 col-xs-12 text-right bg-title-right">

            <ol class="breadcrumb">
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
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/daterange-picker/daterangepicker.css') }}" />


    <style>
        .filter-section::-webkit-scrollbar {
            display: block !important;
        }
    </style>
@endpush

@section('filter-section')
    <div class="row"  id="ticket-filters">

        <form action="" id="filter-form">


            <div class="col-xs-12">
                <div class="form-group">
                    <h5 >@lang('app.location')</h5>
                    <input type="text" id="location" name="location" class="form-control" value="">

                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <h5>@lang('app.capacity')</h5>

                    <input type="text" id="capacity" name="capacity" class="form-control" value="">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <h5>@lang('app.guardian')</h5>

                    <input type="text" id="guardian" name="guardian" class="form-control" value="">
                </div>
            </div>


            <div class="col-xs-12">
                <div class="form-group p-t-10">
                    <button type="button" id="apply-filters" class="btn btn-success col-md-6"><i class="fa fa-check"></i> @lang('app.apply')</button>
                    <button type="button" id="reset-filters" class="btn btn-inverse col-md-5 col-md-offset-1"><i class="fa fa-refresh"></i> @lang('app.reset')</button>
                </div>
            </div>
        </form>
    </div>
@endsection


@section('content')

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
    {{--    Ajax Modal--}}
    <div class="modal fade bs-modal-md in" id="clientCategoryModal" role="dialog" aria-labelledby="myModalLabel"
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
    {{--    Ajax Modal Ends--}}
@endsection

@push('footer-script')
    <script src="{{ asset('plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script>
    <script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('js/datatables/buttons.server-side.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/moment/moment.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/daterange-picker/daterangepicker.js') }}"></script>
    {!! $dataTable->scripts() !!}

    <script>
        var table;
        {{----}}


        $('.toggle-filter').click(function () {
            $('#ticket-filters').toggle('slide');
        })

        $('#apply-filters').click(function () {
            $('#members-table').on('preXhr.dt', function (e, settings, data) {
                var location = $('#location').val();
                var capacity = $('#capacity').val();
                var guardian = $('#guardian').val();

                data['location'] = location;
                data['capacity'] = capacity;
                data['guardian'] = guardian;

            });
            $.easyBlockUI('#members-table');
            window.LaravelDataTables["members-table"].draw();
            $.easyUnblockUI('#members-table');
        });

        $('#reset-filters').click(function () {
            $('#filter-form')[0].reset();
            $('.select2').val('all');
            $('#filter-form').find('select').select2();

            $.easyBlockUI('#members-table');
            $('#start-date').val('');
            $('#end-date').val('');
            $('#reportrange span').html('');

            window.LaravelDataTables["members-table"].draw();
            $.easyUnblockUI('#members-table');
        })

        function exportData(){

            var member = $('#member').val();
            var status = $('#status').val();

            var url = '{{ route('admin.clients.export', [':status', ':client']) }}';
            url = url.replace(':member', member);
            url = url.replace(':status', status);

            window.location.href = url;
        }

    </script>
@endpush