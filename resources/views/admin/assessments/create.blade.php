@extends('layouts.app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 bg-title-left">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __('app.menu.assessments') }}</h4>
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
                <div class="panel-heading"> @lang('app.menu.create_assessment')</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        {!! Form::open(['id'=>'updateMember','class'=>'ajax-form','method'=>'POST']) !!}
                        <div class="form-body">
                            <h3 class="box-title ">@lang('modules.members.assessmentDetails')</h3>
                            <hr>


                            <div class="row">
                                <div class="col-md-3 ">
                                    <div class="form-group">
                                        <label >@lang('modules.club.player_membership_id')</label>
                                        <input type="text" name="member_id" id="member_id" value="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3 ">
                                    <div class="form-group">
                                        <label >@lang('app.assessmentName')</label>
                                        <input type="text" name="name" id="name" value="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label >@lang('app.date')</label>
                                        <input type="text" autocomplete="off"  name="at_date" id="at_date" class="form-control">
                                    </div>
                                </div>
                            </div>



                            <div class="row">
                                <div class="col-md-3 ">
                                    <div class="form-group">
                                        <label >@lang('modules.club.injuries')</label>
                                        <input type="text" name="injuries" id="injuries" value="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <label>@lang('modules.club.injuries_effect')</label>
                                    <div class="form-group">
                                        <textarea name="injuries_effect" id="injuries_effect"  class="form-control summernote" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <label>@lang('modules.club.physical_assess')</label>
                                    <div class="form-group">
                                        <textarea name="physical_assess" id="physical_assess" class="form-control summernote" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <label>@lang('modules.club.skills_assess')</label>
                                    <div class="form-group">
                                        <textarea name="skills_assess" id="skills_assess" class="form-control summernote" rows="5"></textarea>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="form-actions">
                            <button type="submit" id="save-form" form="kt_form" class="btn btn-success"> <i class="fa fa-check"></i> @lang('app.save')</button>

                        </div>
                        {!! Form::close() !!}
                        {{--                        </form>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>    <!-- .row -->
    {{--        Ajax Modal--}}
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
    {{--        Ajax Modal Ends--}}
@endsection


@push('footer-script')
    <script src="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/summernote/dist/summernote.min.js') }}"></script>
    {{--<script src="{{ asset('public/plugins/metronics/add-user.js') }}"></script>--}}

    <script>


        $('#save-form').click(function () {
            $.easyAjax({
                url: '{{route('admin.assessments.store', [$user->id])}}',
                container: '#updateEmployee',
                type: "POST",
                redirect: true,
                data: $('#updateMember').serialize()
            })
        });

        $('.summernote').summernote({
            height: 200,                 // set editor height
            minHeight: null,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor
            focus: false,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough']],
                ['fontsize', ['fontsize']],
                ['para', ['ul', 'ol', 'paragraph']],
                ["view", ["fullscreen"]]
            ]
        });
        $("#at_date").datepicker({
            todayHighlight: true,
            autoclose: true,
            weekStart:'{{ $global->week_start }}',
            format: '{{ $global->date_picker_format }}',
        });
        $(".date-picker").datepicker({
            todayHighlight: true,
            autoclose: true,
            weekStart:'{{ $global->week_start }}',
            format: '{{ $global->date_picker_format }}',
        });
    </script>
@endpush

