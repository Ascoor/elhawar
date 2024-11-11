<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title">@lang('modules.members.sportAcademies')</h4>
</div>
<div class="modal-body">
    <div class="portlet-body">
        <div class="table-responsive">
            <table class="table category-table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>@lang('modules.members.sportName')</th>
                    <th>@lang('app.action')</th>
                </tr>
                </thead>
                <tbody>
                @forelse($sports as $key=>$sport)
                    <tr id="cat-{{ $sport->id }}">
                        <td>{{ $key+1 }}</td>
                        <td>{{ ucwords($sport->name) }}</td>
                        <td><a href="javascript:;" data-cat-id="{{ $sport->id }}" onclick="deleteCategory({{ $sport->id }})" class="btn btn-sm btn-danger btn-rounded delete-category">@lang("app.remove")</a></td>
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
        {!! Form::open(['id'=>'createSport','class'=>'ajax-form','method'=>'POST']) !!}
        <div class="form-body">
            <div class="row">
                <div class="col-xs-12 ">
                    <div class="form-group">
                        <label class="required">@lang('app.add') @lang('modules.members.sportName')</label>
                        <input type="text" name="name" id="name" value="{{$sport->name}}" class="form-control">
                    </div>
                </div>
                <div class="col-xs-12 ">
                    <div class="form-group">
                        <label class="required">@lang('app.add') @lang('modules.members.sportCode')</label>
                        <input type="text" name="code" id="code" value="{{$sport->code}}" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label>@lang('app.description')</label>
                    <div class="form-group">
                        <textarea name="description" id="description" class="form-control summernote" rows="5">{!! $sport->description !!}</textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label>@lang('modules.club.selectPhoto')</label>
                    <div class="form-group">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                <img src="{{ $sport->image_url() }}"   alt=""/>
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail"
                                 style="max-width: 200px; max-height: 150px;"></div>
                            <div>
                                <span class="btn btn-info btn-file">
                                    <span class="fileinput-new"> @lang('app.selectImage') </span>
                                    <span class="fileinput-exists"> @lang('app.change') </span>
                                    <input type="file" id="image" name="image"> </span>
                                <a href="javascript:;" class="btn btn-danger fileinput-exists"
                                   data-dismiss="fileinput"> @lang('app.remove') </a>
                            </div>
                        </div>
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
        var url = "{{ route('admin.sportAcademy.destroy',':id') }}";
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
                    $.easyBlockUI('#members-table');
                    window.LaravelDataTables["members-table"].draw();
                    $.easyUnblockUI('#members-table');
                    $.each(rData, function( index, value ) {
                        var selectData = '';
                        selectData = '<option value="'+value.id+'">'+value.name+'</option>';
                        options.push(selectData);
                    });

                    $('#relation_id').html(options);
                }
            }
        });
        e.preventDefault();
    });

    $('#createSport').on('submit', (e) => {
        e.preventDefault();
        $.easyAjax({
            url: '{{route('admin.sportAcademy.update' , $sport->id)}}',
            container: '#createSport',
            type: "PUT",
            file: (document.getElementById("image").files.length == 0) ? false : true,
            data: $('#createSport').serialize(),
            success: function (response) {
                if(response.status == 'success'){
                    if(response.status == 'success'){
                        var options = [];
                        var rData = [];
                        let listData = "";
                        rData = response.data;
                        $.each(rData, function (index, value) {
                            var selectData = '';
                            selectData = '<option value="' + value.id + '">' + value.name + '</option>';
                            options.push(selectData);
                            listData += '<tr id="cat-' + value.id + '">'+
                                '<td>'+(index+1)+'</td>'+
                                '<td>' + value.name + '</td>'+
                                '<td><a href="javascript:;" data-cat-id="' + value.id + '" class="btn btn-sm btn-danger btn-rounded delete-category">@lang("app.remove")</a></td>'+
                                '</tr>';
                        });
                        $.easyBlockUI('#members-table');
                        window.LaravelDataTables["members-table"].draw();
                        $.easyUnblockUI('#members-table');
                        $('.category-table tbody' ).html(listData);

                        $('#sport_id').html(options);
                        $('#name').val(' ');
                        $('#code').val(' ');
                    }
                }
            }
        })
    });
    $('.summernote').summernote({
        height: 200,                 // set editor height
        minHeight: null,             // set minimum height of editor
        maxHeight: null,             // set maximum height of editor
        focus: false,
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough']],
            ['fontsize', ['fontsize']],
            ['para', ['ul', 'ol', 'paragraph']],
            ["view", ["fullscreen"]]
        ]
    });
</script>