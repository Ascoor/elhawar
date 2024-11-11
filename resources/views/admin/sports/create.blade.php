
@extends('layouts.app')

@section('page-title')
<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 bg-title-left">
        <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __($pageTitle) }}</h4>
    </div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12 bg-title-right">
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}">@lang('app.menu.home')</a></li>
            <li><a href="{{ route('admin.sports.index') }}">{{ __($pageTitle) }}</a></li>
            <li class="active">@lang('app.addNew')</li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>
@endsection
@push('head-script')
{{--
<link rel="stylesheet" href="{{ asset('public/plugins/metronics/wizard-4.css') }}">--}}

<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/summernote/dist/summernote.css') }}">
<style>
    .salutation .form-control {
        padding: 2px 2px;
    }

    .select-category button {
        background-color: white !important;
        font-size: 13px;
        color: #565656;
        border: 1px solid #e4e7ea !important;
    }

    .select-category button:hover {
        color: #565656;
        opacity: 1;
    }

    .bootstrap-select .dropdown-toggle:focus {
        outline: none !important;
    }
</style>

@endpush



@section('content')



<div class="row">
    <div class="col-xs-12">

        <div class="panel panel-inverse">
            <div class="panel-heading"> @lang('modules.members.add_new_sport')</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    {!! Form::open(['id'=>'createSport','class'=>'ajax-form','method'=>'POST']) !!}
                    <input type="hidden" name="player" value="1">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 ">
                                <div class="form-group">
                                    <label class="required">@lang('app.add') @lang('modules.members.sportName')</label>
                                    <input type="text" name="name" id="name" class="form-control">
                                </div>
                            </div>
                            <div class="col-xs-12 ">
                                <div class="form-group">
                                    <label class="required">@lang('app.add') @lang('modules.members.sportkind')</label>
            
                                    <select name="kind" id="kind" class="form-select form-control" aria-label="Default select example">
                                        <option value="team">Team</option>
                                        <option value="single">Single</option>
                                      </select>
            
                                </div>
                                
                            </div>
            
                           
            
                            <div class="col-xs-12 ">
                                <div class="form-group">
                                    <label class="required">@lang('app.add') @lang('modules.members.sportCode')</label>
                                    <input type="text" name="code" id="code" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>@lang('modules.club.selectPhoto')</label>
                                <div class="form-group">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                            <img src="https://via.placeholder.com/200x150.png?text={{ str_replace(' ', '+', __('modules.profile.uploadPicture')) }}"   alt=""/>
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
                        {{--                        </form>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>    <!-- .row -->
       
</div>




















@endsection

@push('footer-script')


<script>


    $('#createSport').on('submit', (e) => {
        e.preventDefault();
        $.easyAjax({
            url: '{{route('admin.sports.store')}}',
            container: '#createSport',
            type: "POST",
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
</script>
@endpush