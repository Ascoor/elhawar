<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title">@lang('app.category')</h4>
</div>
<div class="modal-body">
    <div class="portlet-body">
        <div class="table-responsive">
            <table class="table category-table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>@lang('modules.projectCategory.categoryName')</th>
                    <th>@lang('modules.stocks.category_description')</th>
                </tr>
                </thead>
                <tbody>
                @forelse($categories as $key=>$category)
                    <tr id="cat-{{ $category->id }}">
                        <td>{{ $key+1 }}</td>
                        <td>{{ ucwords($category->name) }}</td>
                        <td>{{ ucwords($category->description) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">@lang('modules.assets.no_asset_cat')</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {!! Form::open(['id'=>'createProductCategory','class'=>'ajax-form','method'=>'POST']) !!}
        <div class="form-body">
            <div class="row">
                <div class="col-xs-6 ">
                    <div class="form-group">
                        <label>@lang('modules.projectCategory.categoryName')</label>
                        <input type="text" name="name" id="category_name" class="form-control">
                    </div>
                </div>
                <div class="col-xs-6 ">
                    <div class="form-group">
                        <label>@lang('modules.stocks.category_description')</label>
                        <input type="text" name="description" id="description" class="form-control">
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

    $('body').on('click', '.delete-category', function() {
        var id = $(this).data('cat-id');
        var url = "{{ route('admin.productCategory.destroy',':id') }}";
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
                        selectData = '<option value="'+value.id+'">'+value.name+'</option>';
                        options.push(selectData);
                    });

                    options.splice(0, 0, '<option value="">Select Category...</option>');
                    $('#category_id').html(options);
                    $('#category_id').selectpicker('refresh');
                }
            }
        });
    });

    $('#createProductCategory').on('submit', (e) => {
        e.preventDefault();
        $.easyAjax({
            url: '{{route('admin.categories.store')}}',
            container: '#createProductCategory',
            type: "POST",
            data: $('#createProductCategory').serialize(),
            success: function (response) {
                if(response.status == 'success'){
                    var options = [];
                    var rData = [];
                    rData = response.data;
                    console.log(rData);
                    let listData = "";
                    $.each(rData, function( index, value ) {
                        var selectData = '';
                        selectData = '<option value="'+value.id+'">'+value.name+'</option>';
                        options.push(selectData);
                        listData += '<tr id="cat-' + value.id + '">'+
                            '<td>'+(index+1)+'</td>'+
                            '<td>' + value.name + '</td>'+
                            '<td>' + value.description + '</td>'+
                            '</tr>';
                    });
                    $('.category-table tbody' ).html(listData);

                    options.splice(0, 0, '<option value="">Select Category...</option>');
                    $('#category_id').html(options);
                    $('#category_id').selectpicker('refresh');
                    $('#category_name').val('');
                }
            }
        })
    });
</script>