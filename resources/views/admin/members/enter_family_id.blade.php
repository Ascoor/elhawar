@extends('layouts.app')

@section('page-title')
    <div class="row bg-title">

        <!-- .page title -->
        <div class="col-lg-8 col-md-5 col-sm-6 col-xs-12 bg-title-left">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __($pageTitle) }}
                <span class="text-info b-l p-l-10 m-l-5">{{ $totalmembers }}</span> <span
                        class="font-12 text-muted m-l-5"> @lang('modules.dashboard.totalFamilies')</span>
            </h4>
        </div>
        
        <div class="col-lg-2 col-sm-6 col-md-7 col-xs-12 text-right bg-title-right">
           {{-- rola  --}}
           {{--  added the launages setting" --}} 
            @include('admin.dashboard-header.header_others');
        </div>

        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-2 col-sm-6 col-md-7 col-xs-12 text-right bg-title-right">
            <a href="{{ route('admin.members.create') }}"
               class="btn btn-outline btn-success btn-sm">@lang('modules.client.addNewClient') <i class="fa fa-plus"
                                                                                                  aria-hidden="true"></i></a>
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}">@lang('app.menu.home')</a></li>
                <li class="active">{{ __($pageTitle) }}</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
     
    </div>
    
@endsection

@push('head-script')
    {{--    <link rel="stylesheet" href="{{ asset('public/plugins/metronics/wizard-4.css') }}">--}}

    <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/summernote/dist/summernote.css') }}">
    <style>
        .salutation .form-control {
            padding: 2px 2px;
        }
        .select-category button{
            background-color: white !important;
            font-size: 13px;
            color: #565656;
            border: 1px solid #e4e7ea !important;
        }
        .select-category button:hover{
            color: #565656;
            opacity: 1;
        }

        .bootstrap-select .dropdown-toggle:focus{
            outline: none !important;
        }
    </style>

@endpush

@section('content')

    <td colspan="3" class="text-center">
        <div class="empty-space" style="height: 200px;">
            <div class="empty-space-inner">
                <div class="icon" style="font-size:30px"><i class="icon-layers"></i>
                </div>
                <div class="title m-b-15">@lang('modules.members.enter_famiy_id') </div>
                <div class="row" >
                <div class="form-group col-md-3" style="margin-left: 38%" >
                    <label for="family_id" class="required">@lang('app.family_id')</label>
{{--                    <input type="text" id="family_id" name="family_id" class="form-control" value="">--}}
                    <select class="select2 form-control client-category" data-placeholder="@lang('modules.members.choose_member')"  id="family_id" name="family_id">
                        @foreach($families as $family)
                            <option value="{{ $family->family_id}}">{{ ucwords($family->member_id) }} --- {{ ucwords($family->name) }}</option>
                        @endforeach

                    </select>
                </div>
                </div>
                <div class="subtitle">
                    <button id="save-form" class="btn btn-outline btn-success btn-sm">@lang('modules.members.add_to_family')
                        <i class="fa fa-plus" aria-hidden="true"></i></button>

                </div>
            </div>
        </div>
    </td>
{{--    <div class="row">--}}
{{--        <div class="col-xs-12">--}}
{{--            {!! Form::open(['id'=>'createClient','class'=>'ajax-form','method'=>'POST']) !!}--}}
{{--                                    <form method="POST" action="{{route('admin.members.store')}}" autocomplete="off"  id="kt_form">--}}

{{--            <div class="panel panel-inverse">--}}
{{--                <div class="panel-heading"> @lang('modules.client.createTitle')</div>--}}
{{--                <div class="panel-wrapper collapse in" aria-expanded="true">--}}
{{--                    <div class="panel-body">--}}
{{--    <div class="col-md-3">--}}
{{--        <div class="form-group">--}}
{{--            <label for="gst_number" class="required">@lang('app.family_id')</label>--}}
{{--            <input type="text" id="family_id" name="family_id" class="form-control" value="">--}}
{{--        </div>--}}
{{--        <div class="col-lg-4 col-sm-6 col-md-7 col-xs-12 text-right bg-title-right">--}}

{{--        <button    id="save-form"--}}
{{--           class="btn btn-outline btn-success btn-sm">@lang('modules.members.add_to_family') <i class="fa fa-plus"--}}
{{--                                                                                                aria-hidden="true"></i></button>--}}
{{--        </div>--}}

{{--    </div>--}}


{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            {!! Form::close() !!}--}}
{{--                                    </form>--}}
{{--        </div>--}}
{{--    </div>--}}

@endsection

@push('footer-script')
    <script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
    <script>
        $('#save-form').click(function () {
            var family_id = $('#family_id').val();
            var url = '{{route('admin.members.createToFamily' , 'family_id' )}}';
            url = url.replace('family_id', family_id);
            window.location =url;
        });
        $(".select2").select2({
            formatNoMatches: function () {
                return "{{ __('messages.noRecordFound') }}";
            }
        });
{{--        $('#save-form').click(function () {--}}
{{--$.easyAjax({--}}
{{--url: '{{route('admin.members.store')}}',--}}
{{--container: '#createClient',--}}
{{--type: "POST",--}}
{{--redirect: true,--}}
{{--data: $('#createClient').serialize()--}}
{{--})--}}
{{--});--}}
    </script>
@endpush
