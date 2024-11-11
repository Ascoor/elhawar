
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
                                        <label >@lang('modules.orders.order_title')</label>
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
                                        <label class="required">@lang('modules.orders.directed_to') <a href="javascript:;"
                                                                               id="resource-type"></a></label>
                                        <div>{{$member_order->directed}}</div>
                                    </div>
                                </div>
                            </div>
                            <label class="m-r-10">@lang('modules.orders.order_description')</label>
                            @if($member_order->file ) <a href="{{asset($member_order->file)}}" class="label label-info">View File</a> @endif
                            <div class="panel-heading col-md-12 m-b-10">
                                {{$member_order->description}}
                            </div>
                            @if($member_order->state !==1)
                                <form action="{{route('admin.orders.vote',$member_order->id)}}" method="post">
                                    @csrf

                                    <div class="col-md-12">
                                        <div>
                                        <label>@lang('modules.orders.your_vote') </label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="panel-heading col-md-12 m-b-10" >
                                                <input type="radio" name="vote" id="agree" value="agree" @if($vote === 'agree') checked @endif>
                                                <label for="agree">@lang('modules.orders.agree') </label>
                                                <label class="label label-danger m-l-10">{{$member_order->ups}}</label>
                                            </div>
                                            <div class="panel-heading col-md-12 ">
                                            <input type="radio" name="vote" id="disagree" value="disagree" @if($vote === 'disagree') checked @endif>
                                            <label for="disagree">@lang('modules.orders.disagree')</label>
                                                <label class="label label-danger m-l-10">{{$member_order->downs}}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button for="file-upload" id="save-form" class="btn btn-primary">
                                           @lang('app.save')
                                        </button>
                                    </div>
                                </form>
                            @else
                                @lang('modules.orders.order_closed')
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- .row -->
    {{-- Ajax Modal --}}
    <div class="modal fade bs-modal-md in" id="departmentModel" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-md" id="modal-data-application">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <span class="caption-subject font-red-sunglo bold uppercase" id="modelHeading"></span>
                </div>
                <div class="modal-body">
                    Loading...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn blue">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{-- Ajax Modal Ends --}}
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
