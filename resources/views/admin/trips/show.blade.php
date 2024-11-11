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
                            {{ ucfirst($trip->trip_name) }}
                        </p>
                    </div>
                </div>

            </div>



                <div class="row">
                <div class="col-xs-12 col-md-4 ">
                    <div class="form-group">
                        <label>@lang('modules.members.member_fees')</label>
                        <p>{{ $trip->member_fees }}{{$trip->currency}}</p>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4 ">
                    <div class="form-group">
                        <label>@lang('modules.members.non_member_fees')</label>
                        <p>{{ $trip->non_member_fees }}{{$trip->currency}}</p>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4 ">
                    <div class="form-group">
                        <label>@lang('modules.members.escort_fees')</label>
                        <p>{{ $trip->escort_fees }}{{$trip->currency}}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-4 ">
                    <div class="form-group">
                        <label>@lang('modules.club.supervisor')</label>
                        <p>{{ $supervisor->user->name }}</p>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4 ">
                    <div class="form-group">
                        <label>@lang('modules.members.capacity')</label>
                        <p>{{ $trip->capacity }}</p>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4 ">
                    <div class="form-group">
                        <label>@lang('modules.members.available')</label>
                        <p>{{ $trip->available }}</p>
                    </div>
                </div>


            </div>
            <div class="row">
                <div class="col-xs-6 col-md-4 ">
                    <div class="form-group">
                        <label>@lang('modules.events.startOn')</label>
                        <p>{{ $trip->start_date_time->format($global->date_format. ' - '.$global->time_format) }}</p>
                    </div>
                </div>
                <div class="col-xs-6 col-md-4">
                    <div class="form-group">
                        <label>@lang('modules.events.endOn')</label>
                        <p>{{ $trip->end_date_time->format($global->date_format. ' - '.$global->time_format) }}</p>

                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-xs-12 col-md-4">
                    <div class="form-group">
                        <label>@lang('modules.club.program')</label>
                        <p>{!! $trip->program  !!}</p>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-white waves-effect" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger btn-outline delete-event waves-effect waves-light"><i class="fa fa-times"></i> @lang('app.delete')</button>
        <button type="button" class="btn btn-info save-event waves-effect waves-light"><i class="fa fa-edit"></i> @lang('app.edit')
        </button>
    </div>

</div>

<script>

    $('.save-event').click(function () {
        $.easyAjax({
            url: '{{route('admin.trips.edit', $trip->id)}}',
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

                var url = "{{ route('admin.trips.destroy', $trip->id) }}";

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