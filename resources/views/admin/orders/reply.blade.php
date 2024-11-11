
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

                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <div class="form-body">
                            <div class="row">
                               <div class="col-md-3">
                                    <div class="form-group">
                                        <label > @lang('modules.orders.order_title')</label>
                                         <div>{{$member_order->name}}</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="required">@lang('modules.orders.response_time')</label>
                                        <div>{{$member_order->due_date}}</div>
                                    </div>
                                </div>
                                <div class="col-md-3 ">
                                    <div class="form-group">
                                        <label class="required">@lang('modules.orders.created_by') <a href="javascript:;"
                                                                              id="resource-type"></a></label>
                                        <div>{{$member_order->created}}</div>
                                    </div>
                                </div>
                                <div class="col-md-3 ">
                                    <div class="form-group">
                                        <label class="required">@lang('modules.orders.directed_to')  <a href="javascript:;"
                                                                              id="resource-type"></a></label>
                                        <div>{{$member_order->directed}}</div>
                                    </div>
                                </div>
                            </div>
                            <label class="m-r-10"> @lang('modules.orders.order_description')</label>
                            @if($member_order->file ) <a href="{{asset($member_order->file)}}" class="label label-info">View File</a> @endif
                            <div class="panel-heading col-md-12 m-b-10">
                                {{$member_order->description}}
                            </div>
                            <div class="row">
                                <label>Replies</label>
                                @foreach($comments as $comment)
                                    <div class="col-md-12 p-10 label-default m-b-5">
                                        <div class="col-md-2">
                                            <div class="p-3 label label-primary">{{$comment->commented_by}}</div>
                                        </div>
                                        <div class="col-md-8">{{$comment->comment}}</div>
                                    </div>
                                @endforeach
                            </div>
                            @if($member_order->state !==1 && $can_reply)
                                <form action="{{route('admin.orders.store-reply',$member_order->id)}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label"> @lang('modules.orders.reply')</label>
                                            <textarea name="reply" id="description" rows="5"
                                                class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="m-b-10">
                                                <label class="control-label"> @lang('modules.orders.close_order')</label>
                                                <input type="checkbox" name="closeOrder">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button for="file-upload" id="save-form" class="btn btn-primary">
                                        @lang('modules.orders.reply')
                                    </button>
                                </div>
                            </form>

                            @endif
                        </div>
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
