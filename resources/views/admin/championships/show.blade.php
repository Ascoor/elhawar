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
                            {{ ucfirst($championship->championship_name) }}
                        </p>
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
                        <label>@lang('modules.club.team')</label>
                        <p>{{ $team->team_name }}</p>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4">
                    <div class="form-group">
                        <label>@lang('app.location')</label>
                        <p>{{ ucfirst( $location->name) }}</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-4">
                    <div class="form-group">
                        <label>@lang('modules.club.championship_type')</label>
                        <p>{{ ucfirst( $championship->championship_type) }}</p>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4 ">
                    <div class="form-group">
                        <label>@lang('modules.club.sport_type')</label>
                        <p>{{ $championship->sport_type }}</p>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-xs-6 col-md-4 ">
                    <div class="form-group">
                            <label>@lang('modules.events.startOn')</label>
                            <p>{{ $championship->start_date_time->format($global->date_format. ' - '.$global->time_format) }}</p>
                    </div>
                </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="form-group">
                            <label>@lang('modules.events.endOn')</label>
                            <p>{{ $championship->end_date_time->format($global->date_format. ' - '.$global->time_format) }}</p>

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
            url: '{{route('admin.championships.edit', $championship->id)}}',
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

                var url = "{{ route('admin.championships.destroy', $championship->id) }}";

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