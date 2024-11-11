@extends('layouts.app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 bg-title-left">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __('app.menu.add_member_player') }}</h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12 bg-title-right">
            <ol class="breadcrumb">
{{--                <li><a href="{{ route('admin.dashboard') }}">@lang('app.menu.home')</a></li>--}}
{{--                <li><a href="{{ route('admin.members.index') }}">{{ __($pageTitle) }}</a></li>--}}
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
            {!! Form::open(['id'=>'updateMember','class'=>'ajax-form','method'=>'GET']) !!}

            <div class="panel panel-inverse">
                <div class="panel-heading"> @lang('app.menu.create_player')</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <input type="hidden" name="player" value="1">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="required" for="">@lang('app.member_id')
                                    </label>
                                    <input type="text" id="member_id" name="member_id" class="form-control" value="">
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                                <button type="submit" id="save-form"  class="btn btn-success"> <i class="fa fa-plus"></i> @lang('modules.club.add_player')</button>

                            </div>
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}

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

            <script>




    $(".select2").select2({
        formatNoMatches: function () {
            return "{{ __('messages.noRecordFound') }}";
        }
    });


    $('#save-form').click(function () {
        var member_id=$('#member_id').val();
        var url='{{route('admin.players.redirectToEdit' , ':member_id')}}';
            url = url.replace(':member_id', member_id);
        // window.location =url;
        $.easyAjax({
            url: url,
            // container: '#updateEmployee',
            type: "GET",
            redirect: true,
            data: $('#updateMember').serialize()

        })

    });
</script>
    @endpush
