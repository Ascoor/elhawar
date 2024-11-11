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
                <li><a href="{{ route('admin.employees.index') }}">{{ __($pageTitle) }}</a></li>
                <li class="active">@lang('app.addNew')</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection

@push('head-script')
    <link rel="stylesheet"
        href="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/tagify-master/dist/tagify.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
@endpush

@section('content')

    <div class="row">
        <div class="col-xs-12">

            <div class="panel panel-inverse">
                <div class="panel-heading">@lang('modules.orders.create_order') </div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        
                        <form method="post" enctype="multipart/form-data" action="{{route('admin.orders.store')}}">
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                   <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="required">@lang('modules.orders.order_title') </label>
                                            <input type="text" name="name" id="name" class="form-control" autocomplete="nope">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="required">@lang('modules.orders.response_time')</label>
                                            <input type="date" name="date"  class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <label class="required">@lang('modules.orders.directed_to')  <a href="javascript:;"
                                                    id="resource-type"></a></label>
                                            <select name="directed" id="type" class="form-control">
                                                <option value="">--</option>
                                                @foreach ($teams as $team)
                                                    <option value="{{ $team->id }}">{{ $team->team_name }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label">@lang('modules.stocks.description') </label>
                                            <textarea name="description" id="description" rows="5"
                                                class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="m-b-10">
                                                <label class="control-label">@lang('modules.orders.upload_file')</label>
                                            </div>
                                            <label for="file-upload"  class="btn btn-primary form-control-file">
                                                <i class="fa fa-upload" aria-hidden="true"></i>
                                                @lang('modules.orders.upload')
                                            </label> 
                                            <span id="file-name"></span>
                                            <input  type="file" name="file" class="hidden custom-file-label" onchange='handleFileChange(event)' id="file-upload"  >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit"  class="btn btn-success"> <i class="fa fa-check"></i>
                                    @lang('app.save')</button>
                            </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- .row -->
@endsection

@push('footer-script')
    <script src="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('plugins/tagify-master/dist/tagify.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
    <script data-name="basic">
        

        (function() {
            $("#department").select2({
                formatNoMatches: function() {
                    return "{{ __('messages.noRecordFound') }}";
                }
            });
            $("#designation").select2({
                formatNoMatches: function() {
                    return "{{ __('messages.noRecordFound') }}";
                }
            });
            $(".select2").select2({
                formatNoMatches: function() {
                    return "{{ __('messages.noRecordFound') }}";
                }
            });

        })()
    </script>

    <script>
        $("#joining_date, #end_date, .date-picker").datepicker({
            todayHighlight: true,
            autoclose: true,
            weekStart: '{{ $global->week_start }}',
            format: '{{ $global->date_picker_format }}',
        });
        function handleFileChange(evt){
            // console.log("reda");
            var files = evt.target.files;
            var file = files[0];
            console.log( file.name);
            document.getElementById('file-name').innerHTML = file.name;
        }
        $('#save-form').click(function() {
            var form = $('#createResource')[0];
            var data = new FormData(form);
            data.append("CustomField", "This is some extra data, testing");
            $.easyAjax({
                url: '{{ route('admin.orders.store') }}',
                
                type: "POST",
                redirect: true,
                enctype: 'multipart/form-data',
                processData: false,
                data: data
            })
        });



        $('#resource-type').on('click', function(event) {
            event.preventDefault();
            var url = '{{ route('admin.teams.quick-create') }}';
            $('#modelHeading').html("@lang('messages.manageDepartment')");
            $.ajaxModal('#departmentModel', url);
        });
    </script>
@endpush
