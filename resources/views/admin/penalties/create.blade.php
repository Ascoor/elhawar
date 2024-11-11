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

            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection

@push('head-script')
    {{--    <link rel="stylesheet" href="{{ asset('public/plugins/metronics/wizard-4.css') }}">--}}
{{--    <link rel="stylesheet" href="{{ asset('plugins/select2/select2.min.css') }}">--}}

    <link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">

    <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/select2.min.css') }}">
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
                <div class="panel-heading"> @lang('modules.members.createPenalty')</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        {!! Form::open(['id'=>'createClient','class'=>'ajax-form','method'=>'POST']) !!}
                        <div class="form-body">
                            <div id="selectClientMember">

                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <label>@lang('app.details')</label>
                                    <div class="form-group">
                                        <textarea name="details" id="details" class="form-control summernote" rows="5"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6" id="suspendMembershipDiv">
                                    <div class="radio radio-info">
                                        <input id="suspend_membership" name="penalty_type" value="@lang('modules.members.suspend_membership')"
                                               type="radio">
                                        <label for="suspend_membership">@lang('modules.members.suspend_membership')</label>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="radio radio-info">
                                        <input id="financial_penalty" name="penalty_type" value="@lang('modules.members.financial_penalty')"
                                               type="radio" checked="checked">
                                        <label for="financial_penalty">@lang('modules.members.financial_penalty')</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="f_member_fields" >
                                <div class="col-xs-6 col-md-3">
                                    <div class="form-group">
                                        <label>@lang('modules.members.amount')</label>
                                        <input type="text" id="amount" name="amount" class="form-control"   value="">
                                    </div>
                                </div>
                                <div class="col-md-3 ">
                                    <div class="form-group salutation">
                                        <label for="">@lang('app.currency')

                                        </label>
                                        <select name="currency" id="currency" data-placeholder="@lang('app.currency')" class="form-control select2 " >
                                            <option id="empty" value="">@lang('--')</option>
                                            @foreach($currencies as $currency)
                                                <option value="{{ $currency->currency_code }}">{{ ucwords($currency->currency_code) }}</option>
                                            @endforeach
                                        </select>
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
    </div>
@endsection
@push('footer-script')


    <script src="{{ asset('plugins/select2/select2.min.js') }}"></script>
    @include("club.select_client_member_script")
    <script src="{{ asset('plugins/bower_components/summernote/dist/summernote.min.js') }}"></script>
    <script>
        $(".select2").select2({
            formatNoMatches: function () {
                return "{{ __('messages.noRecordFound') }}";
            }
        });
        $('#save-form').click(function () {
            $.easyAjax({
                url: '{{route('admin.penalties.store')}}',
                container: '#createClient',
                type: "POST",
                redirect: true,
                data: $('#createClient').serialize()
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
        $('#suspend_membership').change(function () {
            if($(this).is(':checked')){

                $('#f_member_fields').hide();
                $('#amount').prop("value" , "");
                $('#currency').prop("value" , "");
                $('#empty').prop('selected', true);

            }
            // else{
            //     $('#f_member_fields').prop("name" , "session_id");
            // }
        })
        $('#financial_penalty').change(function () {
            if($(this).is(':checked')){
                $('#f_member_fields').show();
                // $('#user_id').prop("name" , "user_id");
            }
        })
        $('#employees_butt').change(function () {
            if($(this).is(':checked')){
                $('#employees').show();
                $('#clients').hide();
                $('#members').hide();

                $('#client_id').prop("name" , "");
                $('#members').prop("name" , "");
                $('#employee_id').prop("name" , "user_id");
            }
            // else{
            //     $('#new_fields').hide();
            //     $('#related_session_id').prop("name" , "session_id");
            // }
        })

         // rolaaaaa
//          if( $('#suspend_membership').is(':checked') ){
//     //alert("Radio Button Is checked!");
//     $('#f_member_fields').hide();
    
// }


    </script>


@endpush
