<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title">@lang('app.edit') @lang('app.consent')</h4>
</div>
<div class="modal-body">
    <div class="portlet-body">


        {!! Form::open(['id'=>'editConsent','class'=>'ajax-form','method'=>'PUT']) !!}

        <div class="form-body">
            <div class="row">
                <div class="col-xs-12 ">
                    <div class="form-group">
                        <label>@lang('app.name')</label>
                        <input type="text" name="name" class="form-control" value="{{$consent->name}}">
                    </div>
                </div>
                <div class="col-xs-12 ">
                    <div class="form-group">
                        <label>@lang('app.description')</label>
                        <textarea name="description" class="form-control"
                                  placeholder="Briefly describe the purpose on consent">{{$consent->description}}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <button type="button" id="save-consent" class="btn btn-success"><i
                        class="fa fa-check"></i> @lang('app.save')</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>

<script>
    $("#save-consent").click(function () {
        $.easyAjax({
            url: '{{route('admin.gdpr.update-consent', $consent->id)}}',
            container: '#editConsent',
            type: "POST",
            data: $('#editConsent').serialize(),
            success: function (response) {
                if (response.status == 'success') {
                    window.location.reload();
                }
            }
        });
    });
</script>