<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title">@lang('modules.members.relations')</h4>
</div>
<div class="modal-body">
    <div class="portlet-body">
        <div class="table-responsive">
            <table class="table category-table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>@lang('modules.members.relationName')</th>
                    <th>@lang('app.action')</th>
                </tr>
                </thead>
                <tbody>
                @forelse($relations as $key=>$relation)
                    <tr id="cat-{{ $relation->id }}">
                        <td>{{ $key+1 }}</td>
                        <td>{{ ucwords($relation->relation_name) }}</td>
                        @if($relation->id > 5)
                        <td><a href="javascript:;" data-cat-id="{{ $relation->id }}"  class="btn btn-sm btn-danger btn-rounded delete-category">@lang("app.remove")</a></td>
                        @else
                            <td><span class="text-danger">@lang('messages.relationCantBeDeleted')</span></td>
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
        {!! Form::open(['id'=>'createRelation','class'=>'ajax-form','method'=>'POST']) !!}
        <div class="form-body">
            <div class="row">
                <div class="col-xs-12 ">
                    <div class="form-group">
                        <label class="required">@lang('app.add') @lang('modules.members.relationName')</label>
                        <input type="text" name="relation_name" id="relation_name" class="form-control">
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
        var url = "{{ route('admin.memberRelation.destroy',':id') }}";
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
                        if (value.id != 1) {
                            selectData = '<option value="' + value.id + '">' + value.relation_name + '</option>';
                        }
                        options.push(selectData);
                    });

                    $('#relation_id').html(options);
                }
            }
        });
        e.preventDefault();
    });

    $('#createRelation').on('submit', (e) => {
        e.preventDefault();
        $.easyAjax({
            url: '{{route('admin.memberRelation.store')}}',
            container: '#createRelation',
            type: "POST",
            data: $('#createRelation').serialize(),
            success: function (response) {
                if(response.status == 'success'){
                    if(response.status == 'success'){
                        var options = [];
                        var rData = [];
                        let listData = "";
                        rData = response.data;
                        $.each(rData, function (index, value) {
                            var selectData = '';
                            if (value.id != 1) {
                            selectData = '<option value="' + value.id + '">' + value.relation_name + '</option>';
                            }
                            options.push(selectData);
                            if (value.id > 5) {
                                listData += '<tr id="cat-' + value.id + '">' +
                                    '<td>' + (index + 1) + '</td>' +
                                    '<td>' + value.relation_name + '</td>' +
                                    '<td><a href="javascript:;" data-cat-id="' + value.id + '" class="btn btn-sm btn-danger btn-rounded delete-category">@lang("app.remove")</a></td>' +
                                    '</tr>';
                            }
                            else {
                                listData += '<tr id="cat-' + value.id + '">' +
                                    '<td>' + (index + 1) + '</td>' +
                                    '<td>' + value.relation_name + '</td>' +
                                    '<td><span class="text-danger">@lang('messages.relationCantBeDeleted')</span></td>' +
                                    '</tr>';
                            }
                        });

                        $('.category-table tbody' ).html(listData);

                        $('#relation_id').html(options);
                        $('#relation_name').val(' ');
                    }
                }
            }
        })
    });
</script>