@extends('layouts.app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 bg-title-left">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __($pageTitle) }}</h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12 bg-title-right">
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}">@lang('app.menu.home')</a></li>
                <li><a href="{{ route('admin.members.index') }}">{{ __($pageTitle) }}</a></li>
                <li class="active">@lang('app.addNew')</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection

@push('head-script')
    {{--    <link rel="stylesheet" href="{{ asset('public/plugins/metronics/wizard-4.css') }}">--}}

    <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/summernote/dist/summernote.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/timepicker/bootstrap-timepicker.min.css') }}">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/daterange-picker/daterangepicker.css') }}" />
    <style>
        .salutation .form-control {
            padding: 2px 2px;
        }
        .select-category button{
            background-color: white !important;
            font-size: 13px;
            color: #565656;
            border: 1px solid #e4e7ea !important;
        }
        .select-category button:hover{
            color: #565656;
            opacity: 1;
        }

        .bootstrap-select .dropdown-toggle:focus{
            outline: none !important;
        }
    </style>

@endpush

@section('content')

    <div class="row">
        <div class="col-xs-12">

            <div class="panel panel-inverse">
                <div class="panel-heading"> @lang('modules.members.createTeam')</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        {!! Form::open(['id'=>'createClient','class'=>'ajax-form','method'=>'POST']) !!}
                        <div class="row">
                            <div class="col-md-3 ">
                                <div class="form-group">
                                    <label class="required">@lang('modules.members.teamName')</label>
                                    <input type="text" name="team_name" id="team_name" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">@lang('modules.members.sport')
                                        <a href="javascript:;" id="sport" class="text-info"><i
                                                    class="ti-settings text-info required"></i> </a>
                                    </label>
                                    <select class="select2 form-control client-category" data-placeholder="@lang('modules.members.sport')"  id="sport_id" name="sport_id">
                                        @forelse($sports as $sport)
                                            <option value="{{ $sport->id }}">
                                                
                                                {{-- {{ ucwords($sport->name) }} --}}
                                            {{-- ROLA --}}
                                                {{-- translating the options --}}
                                                @lang('app.'.$sport->name) 
                                                
                                            </option>

                                        @empty
                                            <option value="">@lang('messages.noCategoryAdded')</option>
                                        @endforelse

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">@lang('modules.members.coach')
                                        <a href="javascript:;" id="coach" class="text-info"><i
                                                    class="text-info required"></i> </a>
                                    </label>
                                    <select class="select2 m-b-10 select2-multiple" data-placeholder="@lang('modules.members.coach')"  id="coach_id" name="{{'coach_id[]'}}" multiple="multiple">
                                        @forelse($coaches as $coach)
                                            <option value="{{ $coach->id }}">{{ ucwords($coach->user->name) }}</option>
                                        @empty
                                            <option value="">@lang('messages.noCoachAdded')</option>
                                        @endforelse

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="from_age" class="required">@lang('modules.members.from_age')</label>
                                    <input type="text" id="from_age" name="from_age" class="form-control"   value="">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="to_age" class="required">@lang('modules.members.to_age')</label>
                                    <input type="text" id="to_age" name="to_age" class="form-control"   value="">
                                </div>
                            </div>

                        </div>






                    </div>

                    <div class="form-actions">
                        <button type="submit" id="save-form"  class="btn btn-success"> <i class="fa fa-check"></i> @lang('app.save')</button>

                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    {{--    </div>    <!-- .row -->--}}
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
    <script src="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/summernote/dist/summernote.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/timepicker/bootstrap-timepicker.min.js') }}"></script>

    <script src="{{ asset('plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script>
    <script src="{{ asset('plugins/bower_components/moment/moment.js') }}"></script>

    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('js/datatables/buttons.server-side.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/moment/moment.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/daterange-picker/daterangepicker.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/switchery/dist/switchery.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/select2.min.js') }}"></script>


    <script>
        function checkboxChange(parentClass, id){
            var checkedData = '';
            $('.'+parentClass).find("input[type= 'checkbox']:checked").each(function () {
                if(checkedData !== ''){
                    checkedData = checkedData+', '+$(this).val();
                }
                else{
                    checkedData = $(this).val();
                }
            });
            $('#'+id).val(checkedData);
        }

        $(".select2").select2({
            formatNoMatches: function () {
                return "{{ __('messages.noRecordFound') }}";
            }
        });


        $('#save-form').click(function () {
            $.easyAjax({
                url: '{{route('admin.sportsTeams.store')}}',
                container: '#createClient',
                type: "POST",
                redirect: true,
                data: $('#createClient').serialize()

            })
        });


        $('#sport').click(function () {
            var url = '{{ route('admin.sports.create')}}';
            $('#modelHeading').html('...');
            $.ajaxModal('#clientCategoryModal', url);
        })



    </script>
@endpush

