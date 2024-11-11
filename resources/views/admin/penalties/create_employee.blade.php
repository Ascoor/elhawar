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
{{--
<link rel="stylesheet" href="{{ asset('public/plugins/metronics/wizard-4.css') }}">--}}
{{--
<link rel="stylesheet" href="{{ asset('plugins/select2/select2.min.css') }}">--}}

<link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">

<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/summernote/dist/summernote.css') }}">
<style>
    .salutation .form-control {
        padding: 2px 2px;
    }

    .select-category button {
        background-color: white !important;
        font-size: 13px;
        color: #565656;
        border: 1px solid #e4e7ea !important;
    }

    .select-category button:hover {
        color: #565656;
        opacity: 1;
    }

    .bootstrap-select .dropdown-toggle:focus {
        outline: none !important;
    }
</style>

@endpush

@section('content')

<div class="row">
    <div class="col-xs-12">

        <div class="panel panel-inverse">
            <div class="panel-heading"> @lang('modules.employees.create_employee_penalty')</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    {!! Form::open(['id'=>'createClient','class'=>'ajax-form','method'=>'POST']) !!}
                    
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12" id="employees">
                                <div class="form-group">
                                    <label>@lang('app.employees') </label>
                                    <select name="employee_id" id="employee_id" class="form-control">
                                        <option value="">--</option>
                                        @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ ucwords($employee->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-xs-12">
                                <label>@lang('app.details')</label>
                                <div class="form-group">
                                    <textarea name="details" id="details" class="form-control summernote"
                                        rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <div class="radio radio-info">
                                    <input id="warning" name="penalty_type" value="@lang('modules.employees.warning')"
                                        type="radio" checked="checked">
                                    <label for="warning">@lang('modules.employees.warning')</label>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="radio radio-info">
                                    <input id="draw_attention" name="penalty_type"
                                        value="@lang('modules.employees.draw_attention')" type="radio"
                                        >
                                    <label for="draw_attention">@lang('modules.employees.draw_attention')</label>
                                </div>
                            </div>
                            {{-- rola changed col-xs-3 && added new col --}}
                            <div class="col-xs-3">
                                <div class="radio radio-info">
                                    <input id="deduction_penalty" name="penalty_type"
                                        value="@lang('modules.employees.deduction_penalty')" type="radio"
                                        >
                                    <label for="deduction_penalty">@lang('modules.employees.deduction_penalty')</label>
                                </div>
                            </div>

                            {{-- rola changed col-xs-3 && added new col --}}
                            <div class="col-xs-3">
                                <div class="radio radio-info">
                                    <input id="others_penalty" name="penalty_type"
                                        value="@lang('modules.employees.others_penalty')" type="radio"
                                       >
                                    <label for="others_penalty">@lang('modules.employees.others_penalty')</label>
                                </div>
                            </div>

                        </div>

                        {{-- rola --}}
                        <div class="row d-flex" id="p_deduction_employee">
                            <div class="col-xs-6 col-md-3">
                                <div class="form-group salutation">
                                  
                              <label for="">@lang('modules.employees.duration')

                                    </label>
                                    <select name="duration" id="duration" data-placeholder="@lang('modules.employees.duration')" class="form-control select2 " >
                                        {{-- <option id="empty" value="">@lang('--')</option> --}}
                                        @foreach($durations as $duration)
                                            <option value="{{ $duration->id }}">{{ ucwords($duration->durations) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-6 col-md-3 ">
                                <div class="form-group salutation">
                                    <label for="">@lang('modules.employees.duration')

                                    </label>
                                    <select name="duration" id="duration" data-placeholder="@lang('modules.employees.duration')" class="form-control select2 " >
                                        {{-- <option id="empty" value="">@lang('--')</option> --}}
                                        @foreach($durations as $duration)
                                            <option value="{{ $duration->id }}">{{ ucwords($duration->durations) }}</option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="col-xs-6 col-md-3 ">
                                <div class="form-group salutation">
                                    <label for="">@lang('modules.employees.MonthsDays')

                                    </label>
                                        <select name="MonthsDays" id="MonthsDays" class="form-control select2">
                                            <option value="days">Days</option>
                                            <option value="months">Months</option>
                                        </select>
                                    
                                </div>
                            </div>
                        </div>

                        {{-- rola --}}
                        <div class="row" id="p_others_text_employee">
                            <div class="col-xs-6 col-md-3">
                                <div class="form-group">
                                    <label>@lang('modules.employees.others_text')</label>
                                    <input type="text" id="others_text" name="others_text" class="form-control" value="">
                                </div>
                            </div>
                           
                        </div>



</div>
                    <div class="form-actions">
                        <button type="submit" id="save-form" class="btn btn-success"> <i class="fa fa-check"></i>
                            @lang('app.save')</button>

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
<script src="{{ asset('plugins/bower_components/summernote/dist/summernote.min.js') }}"></script>
<script>

    // 
$('#warning').change(function () {
            if($(this).is(':checked')){

                $('#p_others_text_employee').hide();
                $('#p_deduction_employee').hide();
                // $('#amount').prop("value" , "");
                // $('#currency').prop("value" , "");
                // $('#empty').prop('selected', true);

            }
           
        })

    // rolaaaaa
        if( $('#warning').is(':checked') ){
    //alert("Radio Button Is checked!");
    $('#p_others_text_employee').hide();
                $('#p_deduction_employee').hide();
    
}



$('#draw_attention').change(function () {
            if($(this).is(':checked')){

                $('#p_others_text_employee').hide();
                $('#p_deduction_employee').hide();

                // $('#amount').prop("value" , "");
                // $('#currency').prop("value" , "");
                // $('#empty').prop('selected', true);

            }
           
        })
          


$('#others_penalty').change(function() {
      if ($(this).is(":checked")) {
            $("#p_others_text_employee").show();
            $('#p_deduction_employee').hide();
      } 
});


$('#deduction_penalty').change(function() {
      if ($("#deduction_penalty").is(":checked")) {
            $("#p_others_text_employee").hide();
            $('#p_deduction_employee').show();

            
      } 
});

// $('#deduction_penalty').click(function () {
//             if($(this).is(':checked')){
//                 $('#p_deduction_employee').show();
//             $("#p_others_text_employee").hide();

//             }
//         })

        $(".select2").select2({
            formatNoMatches: function () {
                return "{{ __('messages.noRecordFound') }}";
            }
        });
        $('#save-form').click(function () {
            $.easyAjax({
                url: '{{route('admin.penalties.store-employee-penalty')}}',
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


        


</script>


@endpush