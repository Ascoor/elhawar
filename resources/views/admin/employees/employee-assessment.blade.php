@extends('layouts.app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-8 col-md-4 col-sm-4 col-xs-12 bg-title-left">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __($pageTitle) }} </h4>
        </div>
        <!-- /.page title -->

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
    <div class="row"  id="ticket-filters">
        <form action="" id="filter-form">
            <div class="col-xs-12">
                <div class="form-group">
                    <label class="control-label">@lang('app.status')</label>
                    <select class="form-control select2" name="status" id="status" data-style="form-control">
                        <option value="all">@lang('modules.client.all')</option>
                        <option value="pending">@lang('app.pending')</option>
                        <option value="approved">@lang('app.approved')</option>
                        <option value="refused">@lang('app.refused')</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="form-group">
                    <label class="control-label">@lang('modules.employees.title')</label>
                    <select class="form-control select2" name="employee" id="employee" data-style="form-control">
                        <option value="all">@lang('modules.client.all')</option>
                        @forelse($employees as $employee)
                            <option value="{{$employee->id}}">{{ ucfirst($employee->name) }}</option>
                        @empty
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="form-group">
                    <label class="control-label">@lang('app.menu.assessment-name-no')</label>
                    <select class="form-control select2" name="filter_assessment_name" id="filter_assessment_name" data-style="form-control">
                        <option value="all">@lang('modules.client.all')</option>
                        @forelse($assessments as $assessment)
                            <option value="{{$assessment->name}}">{{ucfirst($assessment->name) }}</option>
                        @empty
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="form-group">
                    <label class="control-label">@lang('app.menu.assessmentLargerThan')</label>
                    <select class="form-control select2" name="percentlargere" id="percentlargere" data-style="form-control">
                        <option value="all">@lang('modules.client.all')</option>
                        @for($ind=1;$ind<101;$ind++)
                            <option value="{{$ind}}">{{$ind}} % </option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="form-group">
                    <label class="control-label">@lang('app.menu.assessmentLessThan')</label>
                    <select class="form-control select2" name="percentless" id="percentless" data-style="form-control">
                        <option value="all">@lang('modules.client.all')</option>
                        @for($ind=1;$ind<101;$ind++)
                            <option value="{{$ind}}">{{$ind}} % </option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="form-group ">
                    <button type="button" id="apply-filters" class="btn btn-success col-md-6"><i class="fa fa-check"></i> @lang('app.apply')</button>
                    <button type="button" id="reset-filters" class="btn btn-inverse col-md-5 col-md-offset-1"><i class="fa fa-refresh"></i> @lang('app.reset')</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('content')

    <div class="row dashboard-stats">
        <div class="col-md-12 m-b-30">
            <div class="white-box">
                <div class="col-sm-6 text-center">
                    <h4><span class="text-info" id="total-employee">{{ $totalAssessments }}</span> <span class="font-12 text-muted m-l-5"> @lang('app.total')@lang('app.menu.assessments')</span></h4>
                </div>
            </div>
        </div>

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
    <script>

        $(".select2").select2({
            formatNoMatches: function () {
                return "{{ __('messages.noRecordFound') }}";
            }
        });
        var table;

        $(function() {
            loadTable();

            $('body').on('click', '.sa-params', function(){
                var id = $(this).data('user-id');
                swal({
                    title: "@lang('messages.sweetAlertTitle')",
                    text: "@lang('messages.confirmation.recoverDeleteUser')",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "@lang('messages.deleteConfirmation')",
                    cancelButtonText: "@lang('messages.confirmNoArchive')",
                    closeOnConfirm: true,
                    closeOnCancel: true
                }, function(isConfirm){
                    if (isConfirm) {

                        var url = "{{ route('admin.employees.assessments.destroy',':id') }}";
                        url = url.replace(':id', id);

                        var token = "{{ csrf_token() }}";

                        $.easyAjax({
                            type: 'POST',
                            url: url,
                            data: {'_token': token, '_method': 'DELETE'},
                            success: function (response) {
                                    $.easyBlockUI('#employees-assessment-table');
                                    loadTable();
                                    $.easyUnblockUI('#employees-assessment-table');
                            }
                        });
                    }
                });
            });

            $('body').on('click', '.assign_role', function(){
                var id = $(this).data('user-id');
                var role = $(this).data('role-id');
                var token = "{{ csrf_token() }}";


                $.easyAjax({
                    url: '{{route('admin.employees.assignRole')}}',
                    type: "POST",
                    data: {role: role, userId: id, _token : token},
                    success: function (response) {
                            $.easyBlockUI('#employees-assessment-table');
                            loadTable();
                            $.easyUnblockUI('#employees-assessment-table');
                    }
                })

            });
        });
        function loadTable(){
            window.LaravelDataTables["employees-assessment-table"].draw();
        }

        $('.toggle-filter').click(function () {
            $('#ticket-filters').toggle('slide');
        })

        $('#apply-filters').click(function () {
            $('#employees-assessment-table').on('preXhr.dt', function (e, settings, data) {
                var employee = $('#employee').val();
                var status   = $('#status').val();
                var percentlargere     = $('#percentlargere').val();
                var percentless     = $('#percentless').val();
                var filter_assessment_name     = $('#filter_assessment_name').val();
                data['employee'] = employee;
                data['status'] = status;
                data['percentlargere'] = percentlargere;
                data['percentless'] = percentless;
                data['filter_assessment_name'] = filter_assessment_name;

            });
            loadTable();
        });

        $('#reset-filters').click(function () {
            $('#filter-form')[0].reset();
            $('#status').val('all');
            $('.select2').val('all');
            $('#filter-form').find('select').select2();
            loadTable();
        })

        function exportData(){

            var employee = $('#employee').val();
            var status   = $('#status').val();
            var role     = $('#role').val();

            var url = '{{ route('admin.employees.export', [':status' ,':employee', ':role']) }}';
            url = url.replace(':role', role);
            url = url.replace(':status', status);
            url = url.replace(':employee', employee);

            window.location.href = url;
        }

    </script>
@endpush
