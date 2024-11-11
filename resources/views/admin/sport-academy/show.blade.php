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
                <div class="row" id="new_fields" >
                    <div class="col-md-3 ">
                        <div class="form-group">
                            <label>@lang('app.member_id')</label>
                            <input type="text" name="member_id" id="member_id" class="form-control">
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-info save-event waves-effect waves-light" id="subscribe"><i class="fa fa-money"></i> @lang('app.subscribe')
                </button>
            </div>
        </div>
        {!! Form::close() !!}

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-white waves-effect" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger btn-outline delete-event waves-effect waves-light"><i class="fa fa-times"></i> @lang('app.delete')</button>
        <button type="button" class="btn btn-info edit-event waves-effect waves-light"><i class="fa fa-edit"></i> @lang('app.edit')
        </button>
    </div>

</div>

<script>

    $('.edit-event').click(function () {
        $.easyAjax({
            url: '{{route('admin.sportActivity.edit', $session->id)}}',
            container: '#updateEvent',
            type: "GET",
            data: $('#updateEvent').serialize(),
            success: function (response) {
                if(response.status == 'success'){
                    $('#event-detail').html(response.view);
                }
            }
        })
    })


    $('.save-event').click(function () {
        // var subscriber_id = $('#member_id').val();
        var url = '{{route('admin.club.subscribe' ,':id')}}';
        url = url.replace(':id', {{$session->id}} );
        // url = url.replace(':subscriber_id', subscriber_id);
        $.easyAjax({
            url: url,
            container: '#updateEvent',
            type: "GET",
            data: $('#updateEvent').serialize(),
            success: function (response) {
                if(response.status == 'success'){
                    window.location.reload();
                }
            }
        })
    })

    $('.delete-event').click(function(){
        swal({
            title: "@lang('messages.sweetAlertTitle')",
            text: "@lang('messages.confirmation.recoverEvent')",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "@lang('messages.deleteConfirmation')",
            cancelButtonText: "@lang('messages.confirmNoArchive')",
            closeOnConfirm: true,
            closeOnCancel: true
        }, function(isConfirm){
            if (isConfirm) {

                var url = "{{ route('admin.sportActivity.destroy', $session->id) }}";

                var token = "{{ csrf_token() }}";

                $.easyAjax({
                    type: 'POST',
                            url: url,
                            data: {'_token': token, '_method': 'DELETE'},
                    success: function (response) {
                        if (response.status == "success") {
                            window.location.reload();
                        }
                    }
                });
            }
        });
    });
    $("[data-toggle=tooltip]").tooltip();


</script>