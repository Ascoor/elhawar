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
    </div>

</div>
<script>



    $("[data-toggle=tooltip]").tooltip();


</script>