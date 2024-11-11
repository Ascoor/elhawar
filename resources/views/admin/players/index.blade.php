@extends('layouts.app')

@section('page-title')
<div class="row bg-title">

    <!-- .page title -->
    <div class="col-lg-8 col-md-5 col-sm-6 col-xs-12 bg-title-left">
        <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __('modules.club.players') }}
            <span class="text-info b-l p-l-10 m-l-5">{{ $totalmembers }}</span> <span
                class="font-12 text-muted m-l-5"> @lang('modules.club.totalPlayers')</span>
        </h4>
    </div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-4 col-sm-6 col-md-7 col-xs-12 text-right bg-title-right">

        <a href="{{ route('admin.players.create') }}"
           class="btn btn-outline btn-success btn-sm">@lang('app.menu.create_player') <i class="fa fa-plus"
                                                                                              aria-hidden="true"></i></a>

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
            <div class="form-group">
                <h5 >@lang('app.member_id')</h5>

                <input type="text" id="member" name="member" class="form-control" value="">

            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <h5>@lang('modules.club.team')</h5>
                <select class="form-control select2" name="team_id" id="team_id"
                        data-style="form-control">
                    <option value="all">@lang('modules.client.all')</option>
                    @foreach($teams as $team)
                        <option value="{{$team->id}}">{{ ucwords($team->team_name) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
       
        <div class="col-md-12">
            <div class="form-group">
                <h5>@lang('app.mobile')</h5>
                <input type="text" id="mobile" name="mobile" class="form-control" value="">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <h5>@lang('app.player_id')</h5>
                <input type="text" id="player_id" name="player_id" class="form-control" value="">

            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <h5>@lang('modules.stripeCustomerAddress.country')</h5>
                <select class="form-control select2" name="country_id" id="country_id"
                        data-style="form-control">
                    <option value="all">@lang('modules.client.all')</option>
                    @foreach($countries as $country)
                    <option value="{{$country->id}}">{{ $country->nicename }}</option>
                    @endforeach
                </select>
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

    $(".select2").select2({
        formatNoMatches: function () {
            return "{{ __('messages.noRecordFound') }}";
        }
    });

    var table;
    $(function () {
        $('body').on('click', '.sa-params', function () {
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

                    var url = "{{ route('admin.players.destroy',':id') }}";
                    url = url.replace(':id', id);

                    var token = "{{ csrf_token() }}";

                    $.easyAjax({
                        type: 'POST',
                        url: url,
                        data: {'_token': token, '_method': 'DELETE'},
                        success: function (response) {
                            if (response.status == "success") {
                                $.easyBlockUI('#members-table');
                                window.LaravelDataTables["members-table"].draw();
                                $.easyUnblockUI('#members-table');
                            }
                        }
                    });
                }
            });
        });

    });

    $('.toggle-filter').click(function () {
        $('#ticket-filters').toggle('slide');
    })

    $('#apply-filters').click(function () {
        $('#players-table').on('preXhr.dt', function (e, settings, data) {
            var startDate = $('#start-date').val();

            if (startDate == '') {
                startDate = null;
            }

            var endDate = $('#end-date').val();

            if (endDate == '') {
                endDate = null;
            }
            var player_id = $('#player_id').val();
            // var sub_category_id = $('#sub_category_id').val();
            var union_id = $('#union_id').val();
            var name = $('#name').val();
            var national_id = $('#national_id').val();
            var atu_sport = $('#sports_id').val();
            var atu_acadmy = $('#academy_id').val();
            var team_id = $('#team_id').val();
            var gender = $('#gender').val();
            var date_of_birth = $('#date_of_birth').val();
            var date_status = $('#date_status').val();
            var age = $('#age').val();
            var city = $('#city').val();
            var country_id = $('#country_id').val();
            var kind = $('#kind').val();
            var status_player = $('#status_player').val();
            var club_name = $('#club_name').val();
            var champions_award = $('#champions_award').val();
            var address = $('#address').val();
            var mobile = $('#mobile').val();
            var guardian_mobile = $('#guardian_mobile').val();
            var note = $('#note').val();

            data['startDate'] = startDate;
            data['endDate'] = endDate;
            data['player_id'] = player_id;
            data['union_id'] = union_id;
            data['name']= name;
            data['national_id'] = national_id;
            data['sports_id'] = sports_id;
            data['academy_id'] = academy_id;
            data['team_id'] = team_id;
            data['atu_sport'] = atu_sport;
            data['team_id'] = team_id;
            data['gender'] = gender;
            data['date_of_birth'] = date_of_birth;
            data['date_status'] = date_status;
            data['age'] = age;
            data['city'] = city;
            data['country_id'] = country_id;
            data['kind'] = kind;
            data['status_player'] = status_player;
            data['club_name'] = club_name;
            data['champions_award'] = champions_award;
            data['address'] = address;
            data['mobile'] = mobile;
            data['guardian_mobile'] = guardian_mobile;
            data['note'] = note;

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