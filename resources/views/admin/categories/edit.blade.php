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
                <li><a href="{{ route('admin.clients.index') }}">{{ __($pageTitle) }}</a></li>
                <li class="active">@lang('app.edit')</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection

@push('head-script')
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
@endpush

@section('content')

    <div class="row">
        <div class="col-xs-12">

            <div class="panel panel-inverse">
                <div class="panel-heading">@lang('app.update') @lang('app.category') [ {{ $category->name }} ]


                </div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        {!! Form::open(['id' => 'updateCategory', 'class' => 'ajax-form', 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">@lang('modules.stocks.category_name')</label>
                                        <input type="text" id="name" name="name" value="{{ $category->name }}"
                                            placeholder="@lang('modules.stocks.category_name')" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('modules.stocks.category_description')</label>
                                        <input type="text" name="description" id="description"
                                            value="{{ $category->description }}" placeholder="@lang('modules.stocks.category_description')"
                                            class="form-control">
                                    </div>
                                </div>

                            </div>
                            <h3 class="box-title"> @lang('modules.stocks.sub_categories')</h3>

                            <div>

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">@lang('modules.stocks.sub_categories')</th>
                                            <th scope="col">  @lang('modules.stocks.category')</th>
                                            <th>  @lang('modules.stocks.actions')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sub_categories as $sub_category)
                                            <tr>
                                                <th scope="row">{{ $sub_category->id }}</th>
                                                <td scope="row">{{ $sub_category->name }}</td>
                                                <td>{{ $sub_category->description }}</td>
                                                <td><a href=""><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                    <a href="{{ route('admin.categories.edit', $sub_category->id) }}">
                                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <h3 class="box-title" data-toggle="collapse" data-target="#collapseForm"
                                aria-controls="collapseForm" aria-expanded="true">
                                  @lang('modules.stocks.add_sub_cat')</h3>

                            <div id="collapseForm" aria-labelledby="collapseForm" class="collapse row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">  @lang('modules.stocks.sub_category_name')</label>
                                        <input type="text" id="sub_category_name" name="sub_category_name"
                                            placeholder="@lang('modules.stocks.sub_category_name')" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>  @lang('modules.stocks.sub_category_desc')</label>
                                        <input type="text" name="sub_category_description" id="sub_category_description"
                                            placeholder="@lang('modules.stocks.sub_category_desc')" class="form-control">
                                    </div>
                                </div>

                            </div>

                            <div class="form-actions">
                                <button type="submit" id="save-form" class="btn btn-success"> <i class="fa fa-check"></i>
                                    @lang('app.update')</button>
                                <a href="{{ route('admin.categories.index') }}"
                                    class="btn btn-default">@lang('app.back')</a>
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
                    url: '{{ route('admin.categories.update', [$category->id]) }}',
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
