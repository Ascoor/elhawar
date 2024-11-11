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
                <div class="panel-heading"> @lang('modules.members.editCase')</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        {!! Form::open(['id'=>'createClient','class'=>'ajax-form','method'=>'PUT']) !!}
                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="national_id" class="required">@lang('modules.members.case_name')</label>
                                    <input type="text" id="case_name" name="case_name" class="form-control"   value="{{$case->case_name}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="national_id" class="required">@lang('modules.members.case_id')</label>
                                    <input type="text" id="case_id" name="case_id" class="form-control"   value="{{$case->case_id}}">
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="row">
                                <div class="col-xs-12">
                                    <label>@lang('app.details')</label>
                                    <div class="form-group">
                                        <textarea name="details" id="details" class="form-control summernote" rows="5">{!! $case->details !!}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>


{{--                        <div id="sortable">--}}
{{--                            <div class="row">--}}
{{--                                @foreach(json_decode($case->lawyers) as $lawyer)--}}
{{--                                <div class="col-md-3">--}}
{{--                                    <div class="form-group">--}}
{{--                                        <label for="national_id" class="required">@lang('modules.members.lawyer')</label>--}}
{{--                                        <input type="text" id="lawyer" name="{{'lawyers[]'}}" class="form-control"   value="{{$lawyer}}">--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                @endforeach--}}
{{--                                @foreach(json_decode($case->opponents) as $opponent)--}}
{{--                                <div class="col-md-3">--}}
{{--                                    <div class="form-group">--}}
{{--                                        <label for="national_id" class="required">@lang('modules.members.opponent')</label>--}}
{{--                                        <input type="text" id="opponent" name="{{'opponents[]'}}" class="form-control"   value="{{$opponent}}">--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                @endforeach--}}

{{--                            </div>--}}

{{--                        </div>--}}
                        <div id="sortable">
                            <div class="row">
                                @foreach(json_decode($case->lawyers) as $lawyer)
                                    <div class="item-row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="national_id" class="required">@lang('modules.members.lawyer')</label>
                                            <input type="text" id="lawyer" name="{{'lawyers[]'}}" class="form-control"   value="{{$lawyer}}">
                                        </div>
                                    </div>
                                    <div class="col-md-1 text-left visible-md visible-lg">
                                        <button type="button" class="btn remove-item btn-circle btn-danger"><i class="fa fa-remove"></i></button>
                                        </div>

                                    <div class="col-md-1 hidden-md hidden-lg">
                                            <button type="button" class="btn remove-item btn-danger"><i class="fa fa-remove"></i> @lang('app.remove')</button>
                                     </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-xs-12 m-t-5">
                            <button type="button" class="btn btn-info" id="add-item"><i class="fa fa-plus"></i> @lang('modules.members.addLawyer')</button>
                        </div>
                        <div id="sortable_2" style="padding-top: 100px">
                            <div class="row">
                                @foreach(json_decode($case->opponents) as $opponent)
                                    <div class="item-row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="national_id" class="required">@lang('modules.members.opponent')</label>
                                            <input type="text" id="opponent" name="{{'opponents[]'}}" class="form-control"   value="{{$opponent}}">
                                        </div>
                                    </div>
                                        <div class="col-md-1 text-left visible-md visible-lg">
                                            <button type="button" class="btn remove-item btn-circle btn-danger"><i class="fa fa-remove"></i></button>
                                        </div>

                                        <div class="col-md-1 hidden-md hidden-lg">
                                            <button type="button" class="btn remove-item btn-danger"><i class="fa fa-remove"></i> @lang('app.remove')</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-xs-12 m-t-5">
                            <button type="button" class="btn btn-info" id="add-opponent"><i class="fa fa-plus"></i> @lang('modules.members.addOpponent')</button>
                        </div>

                        <div class="col-md-1" style="padding: 8px 15px">
                            &nbsp;
                        </div>


