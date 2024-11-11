@extends('layouts.app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="row bg-title">
            <!-- .page title -->
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 bg-title-left">
                <h4 class="page-title"> Products
                    <span class="text-info b-l p-l-10 m-l-5">15</span> <span class="font-12 text-muted m-l-5">
                        @lang('app.total')
                        Product</span>
                </h4>
            </div>


        </div>

        <!-- .breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12 text-right bg-title-right">


            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}">@lang('app.menu.home')</a></li>
                <li class="active">{{ __($pageTitle) }}</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection

@push('head-script')
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/html5-editor/bootstrap-wysihtml5.css') }}">

@endpush
@section('content')

    <div class="row">
        <div class="col-xs-12">

            <div class="panel panel-inverse">
                <div class="panel-heading">@lang('app.update') @lang('modules.stocks.product') [ {{ $product->name }} ]


                </div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        {!! Form::open(['id' => 'updateCategory', 'class' => 'ajax-form', 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
                        <div class="form-body">
                            <input type="text" name="product" value="{{ $product->product }}" hidden
                           >
                            <h3 class="box-title">@lang('app.menu.products') @lang('app.details')</h3>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">  @lang('modules.stocks.name')</label>
                                    <input type="text" name="name" value="{{ $product->name }}" class="form-control"
                                        id="name" placeholder="@lang('modules.stocks.name')">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="item_in_stock">@lang('modules.stocks.item_in_stock')</label>
                                    <input type="number" value="{{ $product->item_in_stock }}" name="item_in_stock"
                                        class="form-control" id="item_in_stock" placeholder="@lang('modules.stocks.item_in_stock')">
                                </div>
                            </div>
                           
                            
                            <div class="form-group col-md-6">
                                <label for=""> @lang('modules.productCategory.productSubCategory')</label>
                                <select class="select2 form-control" name="category" id="">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">@lang('modules.stocks.price') </label>
                                <input type="number" value="{{ $product->price }}" name="price"
                                        class="form-control" id="price" placeholder="@lang('modules.stocks.price')">
                            </div>
                            <div class="form-group col-md-4 ">
                                <div class="form-group">

                                    <div class="checkbox checkbox-info">
                                        <input id="purchase_allow" name="purchase_allow" value="1"
                                               type="checkbox" @if ($product->allow_purchase) checked @endif>
                                        <label for="purchase_allow">@lang('app.purchaseAllow')</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions m-b-10 col-md-12">
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
                    url: '{{ route('admin.items.update', [$product->id]) }}',
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
