@extends('layouts.app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 bg-title-left">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __('app.menu.assessments') }}</h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12 bg-title-right">
            <ol class="breadcrumb">

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

    <div class="row">
        <div class="col-xs-12">

            <div class="panel panel-inverse">
                <div class="panel-heading"> @lang('modules.members.showAssessment')</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <div class="form-body">
                            <h3 class="box-title ">@lang('modules.members.assessmentDetails')</h3>
                            <hr>


                            <div class="row">
                                <div class="col-md-3 ">
                                    <div class="form-group">
                                        <label >@lang('modules.club.for_player')</label>
                                        <p>{{$player->name}}</p>
                                    </div>
                                </div>
                                <div class="col-md-3 ">
                                    <div class="form-group">
                                        <label >@lang('app.assessmentName')</label>
                                        <p>{{$assessment->name}}</p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label >@lang('app.date')</label>
                                        <p>{{$assessment->at_date}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                @if($assessment->injuries)
                                <div class="col-md-3 ">
                                    <div class="form-group">
                                        <label >@lang('modules.club.injuries')</label>
                                        <p>{!! $assessment->injuries !!}</p>
                                    </div>
                                </div>
                                @endif
                                @if($assessment->injuries_effect)
                                <div class="col-xs-12">
                                    <label>@lang('modules.club.injuries_effect')</label>
                                    <div class="form-group">
                                        <p>{!! $assessment->injuries_effect !!}</p>
                                    </div>
                                </div>
                                @endif
                                @if($assessment->physical_assessment)
                                <div class="col-xs-12">
                                    <label>@lang('modules.club.physical_assess')</label>
                                    <div class="form-group">
                                        <p>{!! $assessment->physical_assessment !!}</p>
                                    </div>
                                </div>
                                @endif
                                @if($assessment->skills_assessment)
                                <div class="col-xs-12">
                                    <label>@lang('modules.club.skills_assess')</label>
                                    <div class="form-group">
                                        <p>{!! $assessment->skills_assessment !!}</p>
                                    </div>
                                </div>
                                @endif
                            </div>


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>    <!-- .row -->

@endsection


@push('footer-script')
    <script src="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/summernote/dist/summernote.min.js') }}"></script>
    {{--<script src="{{ asset('public/plugins/metronics/add-user.js') }}"></script>--}}

@endpush