{{--                        <div class="col-xs-12 m-t-5">--}}
{{--                            <button type="button" class="btn btn-info" id="add-item"><i class="fa fa-plus"></i> @lang('modules.members.addMore')</button>--}}
{{--                        </div>--}}



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
                url: '{{route('admin.cases.update' , $case->id)}}',
                container: '#createClient',
                type: "PUT",
                redirect: true,
                data: $('#createClient').serialize()

            })
        });






        {{--$('#add-item').click(function () {--}}
        {{--    var i = $(document).find('.training_days').length;--}}
        {{--    var item = '<div class="row item-row">'--}}

        {{--        +'<div class="col-md-3">'--}}
        {{--        +'<div class="form-group">'--}}
        {{--        +'<label for="national_id" class="required">@lang('modules.members.lawyer')</label>'--}}
        {{--        +'<input type="text" id="lawyer" name="{{'lawyers[]'}}" class="form-control"   value="">'--}}
        {{--        +'</div>'--}}
        {{--        +'</div>'--}}
        {{--        +'<div class="col-md-3">'--}}
        {{--        +'<div class="form-group">'--}}
        {{--        +     '<label for="national_id" class="required">@lang('modules.members.opponent')</label>'--}}
        {{--        +      '<input type="text" id="opponent" name="{{'opponents[]'}}" class="form-control"   value="">'--}}
        {{--        +   '</div>'--}}
        {{--        +'</div>'--}}
        {{--        +'<div class="col-md-1 text-right visible-md visible-lg">'--}}
        {{--        +'<button type="button" class="btn remove-item btn-circle btn-danger"><i class="fa fa-remove"></i></button>'--}}
        {{--        +'</div>'--}}

        {{--        +'<div class="col-md-1 hidden-md hidden-lg">'--}}
        {{--        // +'<div class="row">'--}}
        {{--        +'<button type="button" class="btn remove-item btn-danger"><i class="fa fa-remove"></i> @lang('app.remove')</button>'--}}
        {{--        // +'</div>'--}}
        {{--        +'</div>'--}}
        {{--        +'</div>';--}}

        {{--    $(item).hide().appendTo("#sortable").fadeIn(500);--}}
        {{--    $('#multiselect'+i).selectpicker();--}}
        {{--});--}}
        $('#add-item').click(function () {
            var i = $(document).find('.training_days').length;
            var item = '<div class="row item-row">'

                +'<div class="col-md-3">'
                +'<div class="form-group">'
                +'<label for="national_id" class="required">@lang('modules.members.lawyer')</label>'
                +'<input type="text" id="lawyer" name="{{'lawyers[]'}}" class="form-control"   value="">'
                +'</div>'
                +'</div>'

                +'<div class="col-md-1 text-left visible-md visible-lg">'
                +'<button type="button" class="btn remove-item btn-circle btn-danger"><i class="fa fa-remove"></i></button>'
                +'</div>'

                +'<div class="col-md-1 hidden-md hidden-lg">'
                // +'<div class="row">'
                +'<button type="button" class="btn remove-item btn-danger"><i class="fa fa-remove"></i> @lang('app.remove')</button>'
                // +'</div>'
                +'</div>'
                +'</div>';

            $(item).hide().appendTo("#sortable").fadeIn(500);
            $('#multiselect'+i).selectpicker();
        });

        $('#add-opponent').click(function () {
            var i = $(document).find('.training_days').length;
            var item = '<div class="row item-row">'


                +'<div class="col-md-3">'
                +'<div class="form-group">'
                +     '<label for="national_id" class="required">@lang('modules.members.opponent')</label>'
                +      '<input type="text" id="opponent" name="{{'opponents[]'}}" class="form-control"   value="">'
                +   '</div>'
                +'</div>'
                +'<div class="col-md-1 text-left visible-md visible-lg">'
                +'<button type="button" class="btn remove-item btn-circle btn-danger"><i class="fa fa-remove"></i></button>'
                +'</div>'

                +'<div class="col-md-1 hidden-md hidden-lg">'
                // +'<div class="row">'
                +'<button type="button" class="btn remove-item btn-danger"><i class="fa fa-remove"></i> @lang('app.remove')</button>'
                // +'</div>'
                +'</div>'
                +'</div>';

            $(item).hide().appendTo("#sortable_2").fadeIn(500);
            $('#multiselect'+i).selectpicker();
        });

        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

        $('.js-switch').each(function () {
            new Switchery($(this)[0], $(this).data());

        });
        $('#createClient').on('click','.remove-item', function () {
            $(this).closest('.item-row').fadeOut(300, function() {
                $(this).remove();
                calculateTotal();
            });
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
    </script>
@endpush

