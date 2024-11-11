<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title">@lang('modules.members.status')</h4>
</div>
<div class="modal-body">
    <div class="portlet-body">
        <div class="table-responsive">
            <table class="table category-table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>@lang('modules.members.statusName')</th>
                    <th>@lang('app.action')</th>
                </tr>
                </thead>
                <tbody>
                @forelse($statuses as $key=>$status)
                    <tr id="cat-{{ $status->id }}">
                        <td>{{ $key+1 }}</td>
                        <td>{{ ucwords($status->status_name) }}</td>
                        @if($status->id > 4)
                        <td><a href="javascript:;" data-cat-id="{{ $status->id }}" onclick="deleteCategory({{ $status->id }})" class="btn btn-sm btn-danger btn-rounded delete-category">@lang("app.remove")</a></td>
                        @else
                            <td><span class="text-danger">@lang('messages.status_cant_be_deleted')</span></td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">@lang('messages.noProjectCategory')</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <hr>
        {!! Form::open(['id'=>'createStatus','class'=>'ajax-form','method'=>'POST']) !!}
        <div class="form-body">
            <div class="row">
                <div class="col-xs-12 ">
                    <div class="form-group">
                        <label class="required">@lang('app.add') @lang('modules.members.statusName')</label>
                        <input type="text" name="status_name" id="status_name" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" id="save-category" class="btn btn-success"> <i class="fa fa-check"></i> @lang('app.save')</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>

<script>

    $('body').on('click', '.delete-category', function(e) {
        var id = $(this).data('cat-id');
        var url = "{{ route('admin.memberStatus.destroy',':id') }}";
        url = url.replace(':id', id);

        var token = "{{ csrf_token() }}";

        $.easyAjax({
            type: 'POST',
            url: url,
            data: {'_token': token, '_method': 'DELETE'},
            success: function (response) {
                if (response.status == "success") {
                    $.unblockUI();
                    $('#cat-'+id).fadeOut();
                    var options = [];
                    var rData = [];
                    rData = response.data;
                    $.each(rData, function( index, value ) {
                        var selectData = '';
                        selectData = '<option value="'+value.id+'">'+value.status_name+'</option>';
                        options.push(selectData);
                    });

                    $('#status_id').html(options);

                }
            }
        });
        e.preventDefault();
    });

    $('#createStatus').on('submit', (e) => {
        e.preventDefault();
        $.easyAjax({
            url: '{{route('admin.memberStatus.store')}}',
            container: '#createStatus',
            type: "POST",
            data: $('#createStatus').serialize(),
            success: function (response) {
                if(response.status == 'success'){
                    if(response.status == 'success'){
                        var options = [];
                        var rData = [];
                        let listData = "";
                        rData = response.data;
                        $.each(rData, function (index, value) {
                            var selectData = '';
                            selectData = '<option value="' + value.id + '">' + value.status_name + '</option>';
                            options.push(selectData);
                            if (value.id > 4) {
                                listData += '<tr id="cat-' + value.id + '">' +
                                '<td>' + (index + 1) + '</td>' +
                                '<td>' + value.status_name + '</td>' +
                                '<td><a href="javascript:;" data-cat-id="' + value.id + '" class="btn btn-sm btn-danger btn-rounded delete-category">@lang("app.remove")</a></td>' +
                                '</tr>';
                        }
                        else {
                                listData += '<tr id="cat-' + value.id + '">' +
                                    '<td>' + (index + 1) + '</td>' +
                                    '<td>' + value.relation_name + '</td>' +
                                    '<td><span class="text-danger">@lang('messages.status_cant_be_deleted')</span></td>' +
                                    '</tr>';
                            }
                        });

                        $('.category-table tbody' ).html(listData);

                        $('#status_id').html(options);
                        $('#status_name').val(' ');
                    }
                }
            }
        })
    });
</script>