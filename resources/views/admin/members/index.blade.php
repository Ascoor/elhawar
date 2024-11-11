@extends('layouts.app')

@section('page-title')

  

{{-- <div class="row bg-title">--}}

    {{--
    <!-- .page title -->--}}
    {{-- <div class="col-lg-8 col-md-5 col-sm-6 col-xs-12 bg-title-left">--}}
        {{-- <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __($pageTitle) }}--}}
            {{-- <span class="text-info b-l p-l-10 m-l-5">{{ $totalmembers }}</span>
            <span--}} {{-- class="font-12 text-muted m-l-5"> @lang('modules.dashboard.totalMembers')</span>--}}
                {{--
        </h4>--}}
        {{-- </div>--}}
    {{--
    <!-- /.page title -->--}}

    {{--
    <!-- .breadcrumb -->--}}
    {{-- <div class="col-lg-4 col-sm-6 col-md-7 col-xs-12 text-right bg-title-right">--}}
        {{-- <a href="{{ route('admin.members.create') }}" --}} {{--
            class="btn btn-outline btn-success btn-sm">@lang('modules.members.addNewMember') <i class="fa fa-plus" --}}
                {{-- aria-hidden="true"></i></a>--}}
        {{-- <a href="{{ route('admin.members.add_to_family') }}" --}} {{--
            class="btn btn-outline btn-success btn-sm">@lang('modules.members.add_to_family') <i class="fa fa-plus" --}}
                {{-- aria-hidden="true"></i></a>--}}
        {{-- <form action="{{route('admin.members.file-import')}}" method="POST" enctype="multipart/form-data">--}}
            {{-- @csrf--}}
            {{-- <div class="form-group ">--}}
                {{-- <div class="custom-file text-left">--}}

                    {{-- <input type="file" name="file" class="btn btn-outline btn-success btn-sm" id="customFile">--}}
                    {{-- <button class="btn btn-info btn-file fa fa-upload" type="submit"
                        id="save-form">@lang('modules.members.importMembers')</button>--}}
                    {{-- </div>--}}
                {{-- </div>--}}
            {{-- </form>--}}


        {{-- <ol class="breadcrumb">--}}

            {{-- <li><a href="{{ route('admin.dashboard') }}">@lang('app.menu.home')</a></li>--}}
            {{-- <li class="active">{{ __($pageTitle) }}</li>--}}
            {{-- </ol>--}}
        {{-- </div>--}}
    {{--
    <!-- /.breadcrumb -->--}}
    {{--
</div>--}}
<div class="row bg-title">
    <!-- .page title -->
    {{------------ Title page إجمالي عدد الأعضاء ---------------}}
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 bg-title-left">

        <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __($pageTitle) }}
            <span class="text-info b-l p-l-10 m-l-5">{{ $totalmembers }}</span> <span class="font-12 text-muted m-l-5">
                @lang('modules.dashboard.totalMembers')</span>
        </h4>

    </div>
      {{-- rola  --}}
    {{--  added the launages setting" --}} 
    <div class="col-lg-3 col-sm-8 col-md-8 col-xs-12 text-right bg-title-right">
    @include('admin.dashboard-header.header_others')
    </div>

    <div class="col-lg-3 col-sm-8 col-md-8 col-xs-12 text-right bg-title-right">
        {{-- Button at the top right to add new member --}}
        <a href="{{ route('admin.members.create') }}"
            class="btn btn-outline btn-success btn-sm">@lang('modules.members.addNewMember') <i class="fa fa-plus"
                aria-hidden="true"></i></a>

        {{-- Button at the top right to add to the family --}}
        <a href="{{ route('admin.members.add_to_family') }}"
            class="btn btn-outline btn-success btn-sm">@lang('modules.members.add_to_family') <i class="fa fa-plus"
                aria-hidden="true"></i></a>


        {{-- Button at the top right to import --}}
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}">@lang('app.menu.stocks')</a></li>
            <li class="active">{{ __($pageTitle) }}</li>


        </ol>
    </div>

    {{-- IMPORT MEMBERS button --}}
    <div class="col-lg-12">
        <form action="{{route('admin.members.file-import')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" class="btn btn-outline btn-success btn-sm" id="customFile">
            <button class="btn btn-info btn-file fa fa-upload " type="submit"
                id="save-form">@lang('modules.members.importMembers')</button>
        </form>
    </div>

    <!-- /.page title -->
    <!-- .breadcrumb -->
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
<div class="row" id="ticket-filters">
    {{-------- collapsible container in the middle --}}
    <form action="" id="filter-form">
        <div class="col-xs-12">
            <h5>@lang('app.selectDateRange')</h5>
            <div class="form-group">
                <div id="reportrange" class="form-control reportrange">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span></span> <i class="fa fa-caret-down pull-right"></i>
                </div>

                <input type="hidden" class="form-control" id="start-date" placeholder="@lang('app.startDate')"
                    value="" />
                <input type="hidden" class="form-control" id="end-date" placeholder="@lang('app.endDate')" value="" />
            </div>
        </div>

        {{-------- collapsible container in the middle --}}
        {{-- Select Member Age --}}
        <div class="col-xs-12">
            <h5>@lang('app.selectMemberAge')</h5>
            <div class="col-md-6 form-group">
                <select class="select2 form-control client-category" data-placeholder="@lang('app.fromYear')"
                    id="from_year" name="from_year">
                    <option value="0">@lang('app.from')</option>
                    @for($indf=1;$indf<62;$indf++) <option value={{$indf}}>{{$indf}}-@lang('app.year')</option>

                        @endfor
                </select>
            </div>
            <div class="col-md-6 form-group">
                <select class="select2 form-control client-category" data-placeholder="@lang('app.toYear')" id="to_year"
                    name="to_year">
                    <option value="0">@lang('app.to')</option>
                    @for($indt=1;$indt<62;$indt++) <option value={{$indt}}>{{$indt}}-@lang('app.year')</option>

                        @endfor
                </select>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <h5>@lang('modules.members.BirthDate')</h5>
                <input type="text" autocomplete="off" name="date_of_birth" id="date_of_birth" class="form-control"
                    value="">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <h5>@lang('modules.employees.gender')</h5>
                <select name="gender" id="gender" class="form-control">
                    <option value="select">@lang('app.select')</option>
                    <option value="male">@lang('app.male')</option>
                    <option value="female">@lang('app.female')</option>
                </select>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <h5>@lang('app.membership_category')</h5>
                <select class="select2 form-control client-category"
                    data-placeholder="@lang('modules.members.memberCategory')" id="category_id" name="category_id">
                    <option value="all">@lang('modules.client.all')</option>
                    @forelse($categories as $category)
                    <option value="{{ $category->id }}">
                        @lang('app.'.$category->category_name)
                    </option>
                    @empty
                    <option value="">@lang('messages.noCategoryAdded')</option>
                    @endforelse

                </select>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <h5>@lang('app.membership_status')</h5>

                <select class="form-control select2" name="status_id" id="status_id" data-style="form-control">
                    @forelse($status as $state)
                    <option value="{{ $state->id }}">
                        @lang('app.member_status.'.$state->status_name)
                    </option>
                    @empty
                    <option value="">@lang('messages.noCategoryAdded')</option>
                    @endforelse

                </select>
            </div>
        </div>
        <div class="col-md-12 form-group">
            <label for="member">@lang('app.member_id')</label>
            <select class="select2 form-control client-category"
                data-placeholder="@lang('modules.members.choose_member')" id="member" name="member">
                <option value=""></option>
                @foreach($members as $member)
                <option value="{{ $member->member_id}}">{{ ucwords($member->member_id) }} --- {{ ucwords($member->name)
                    }}</option>
                @endforeach

            </select>

        </div>
        {{-- -------}}
        {{-- <div class="col-md-12">
            <div class="form-group">
                <h5>@lang('app.mobile')</h5>
                <select class="select2 form-control client-category" data-placeholder="@lang('app.mobile')" id="phone"
                    name="phone">
                    <option value=""></option>
                    @foreach($members as $member)
                    <option value="{{ $member->phone}}">{{ ucwords($member->phone) }} --- {{ ucwords($member->name) }}
                    </option>
                    @endforeach

                </select>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <h5>@lang('app.national_id')</h5>
                <div class="form-group">
                    <select class="select2 form-control client-category" data-placeholder="@lang('app.national_id')"
                        id="national_id" name="national_id">
                        <option value=""></option>
                        @foreach($members as $member)
                        <option value="{{ $member->national_id}}">{{ ucwords($member->national_id) }} --- {{
                            ucwords($member->name) }}</option>
                        @endforeach

                    </select>
                </div>
            </div>
        </div> --}}


        <!--        <div class="col-md-12">
            <div class="form-group">
                <h5>@lang('app.family_id')</h5>
                <input type="text" id="family_id" name="family_id" class="form-control" value="">

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
        </div>-->


        {{-- APPLY OR REST --}}
        <div class="col-xs-12">
            <div class="form-group p-t-10">
                <button type="button" id="apply-filters" class="btn btn-success col-md-6"><i class="fa fa-check"></i>
                    @lang('app.apply')</button>
                <button type="button" id="reset-filters" class="btn btn-inverse col-md-5 col-md-offset-1"><i
                        class="fa fa-refresh"></i> @lang('app.reset')</button>
            </div>
        </div>

        {{--End collapsible container in the middle --}}
    </form>
</div>
@endsection


@section('content')

{{-- ------------Display the data saved in the database------------- --}}
{{-- {"Law empty hytshal el tiles headers kman"} HEADER COLUM --}}
<div class="row">
    <div class="col-xs-12">
        <div class="white-box">
            <div class="table-responsive">
                {!! $dataTable->table(['class' => 'table table-bordered table-hover toggle-circle default
                footable-loaded footable']) !!}
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
        var subCategories = @json($subcategories);
        $('#category_id').change(function (e) {
            // get projects of selected users
            var opts = '';

            var subCategory = subCategories.filter(function (item) {
                return item.category_id == e.target.value
            });
            subCategory.forEach(project => {
                console.log(project);
            opts += `<option value='${project.id}'>${project.category_name}</option>`
        })

            $('#sub_category_id').html('<option value="0">Select Sub Category...</option>'+opts)
            $("#sub_category_id").select2({
                formatNoMatches: function () {
                    return "{{ __('messages.noRecordFound') }}";
                }
            });
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

                        var url = "{{ route('admin.members.destroy',':id') }}";
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
            $('#members-table').on('preXhr.dt', function (e, settings, data) {
                var startDate = $('#start-date').val();

                if (startDate == '') {
                    startDate = null;
                }

                var endDate = $('#end-date').val();

                if (endDate == '') {
                    endDate = null;
                }
                var category_id = $('#category_id').val();
                var status = $('#status_id').val();
                var age = $('#age').val();
                // var sub_category_id = $('#sub_category_id').val();
                var family_id = $('#family_id').val();
                var country_id = $('#country_id').val();
                var phone = $('#phone').val();
                var to_year = $('#to_year').val();
                var from_year = $('#from_year').val();
                var date_of_birth = $('#date_of_birth').val();
                var gender = $('#gender').val();

                if (date_of_birth == '') {
                    date_of_birth = null;
                }
                var member = $('#member').val();
                data['startDate'] = startDate;
                data['date_of_birth'] = date_of_birth;
                data['gender'] = gender;
                data['endDate'] = endDate;
                data['member'] = member;
                data['status'] = status;
                // data['age'] = age;
                data['note_2'] = note_2;
                data['last_paid_fiscal_year'] = last_paid_fiscal_year;
                data['date_of_the_board_of_directors'] = date_of_the_board_of_directors;
                data['decision_number'] = decision_number;

                data['category_id'] = category_id;
                data['from_year'] = from_year;
                data['to_year'] = to_year;
                // data['sub_category_id'] = sub_category_id;

                data['family_id'] = family_id;
                data['national_id'] = family_id;
                data['country_id'] = country_id;
                data['phone'] = phone;

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
        $("#date_of_birth, .date-picker").datepicker({
            todayHighlight: true,
            autoclose: true,
            weekStart:'{{ $global->week_start }}',
            format: 'yyyy-mm-dd',
        });
</script>
@endpush