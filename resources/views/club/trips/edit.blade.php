

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title"><i class="icon-pencil"></i> @lang('app.edit') @lang('app.menu.Events')</h4>
</div>
<div class="modal-body">
    {!! Form::open(['id'=>'updateEvent','class'=>'ajax-form','method'=>'PUT']) !!}
    <div class="form-body">
        <div class="row">
            <div class="col-md-5 ">
                <div class="form-group">
                    <label>@lang('modules.club.tripName')</label>
                    <input type="text" name="trip_name" id="trip_name" value="{{ $trip->trip_name }}" class="form-control">
                </div>
            </div>

            <div class="col-md-1 ">
                <div class="form-group">
                    <label>@lang('modules.sticky.colors')</label>
                    <select id="edit-colorselector" name="label_color">
                        <option value="bg-info" data-color="#5475ed" @if($trip->label_color == 'bg-info') selected @endif>Blue</option>
                        <option value="bg-warning" data-color="#f1c411" @if($trip->label_color == 'bg-warning') selected @endif>Yellow</option>
                        <option value="bg-purple" data-color="#ab8ce4" @if($trip->label_color == 'bg-purple') selected @endif>Purple</option>
                        <option value="bg-danger" data-color="#ed4040" @if($trip->label_color == 'bg-danger') selected @endif>Red</option>
                        <option value="bg-success" data-color="#00c292" @if($trip->label_color == 'bg-success') selected @endif>Green</option>
                        <option value="bg-inverse" data-color="#4c5667" @if($trip->label_color == 'bg-inverse') selected @endif>Grey</option>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">@lang('modules.club.supervisor')
                    </label>
                    <select class="select2 form-control" data-placeholder="@lang('modules.club.supervisor')"  id="supervisor_id" name="supervisor_id">
                        @foreach($supervisors as $supervisor)
                            <option value="{{ $supervisor->user_id }}">{{ ucwords($supervisor->user->name) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
            <div class="row">

                <div class="col-md-3 ">
                    <div class="form-group">
                        <label>@lang('modules.members.member_fees')</label>
                        <input type="text" name="member_fees" value="{{ $trip->member_fees }}" id="member_fees" class="form-control">
                    </div>
                </div>
                <div class="col-md-3 ">
                    <div class="form-group">
                        <label>@lang('modules.members.non_member_fees')</label>
                        <input type="text" name="non_member_fees" id="non_member_fees" value="{{ $trip->non_member_fees }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-3 ">
                    <div class="form-group">
                        <label>@lang('modules.members.escort_fees')</label>
                        <input type="text" name="escort_fees" id="escort_fees" value="{{ $trip->escort_fees }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-3 ">
                    <div class="form-group salutation">
                        <label for="">@lang('app.currency')

                        </label>
                        <select name="currency" id="training_days" data-placeholder="@lang('app.currency')" class="form-control select2 " >
                            @foreach($currencies as $currency)
                                <option value="{{ $currency->currency_code }}" {{$currency->currency_code==$trip->currency ? 'selected' : ''}}>{{ ucwords($currency->currency_code) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>

        <div class="row">
            <div class="col-md-3 ">
                <div class="form-group">
                    <label>@lang('modules.members.capacity')</label>
                    <input type="text" name="capacity" id="capacity" value="{{$trip->capacity}}" class="form-control">
                </div>
            </div>
        </div>

        <div class="row">
                <div class="col-xs-6 col-md-3 ">
                    <div class="form-group">
                        <label>@lang('modules.events.startOn')</label>
                        <input type="text" name="start_date" id="start_date" value="{{ $trip->start_date_time->format($global->date_format) }}" class="form-control">
                    </div>
                </div>
                <div class="col-xs-5 col-md-3">
                    <div class="input-group bootstrap-timepicker timepicker">
                        <label>&nbsp;</label>
                        <input type="text" name="start_time" id="start_time" value="{{ $trip->start_date_time->format($global->time_format) }}"
                               class="form-control">
                    </div>
                </div>

                <div class="col-xs-6 col-md-3">
                    <div class="form-group">
                        <label>@lang('modules.events.endOn')</label>
                        <input type="text" name="end_date" id="end_date" value="{{ $trip->end_date_time->format($global->date_format) }}" class="form-control">
                    </div>
                </div>
                <div class="col-xs-5 col-md-3">
                    <div class="input-group bootstrap-timepicker timepicker">
                        <label>&nbsp;</label>
                        <input type="text" name="end_time" id="end_time" value="{{ $trip->end_date_time->format($global->time_format) }}"
                               class="form-control">
                    </div>
                </div>
            </div>
        <div class="row">
            <div class="col-md-12">
                <label>@lang('modules.club.program')</label>
                <div class="form-group">
                    <textarea name="program" id="program" class="form-control summernote" rows="5">{{ $trip->program}}</textarea>
                </div>
            </div>
        </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-xs-6">
                        <div class="checkbox checkbox-info">
                            <input id="edit-repeat-event" name="repeat" value="yes" @if($trip->repeat == 'yes') checked @endif
                            type="checkbox">
                            <label for="edit-repeat-event">@lang('modules.events.repeat')</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" id="edit-repeat-fields" @if($trip->repeat == 'no') style="display: none" @endif>
                <div class="col-xs-6 col-md-3 ">
                    <div class="form-group">
                        <label>@lang('modules.events.repeatEvery')</label>
                        <input type="number" min="1" value="{{ $trip->repeat_every }}" name="repeat_count" class="form-control">
                    </div>
                </div>
                <div class="col-xs-6 col-md-3">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <select name="repeat_type" id="" class="form-control">
                            <option @if($trip->repeat_type == 'day') selected @endif value="day">Day(s)</option>
                            <option @if($trip->repeat_type == 'week') selected @endif value="week">Week(s)</option>
                            <option @if($trip->repeat_type == 'month') selected @endif value="month">Month(s)</option>
                            <option @if($trip->repeat_type == 'year') selected @endif value="year">Year(s)</option>
                        </select>
                    </div>
                </div>

                <div class="col-xs-6 col-md-3">
                    <div class="form-group">
                        <label>@lang('modules.events.cycles') <a class="mytooltip" href="javascript:void(0)"> <i class="fa fa-info-circle"></i><span class="tooltip-content5"><span class="tooltip-text3"><span class="tooltip-inner2">@lang('modules.events.cyclesToolTip')</span></span></span></a></label>
                        <input type="text" value="{{ $trip->repeat_cycles }}" name="repeat_cycles" id="repeat_cycles" class="form-control">
                    </div>
                </div>
            </div>

        </div>
        {!! Form::close() !!}

    </div>
    {!! Form::close() !!}

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-white waves-effect" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-success save-event waves-effect waves-light">@lang('app.update')</button>
</div>
{{--Ajax Modal--}}
<div class="modal fade bs-modal-md in" id="projectCategoryModal" role="dialog" aria-labelledby="myModalLabel"
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
{{--Ajax Modal Ends--}}


<script src="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/timepicker/bootstrap-timepicker.min.js') }}"></script>
<script src="{{ asset('js/cbpFWTabs.js') }}"></script>
<script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/multiselect/js/jquery.multi-select.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-colorselector/bootstrap-colorselector.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/summernote/dist/summernote.min.js') }}"></script>


<script>
    jQuery('#start_date, #end_date').datepicker({
        autoclose: true,
        todayHighlight: true,
        weekStart:'{{ $global->week_start }}',
        format: '{{ $global->date_picker_format }}',
    })

    $('#edit-colorselector').colorselector();

    $('#start_time, #end_time').timepicker({
        @if($global->time_format == 'H:i')
        showMeridian: false
        @endif
    });

    $(".select3").select2();
    $("select.select2").select2({
        formatNoMatches: function () {
            return "{{ __('messages.noRecordFound') }}";
        }
    });


    $('.save-event').click(function () {
        var attendeeId = $('.remove-attendee').map(function() {
            return $(this).attr('data-attendee-id');
        }).toArray();

        $.easyAjax({
            url: '{{route('admin.trips.update', $trip->id)}}',
            container: '#updateEvent',
            type: "PUT",
            data: $('#updateEvent').serialize()+ "&attendeeId=" + attendeeId,
            success: function (response) {
                if(response.status == 'success'){
                    window.location.reload();
                }
            }
        })
    })

    $('#edit-repeat-event').change(function () {
        if($(this).is(':checked')){
            $('#edit-repeat-fields').show();
        }
        else{
            $('#edit-repeat-fields').hide();
        }
    })
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