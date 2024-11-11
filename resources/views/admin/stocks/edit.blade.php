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
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection

@push('head-script')
    <link rel="stylesheet"
        href="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/summernote/dist/summernote.css') }}">

@endpush

@section('content')

    <div class="row">
        <div class="col-xs-12">

            <div class="panel panel-inverse">
                <div class="panel-heading">@lang('app.update') @lang('modules.stocks.stock') [ {{ $inventory->name }} ]</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        {!! Form::open(['id' => 'updateCategory', 'class' => 'ajax-form', 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
                        <div class="form-body">
                            <div class="col-md-12">
                                <div class="form-group col-md-6">
                                    <label for="name">  @lang('modules.stocks.name')</label>
                                    <input type="text" name="name" class="form-control" id="name"
                                        value="{{ $inventory->name }}" placeholder="@lang('modules.stocks.name')">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="description"> @lang('modules.stocks.description')</label>
                                    <input type="text" name="description" class="form-control" id="description"
                                        value="{{ $inventory->description }}" placeholder="@lang('modules.stocks.description')">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="location">  @lang('modules.stocks.location')</label>
                                    <input type="text" name="location" class="form-control" id="location"
                                        value="{{ $inventory->location }}" placeholder=" @lang('modules.stocks.location')">
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" id="save-form" class="btn btn-success"> <i class="fa fa-check"></i>
                                    @lang('app.update')</button>
                                <a href="{{ route('admin.stocks.index') }}" class="btn btn-default">@lang('app.back')</a>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- .row -->

    @endsection

    @push('footer-script')

        <script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
        <script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
        <script>
            $('#save-form').click(function() {
                $.easyAjax({
                    url: '{{ route('admin.stocks.update', [$inventory->id]) }}',
                    container: '#updateCategory',
                    type: "POST",
                    redirect: true,
                    file: true
                })
            });

            $(".select2").select2({
                formatNoMatches: function() {
                    return "{{ __('messages.noRecordFound') }}";
                }
            });
        </script>

    @endpush
