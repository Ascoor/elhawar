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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
    <style>
        ul {
            list-style-type: none;
        }

        .fa-check {
            color: green;
        }

        .fa-times {
            color: red;
        }

    </style>
@endpush

@section('content')

    <div class="row">

        <div class="col-xs-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                   <div class="row">
                    <div class="col-md-6 my-5">
                        <div> @lang('modules.stocks.category_name') : {{ $category->name }}</div>
                    </div>
                    <div class="col-md-6">
                        <div> @lang('modules.stocks.category_description'): {{ $category->description }}</div>
                    </div>
                   </div>
                </div>


                <div class="white-box">
                    <h4> @lang('modules.stocks.category_products')</h4>
                    @if (count($products))
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">  @lang('modules.stocks.product')</th>
                                <th scope="col">    @lang('modules.stocks.inventory_name')</th>
                                <th scope="col">  @lang('modules.stocks.price')</th>

                                <th scope="col">  @lang('modules.stocks.category')</th>              
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <th scope="row">{{ $product->id }}</th>
                                    <td scope="row">{{ $product->name }}</td>
                                    <td scope="row">
                                        <a href="{{ route('admin.stocks.show', $product->inventory_id) }}"><i
                                                class="fa fa-eye" aria-hidden="true"></i></a>
                                        {{ $product->inventory_name }}
                                    </td>
                                    <td scope="row">{{ $product->price }}</td>

                                    <td scope="row">{{ $product->category_name }}</td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <h5>@lang('modules.stocks.no_cat_products')</h5>    
                    @endif
                </div>
                <div class="white-box">
                    <h3 class="box-title">    @lang('modules.stocks.sub_categories')</h3>
                    <div>
                        @if (count($sub_categories))
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col"> @lang('modules.stocks.category')</th>
                                        <th scope="col">  @lang('modules.stocks.description')</th>
                                        <th>@lang('modules.stocks.actions')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sub_categories as $sub_category)
                                        <tr>
                                            <th scope="row">{{ $sub_category->id }}</th>
                                            <td scope="row">{{ $sub_category->name }}</td>
                                            <td>{{ $sub_category->description }}</td>
                                            <td><a href=""><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                @if($user->cans('edit_inventories'))
                                                <a href="{{ route('admin.categories.edit', $sub_category->id) }}">
                                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                           <h5>@lang('modules.stocks.no_sub')</h5>   
                        @endif
                    </div>
                </div>

            </div>
        </div>
        <!-- .row -->

    @endsection

    @push('footer-script')
        <script src="{{ asset('plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script>
        <script>


        </script>
    @endpush
