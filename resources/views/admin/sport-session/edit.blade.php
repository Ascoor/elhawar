

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title"><i class="icon-pencil"></i> @lang('app.edit') @lang('app.menu.Events')</h4>
</div>
<div class="modal-body">
    {!! Form::open(['id'=>'updateEvent','class'=>'ajax-form','method'=>'PUT']) !!}
{{--    <input type= "hidden" name="event_unique_id" value="{{$event->event_unique_id}}">--}}
    <div class="form-body">
        <div class="row">
            <div class="col-md-5 ">
                <div class="form-group">
                    <label>@lang('modules.events.eventName')</label>
                    <input type="text" name="session_name" id="session_name" value="{{ $session->session_name }}" class="form-control">
                </div>
            </div>

            <div class="col-md-1 ">
                <div class="form-group">
                    <label>@lang('modules.sticky.colors')</label>
                    <select id="edit-colorselector" name="label_color">
                        <option value="bg-info" data-color="#5475ed" @if($session->label_color == 'bg-info') selected @endif>Blue</option>
                        <option value="bg-warning" data-color="#f1c411" @if($session->label_color == 'bg-warning') selected @endif>Yellow</option>
                        <option value="bg-purple" data-color="#ab8ce4" @if($session->label_color == 'bg-purple') selected @endif>Purple</option>
                        <option value="bg-danger" data-color="#ed4040" @if($session->label_color == 'bg-danger') selected @endif>Red</option>
                        <option value="bg-success" data-color="#00c292" @if($session->label_color == 'bg-success') selected @endif>Green</option>
                        <option value="bg-inverse" data-color="#4c5667" @if($session->label_color == 'bg-inverse') selected @endif>Grey</option>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">@lang('modules.members.location')
                        <a href="javascript:;" id="location" class="btn btn-xs btn-success btn-outline"><i class="fa fa-plus"></i></a>
                    </label>
                    <select class="select2 form-control" data-placeholder="@lang('modules.members.location')"  id="location_id" name="location_id">
                        @forelse($locations as $location)
                            <option value="{{ $location->id }}" {{$session->location_id== $location->id ? 'selected' : ''}}>{{ ucwords($location->name) }}</option>
                        @empty
                            <option value="">@lang('messages.noCategoryAdded')</option>
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">@lang('modules.members.sport')
                            <a href="javascript:;" id="sport" class="btn btn-xs btn-success btn-outline"><i class="fa fa-plus"></i></a>
                        </label>
                        <select class="select2 form-control" data-placeholder="@lang('modules.members.sport')"  id="sport_id" name="sport_id">
                            @forelse($sports as $sport)
                                <option value="{{ $sport->id }}" {{$session->sport_id == $sport->id ? 'selected' : ''}}>{{ ucwords($sport->name) }}</option>
                            @empty
                                <option value="">@lang('messages.noCategoryAdded')</option>
                            @endforelse
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">@lang('modules.members.level')
                            <a href="javascript:;" id="level" class="btn btn-xs btn-success btn-outline"><i class="fa fa-plus"></i></a>
                        </label>
                        <select class="select2 form-control" data-placeholder="@lang('modules.members.level')"  id="level_id" name="level_id">
                            @foreach($levels as $level)
                                <option value="{{ $level->id }}" {{$session->level_id == $level->id ? 'selected' : ''}}>{{ ucwords($level->name) }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label  class="control-label">@lang('modules.members.group')
                            <a href="javascript:;"
                               id="group"
                               class="btn btn-xs btn-outline btn-success">
                                <i class="fa fa-plus"></i>
                            </a>
                        </label>
                        <select class="select2 form-control" data-placeholder="@lang('modules.members.group')"  id="group_id" name="group_id">
                            @forelse($groups as $group)
                                <option value="{{ $group->id }}" {{$session->group_id == $group->id ? 'selected' : ''}}>{{ ucwords($group->name) }}</option>
                            @empty
                                <option value="">@lang('messages.noCategoryAdded')</option>
                            @endforelse
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">@lang('modules.members.coaches')
                        </label>
                        <select class="select2 form-control" data-placeholder="@lang('modules.members.coaches')"  id="coach_id" name="coach_id">
                            @forelse($coaches as $coach)
                                <option value="{{ $coach->user_id }}" {{$session->coach_id == $coach->user_id ? 'selected' : ''}}>{{ ucwords($coach->user->name) }}</option>
                            @empty
                                <option value="">@lang('messages.noCategoryAdded')</option>
                            @endforelse
                        </select>
                    </div>
                </div>


            </div>
            <div class="row">
                <div class="col-md-3 ">
                    <div class="form-group">
                        <label>@lang('modules.members.capacity')</label>
                        <input type="text" name="capacity" id="capacity" value="{{ $session->capacity }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-3 ">
                    <div class="form-group">
                        <label>@lang('modules.members.fees')</label>
                        <input type="text" name="fees" id="fees" value="{{ $session->fees }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-3 ">
                    <div class="form-group salutation">
                        <label for="">@lang('app.currency')

                        </label>
                        <select name="currency" id="training_days" data-placeholder="@lang('app.currency')" class="form-control select2 " >
                            @foreach($currencies as $currency)
                                <option value="{{ $currency->currency_code }}" {{$session->currency == $currency->currency_code ? 'selected' : ''}}>{{ ucwords($currency->currency_code) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xs-6 col-md-3">
                    <div class="form-group">
                        <label>@lang('modules.members.resv_type')</label>
                        <select name="reservation_type" id="reservation_type" class="form-control">
                            <option value="group" {{$session->reservation_type == "group"? 'selected' : ''}}>@lang('modules.members.group')</option>
                            <option value="single" {{$session->reservation_type == "single" ? 'selected' : ''}}>@lang('modules.members.single')</option>
                            <option value="special" {{$session->reservation_type == "special" ? 'selected' : ''}}>@lang('modules.members.special')</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 col-md-3 ">
                    <div class="form-group">
                        <label>@lang('modules.events.startOn')</label>
                        <input type="text" name="start_date" id="start_date" value="{{ $session->start_date_time->format($global->date_format) }}" class="form-control">
                    </div>
                </div>
                <div class="col-xs-5 col-md-3">
                    <div class="input-group bootstrap-timepicker timepicker">
                        <label>&nbsp;</label>
                        <input type="text" name="start_time" id="start_time" value="{{ $session->start_date_time->format($global->time_format) }}"
                               class="form-control">
                    </div>
                </div>

                <div class="col-xs-6 col-md-3">
                    <div class="form-group">
                        <label>@lang('modules.events.endOn')</label>
                        <input type="text" name="end_date" id="end_date" value="{{ $session->end_date_time->format($global->date_format) }}" class="form-control">
                    </div>
                </div>
                <div class="col-xs-5 col-md-3">
                    <div class="input-group bootstrap-timepicker timepicker">
                        <label>&nbsp;</label>
                        <input type="text" name="end_time" id="end_time" value="{{ $session->end_date_time->format($global->time_format) }}"
                               class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-xs-6">
                    <div class="radio radio-info">
                        <input id="edit_related_session" name="related_session" value=""
                               type="radio" checked="checked">
                        <label for="edit_related_session">@lang('modules.members.related_session')</label>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="radio radio-info">
                        <input id="edit_new_session" name="related_session" value=""
                               type="radio" >
                        <label for="edit_new_session">@lang('modules.members.new_session')</label>
                    </div>
                </div>
            </div>
            <div class="row" id="edit_new_fields" style="display: none">
                <div class="col-md-3 ">
                    <div class="form-group">
                        <label>@lang('modules.members.new_session_id')</label>
                        <input type="text" name="" id="edit_new_session_id" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row" id="edit_related_fields" >
                <div class="col-xs-6 col-md-3">
                    <div class="form-group">
                        <label>@lang('modules.members.related_session_id')</label>
                        <select name="session_id" id="edit_related_session_id" class="form-control">
                            @foreach($session_ids as $item)
                                <option value="{{ $item }}" {{$session->session_id == $item ? "selected" : ''}}>{{ ucwords($item) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-xs-6">
                        <div class="checkbox checkbox-info">
                            <input id="edit-repeat-event" name="repeat" value="yes" @if($session->repeat == 'yes') checked @endif
                            type="checkbox">
                            <label for="edit-repeat-event">@lang('modules.events.repeat')</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" id="edit-repeat-fields" @if($session->repeat == 'no') style="display: none" @endif>
                <div class="col-xs-6 col-md-3 ">
                    <div class="form-group">
                        <label>@lang('modules.events.repeatEvery')</label>
                        <input type="number" min="1" value="{{ $session->repeat_every }}" name="repeat_count" class="form-control">
                    </div>
                </div>
                <div class="col-xs-6 col-md-3">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <select name="repeat_type" id="" class="form-control">
                            <option @if($session->repeat_type == 'day') selected @endif value="day">Day(s)</option>
                            <option @if($session->repeat_type == 'week') selected @endif value="week">Week(s)</option>
                            <option @if($session->repeat_type == 'month') selected @endif value="month">Month(s)</option>
                            <option @if($session->repeat_type == 'year') selected @endif value="year">Year(s)</option>
                        </select>
                    </div>
                </div>

                <div class="col-xs-6 col-md-3">
                    <div class="form-group">
                        <label>@lang('modules.events.cycles') <a class="mytooltip" href="javascript:void(0)"> <i class="fa fa-info-circle"></i><span class="tooltip-content5"><span class="tooltip-text3"><span class="tooltip-inner2">@lang('modules.events.cyclesToolTip')</span></span></span></a></label>
                        <input type="text" value="{{ $session->repeat_cycles }}" name="repeat_cycles" id="repeat_cycles" class="form-control">
                    </div>
                </div>
            </div>

        </div>
        {!! Form::close() !!}

    </div>
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

$('#sport').click(function () {
            var url = '{{ route('admin.sportAcademy.create')}}';
            $('#modelHeading').html('...');
            $.ajaxModal('#projectCategoryModal', url);
        })
        $('#level').click(function () {
            var url = '{{ route('admin.level.create')}}';
            $('#modelHeading').html('...');
            $.ajaxModal('#projectCategoryModal', url);
        })
        $('#group').click(function () {
            var url = '{{ route('admin.playerGroup.create')}}';
            $('#modelHeading').html('...');
            $.ajaxModal('#projectCategoryModal', url);
        })
        $('#location').click(function () {
            var url = '{{ route('admin.location.create')}}';
            $('#modelHeading').html('...');
            $.ajaxModal('#projectCategoryModal', url);
        })
    $('.save-event').click(function () {
        var attendeeId = $('.remove-attendee').map(function() {
            return $(this).attr('data-attendee-id');
        }).toArray();

        $.easyAjax({
            url: '{{route('admin.sportActivity.update', $session->id)}}',
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
        $('#edit_new_session').change(function () {
            if($(this).is(':checked')){
                $('#edit_new_fields').show();
                $('#edit_related_fields').hide();
                $('#edit_related_session_id').prop("name" , "");
                $('#edit_new_session_id').prop("name" , "session_id");
            }
            else{
                $('#edit_new_fields').hide();
                $('#related_session_id').prop("name" , "session_id");
            }
        })
        $('#edit_related_session').change(function () {
            if($(this).is(':checked')){
                $('#edit_related_fields').show();
                $('#edit_new_fields').hide();
                $('#edit_new_session_id').prop("name" , "");
                $('#edit_related_session_id').prop("name" , "session_id");
            }
            else{
                $('#edit_related_fields').hide();
                $('#edit_new_session_id').prop("name" , "session_id");
            }
        })


</script>