<div id="event-detail">

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><i class="ti-eye"></i> @lang('app.menu.Events') @lang('app.details')</h4>
    </div>
    <div class="modal-body">
        {!! Form::open(['id'=>'updateEvent','class'=>'ajax-form','method'=>'GET']) !!}
        <div class="form-body">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="form-group">
                        <label>@lang('modules.events.eventName')</label>
                        <p>
                            {{ ucfirst($session->session_name) }}
                        </p>
                        <p class="font-normal"> &mdash; <i>#</i> {{ $session->session_id }}</p>
                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-xs-12 col-md-4 ">
                    <div class="form-group">
                        <label>@lang('app.sport')</label>
                        <p>{{ ucfirst($sport->name) }}</p>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4 ">
                    <div class="form-group">
                        <label>@lang('modules.members.level')</label>
                        <p>{{ $level->name }}</p>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4 ">
                    <div class="form-group">
                        <label>@lang('modules.members.group')</label>
                        <p>{{ $group->name }}</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-4">
                    <div class="form-group">
                        <label>@lang('app.location')</label>
                        <p>{{ ucfirst( $location->name) }}</p>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4 ">
                    <div class="form-group">
                        <label>@lang('modules.members.coach')</label>
                        <p>{{ $coach->user->name }}</p>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4 ">
                    <div class="form-group">
                        <label>@lang('modules.members.fees')</label>
                        <p>{{ $session->fees }}{{$session->currency}}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-4 ">
                    <div class="form-group">
                        <label>@lang('modules.members.capacity')</label>
                        <p>{{ $session->capacity }}</p>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4 ">
                    <div class="form-group">
                        <label>@lang('modules.members.available')</label>
                        <p>{{ $session->available }}</p>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4 ">
                    <div class="form-group">
                        <label>@lang('modules.club.waiting')</label>
                        <p>{{ $session->waiting }}</p>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-xs-12 col-md-4 ">
                    <div class="form-group">
                        <label>@lang('modules.members.reservation_type')</label>
                        <p>{{ $session->reservation_type }}</p>
                    </div>
                </div>
                <div class="col-xs-6 col-md-4 ">
                    <div class="form-group">
                        <label>@lang('modules.events.startOn')</label>
                        <p>{{ $session->start_date_time->format($global->date_format. ' - '.$global->time_format) }}</p>
                        {{--                         @if($session->repeat == 'yes')--}}
                        {{--                            <p>{{ $startDate }}</p>--}}
                        {{--                        @else--}}
                        {{--                            <p>{{ $session->start_date_time }}</p>--}}
                        {{--                        @endif--}}
                    </div>
                </div>
                <div class="col-xs-6 col-md-4">
                    <div class="form-group">
                        <label>@lang('modules.events.endOn')</label>
                        <p>{{ $session->end_date_time->format($global->date_format. ' - '.$global->time_format) }}</p>
                        {{--                         @if ($session->repeat == 'yes')--}}
                        {{--                            <p>{{ $startDate }} - {{ $session->end_date_time }}</p>--}}

                        {{--                        @else--}}
                        {{--                            <p>{{ $session->end_date_time }}</p>--}}
                        {{--                        @endif--}}

                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-xs-6">
                    <div class="radio radio-info">
                        <input id="this_user" name="family_member" value=""
                               type="radio" checked="checked">
                        <label for="this_user">@lang('modules.members.this_user')</label>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="radio radio-info">
                        <input id="family_member" name="family_member" value=""
                               type="radio">
                        <label for="family_member">@lang('modules.members.family_member')</label>
                    </div>
                </div>
            </div>
            <div class="row" id="f_member_fields" style="display: none">
                <div class="col-xs-6 col-md-3">
                    <div class="form-group">
                        <label>@lang('modules.members.family_member')</label>
                        <select name="" id="user_id" class="form-control">
                            @foreach($members as $member)
                                <option value="{{ $member->user_id }}">{{ ucwords($member->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-white waves-effect" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-info save-event waves-effect waves-light" id="subscribe_f_member" style="display: none"><i class="fa fa-money"></i> @lang('app.subscribe')
        </button>
        @if(!in_array(auth()->user()->id , $subscribers))
        <button type="button" class="btn btn-info save-event waves-effect waves-light" id="subscribe"><i class="fa fa-money"></i> @lang('app.subscribe')
        </button>
        @else
            <button type="button" class="btn btn-info save-event waves-effect waves-light" id="subscribed" disabled><i class="fa fa-check"></i> @lang('app.subscribed')
            </button>
            @endif
    </div>

</div>

<script>
 $('.save-event').click(function () {
        $.easyAjax({
            url: '{{route('club.club.subscribe', $session->id )}}',
            container: '#updateEvent',
            type: "GET",
            data: $('#updateEvent').serialize(),
            success: function (response) {
                if(response.status == 'success'){
                    $('#event-detail').html(response.view);
                    $('#subscribe').setAttribute('disabled','');
                }
            }
        })
    })

    $("[data-toggle=tooltip]").tooltip();

$('#this_user').change(function () {
            if($(this).is(':checked')){
                $('#subscribed').show();
                $('#subscribe').show();
                $('#subscribe_f_member').hide();
                $('#f_member_fields').hide();
                $('#user_id').prop("name" , "");
            }
            else{
                $('#f_member_fields').prop("name" , "session_id");
            }
        })
        $('#family_member').change(function () {
            if($(this).is(':checked')){
                $('#f_member_fields').show();
                $('#subscribed').hide();
                $('#subscribe').hide();
                $('#subscribe_f_member').show();
                $('#user_id').prop("name" , "user_id");
            }
{{--            else{--}}
{{--                $('#this_user_id').prop("name" , "session_id");--}}
{{--            }--}}
        })

</script>