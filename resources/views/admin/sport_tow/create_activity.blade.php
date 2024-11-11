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
                <div class="panel-heading"> @lang('modules.members.createActivity')</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        {!! Form::open(['id'=>'createClient','class'=>'ajax-form','method'=>'POST']) !!}
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">@lang('modules.members.sport')
                                                <a href="javascript:;" id="sport" class="text-info"><i
                                                            class="ti-settings text-info required"></i> </a>
                                            </label>
                                            <select class="select2 form-control client-category" data-placeholder="@lang('modules.members.sport')"  id="sport_id" name="sport_id">
                                                @forelse($sports as $sport)
                                                    <option value="{{ $sport->id }}">{{ ucwords($sport->name) }}</option>
                                                @empty
                                                    <option value="">@lang('messages.noCategoryAdded')</option>
                                                @endforelse

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">@lang('modules.members.level')
                                                <a href="javascript:;" id="level" class="text-info"><i
                                                            class="ti-settings text-info required"></i> </a>
                                            </label>
                                            <select class="select2 form-control client-category" data-placeholder="@lang('modules.members.level')"  id="level_id" name="level_id">
                                                @forelse($levels as $level)
                                                    <option value="{{ $level->id }}">{{ ucwords($level->name) }}</option>
                                                @empty
                                                    <option value="">@lang('messages.noCategoryAdded')</option>
                                                @endforelse

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">@lang('modules.members.group')
                                                <a href="javascript:;" id="group" class="text-info"><i
                                                            class="ti-settings text-info required"></i> </a>
                                            </label>
                                            <select class="select2 form-control client-category" data-placeholder="@lang('modules.members.group')"  id="group_id" name="group_id">
                                                @forelse($groups as $group)
                                                    <option value="{{ $group->id }}">{{ ucwords($group->name) }}</option>
                                                @empty
                                                    <option value="">@lang('messages.noCategoryAdded')</option>
                                                @endforelse

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">@lang('modules.members.training_location')
                                                <a href="javascript:;" id="location" class="text-info"><i
                                                            class="ti-settings text-info required"></i> </a>
                                            </label>
                                            <select class="select2 form-control client-category" data-placeholder="@lang('modules.members.training_location')"  id="location_id" name="location_id">
                                                @forelse($locations as $location)
                                                    <option value="{{ $location->id }}">{{ ucwords($location->name) }}</option>
                                                @empty
                                                    <option value="">@lang('messages.noCategoryAdded')</option>
                                                @endforelse

                                            </select>
                                        </div>
                                    </div>
                                </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">@lang('modules.members.coach')
                                        <a href="javascript:;" id="coach" class="text-info"><i
                                                    class="text-info required"></i> </a>
                                    </label>
                                    <select class="select2 form-control client-category" data-placeholder="@lang('modules.members.coach')"  id="coach_id" name="coach_id">
                                        @forelse($coaches as $coach)
                                            <option value="{{ $coach->user_id }}">{{ ucwords($coach->user->name) }}</option>
                                        @empty
                                            <option value="">@lang('messages.noCategoryAdded')</option>
                                        @endforelse

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="national_id" class="required">@lang('app.capacity')</label>
                                    <input type="text" id="capacity" name="capacity" class="form-control"   value="">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="national_id" class="required">@lang('app.fees')</label>
                                    <input type="text" id="fees" name="fees" class="form-control"   value="">
                                </div>
                            </div>
                            <div class="col-md-3 ">
                                <div class="form-group salutation">
                                    <label class="required" for="">@lang('app.currency')

                                    </label>
                                    <select name="currency" id="training_days" data-placeholder="@lang('app.currency')" class="form-control select2 " >
                                        @foreach($currencies as $currency)
                                            <option value="{{ $currency->currency_code }}">{{ ucwords($currency->currency_code) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

{{--                        <div class="row">--}}
{{--                                    <div class="col-md-3 ">--}}
{{--                                        <div class="form-group salutation" >--}}
{{--                                            <label class="required" for="">@lang('modules.members.training_days')--}}

{{--                                            </label>--}}
{{--                                            <select name="{{'training_days[]'}}" id="training_days" data-placeholder="@lang('modules.members.choose_days')" class="form-control select2 " multiple>--}}
{{--                                                <option value="saturday">@lang('app.saturday')</option>--}}
{{--                                                <option  value="sunday">@lang('app.sunday')</option>--}}
{{--                                                <option   value="monday">@lang('app.monday')</option>--}}
{{--                                                <option   value="tuesday">@lang('app.tuesday')</option>--}}
{{--                                                <option  value="wednesday">@lang('app.wednesday')</option>--}}
{{--                                                <option  value="thursday">@lang('app.thursday')</option>--}}
{{--                                                <option  value="friday">@lang('app.friday')</option>--}}

{{--                                            </select>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                        <div class="col-md-3">--}}
{{--                                            <div class="input-group  bootstrap-timepicker timepicker">--}}
{{--                                                <label>@lang('modules.timeLogs.startTime')</label>--}}
{{--                                                <input type="text" name="{{'start_time[]'}}" id="start_time"--}}
{{--                                                       class="form-control">--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-3">--}}
{{--                                            <div class="input-group bootstrap-timepicker timepicker">--}}
{{--                                                <label>@lang('modules.timeLogs.endTime')</label>--}}
{{--                                                <input type="text" name="{{'end_time[]'}}" id="end_time"--}}
{{--                                                       class="form-control">--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-3">--}}
{{--                                            <label for="">@lang('modules.timeLogs.totalHours')</label>--}}

{{--                                            <p id="total_time" class="form-control-static">0 Hrs</p>--}}
{{--                                        </div>--}}
{{--                    </div>--}}

                            <div id="sortable">
                                <div class="row">
                                    <div class="col-md-3 ">
                                        <div class="form-group salutation" >
                                            <label class="required" for="">@lang('modules.members.training_days')

                                            </label>
                                            <select name="{{'training_days[]'}}" id="training_days" data-placeholder="@lang('modules.members.choose_days')" class="form-control select2 " >
                                                <option value="saturday">@lang('app.saturday')</option>
                                                <option  value="sunday">@lang('app.sunday')</option>
                                                <option   value="monday">@lang('app.monday')</option>
                                                <option   value="tuesday">@lang('app.tuesday')</option>
                                                <option  value="wednesday">@lang('app.wednesday')</option>
                                                <option  value="thursday">@lang('app.thursday')</option>
                                                <option  value="friday">@lang('app.friday')</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group  bootstrap-timepicker timepicker">
                                            <label>@lang('modules.timeLogs.startTime')</label>
                                            <input type="text" name="{{'start_time[]'}}" id="start_time"
                                                   class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group bootstrap-timepicker timepicker">
                                            <label>@lang('modules.timeLogs.endTime')</label>
                                            <input type="text" name="{{'end_time[]'}}" id="end_time"
                                                   class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">@lang('modules.timeLogs.totalHours')</label>

                                        <p id="total_time" class="form-control-static">0 Hrs</p>
                                    </div>

                                </div>

                            </div>
                                    <div class="col-md-1" style="padding: 8px 15px">
                                        &nbsp;
                                    </div>


                                <div class="col-xs-12 m-t-5">
                                    <button type="button" class="btn btn-info" id="add-item"><i class="fa fa-plus"></i> @lang('modules.invoices.addItem')</button>
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
            url: '{{route('admin.sportActivity.store')}}',
            container: '#createClient',
            type: "POST",
            redirect: true,
            data: $('#createClient').serialize()

        })
    });


    $('#sport').click(function () {
        var url = '{{ route('admin.sportAcademy.create')}}';
        $('#modelHeading').html('...');
        $.ajaxModal('#clientCategoryModal', url);
    })
    $('#level').click(function () {
        var url = '{{ route('admin.level.create')}}';
        $('#modelHeading').html('...');
        $.ajaxModal('#clientCategoryModal', url);
    })
    $('#group').click(function () {
        var url = '{{ route('admin.playerGroup.create')}}';
        $('#modelHeading').html('...');
        $.ajaxModal('#clientCategoryModal', url);
    })
    $('#location').click(function () {
        var url = '{{ route('admin.location.create')}}';
        $('#modelHeading').html('...');
        $.ajaxModal('#clientCategoryModal', url);
    })

    $('#start_time, #end_time').timepicker({
        @if($global->time_format == 'H:i')
        showMeridian: false
        @endif
    }).on('hide.timepicker', function (e) {
        calculateTime();
    });


    function calculateTime() {
        var format = '{{ $global->moment_format }}';
        var startDate = {{\Carbon\Carbon::today()->format($global->date_format)}};
        var endDate = {{\Carbon\Carbon::today()->format($global->date_format)}};
        var startTime = $("#start_time").val();
        var endTime = $("#end_time").val();

        startDate = moment(startDate, format).format('YYYY-MM-DD');
        endDate = moment(endDate, format).format('YYYY-MM-DD');

        var timeStart = new Date(startDate + " " + startTime);
        var timeEnd = new Date(endDate + " " + endTime);

        var diff = (timeEnd - timeStart) / 60000; //dividing by seconds and milliseconds

        var minutes = diff % 60;
        var hours = (diff - minutes) / 60;

        if (hours < 0 || minutes < 0) {
            var numberOfDaysToAdd = 1;
            timeEnd.setDate(timeEnd.getDate() + numberOfDaysToAdd);
            var dd = timeEnd.getDate();

            if (dd < 10) {
                dd = "0" + dd;
            }

            var mm = timeEnd.getMonth() + 1;

            if (mm < 10) {
                mm = "0" + mm;
            }

            var y = timeEnd.getFullYear();

//            $('#end_date').val(mm + '/' + dd + '/' + y);
            calculateTime();
        } else {
            $('#total_time').html(hours + "Hrs " + minutes + "Mins");
        }

//        console.log(hours+" "+minutes);
    }
    $('#add-item').click(function () {
        var i = $(document).find('.training_days').length;
        var item = '<div class="row item-row">'

            +'<div class="col-md-3 ">'
            +'<div class="form-group salutation" >'
            +'<label class="required" for="">@lang('modules.members.training_days')'

            +'</label>'
           +'<select name="{{'training_days[]'}}" id="training_days" data-placeholder="@lang('modules.members.choose_days')" class="form-control select2 ">'
                +'<option value="saturday">@lang('app.saturday')</option>'
                +'<option  value="sunday">@lang('app.sunday')</option>'
                +'<option   value="monday">@lang('app.monday')</option>'
                +'<option   value="tuesday">@lang('app.tuesday')</option>'
                +'<option  value="wednesday">@lang('app.wednesday')</option>'
                +'<option  value="thursday">@lang('app.thursday')</option>'
                +'<option  value="friday">@lang('app.friday')</option>'

            +'</select>'
    +'</div>'
    +'</div>'
            +' <div class="col-md-3">'
            +'<div class="input-group  bootstrap-timepicker timepicker">'
            +'<label>@lang('modules.timeLogs.startTime')</label>'
            +'<input type="text" name="{{'start_time[]'}}" id="start_time"'
            +'class="form-control">'
            +'</div>'
    +'</div>'
        +'<div class="col-md-3">'
           +'<div class="input-group bootstrap-timepicker timepicker">'
                +'<label>@lang('modules.timeLogs.endTime')</label>'
                +'<input type="text" name="{{'end_time[]'}}" id="end_time"'
                       +'class="form-control">'
            +'</div>'
        +'</div>'
        +'<div class="col-md-1">'
            +'<label for="">@lang('modules.timeLogs.totalHours')</label>'

           +'<p id="total_time" class="form-control-static">0 Hrs</p>'
        +'</div>'

            +'<div class="col-md-1 text-right visible-md visible-lg">'
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
        hsnSacColumn();
    });

    hsnSacColumn();
    function hsnSacColumn(){
        @if($invoiceSetting->hsn_sac_code_show)
        $('input[name="item_name[]"]').parent("div").parent('div').parent('div').parent('div').removeClass( "col-md-4");
        $('input[name="item_name[]"]').parent("div").parent('div').parent('div').parent('div').addClass( "col-md-3");
        $('input[name="hsn_sac_code[]"]').parent("div").parent('div').show();
        @else
        $('input[name="hsn_sac_code[]"]').parent("div").parent('div').hide();
        $('input[name="item_name[]"]').parent("div").parent('div').parent('div').parent('div').removeClass( "col-md-3");
        $('input[name="item_name[]"]').parent("div").parent('div').parent('div').parent('div').addClass( "col-md-4");
        @endif
    }
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
</script>
@endpush

