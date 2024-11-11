@extends('layouts.app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 bg-title-left">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __($pageTitle) }}
                <span class="m-l-10 text-info" id="total-employee">{{ 2 }}</span> <span
                        class="font-12 text-muted m-l-5">@lang('modules.stocks.inventories')</span>
            </h4>

        </div>

        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12 text-right bg-title-right">
            @if($user->cans('edit_inventories'))
                <div data-toggle="modal" class="btn btn-outline btn-success  btn-sm" data-target="#move">
                    @lang('modules.stocks.move_products')
                    <i class="fa fa-plus"
                    aria-hidden="true"></i>
                </div>
            @endif
            <!-- Modal -->
            <div class="modal fade text-left" id="move" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><p>Select inventories that the product will be put in and set the price for each one.</p></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{route('admin.stocks.move-products',['id'=> $inventory->id])}}" method="POST" class="row">
                            @csrf
                            <div class="modal-body row">
                                <div class="col-md-6" >
                                    Select Product
                                    <select class="form-control select2" name="product" id="">
                                        @foreach ($products as $product)
                                            <option value="{{$product->id}}">{{$product->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6" >
                                    Select Inventory
                                    <select class="form-control select2" name="inventory" id="">
                                        @foreach ($other_inventories as $inventory)
                                            <option value="{{$inventory->id}}">{{$inventory->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6" >
                                    Qty
                                    <input type="number" name="quantity" class="form-control" placeholder="Quantity" min="0">

                                </div>

                            </div>
                            <div class="modal-footer">

                                <input type="submit" class="btn btn-primary" value="Save changes"/>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}">@lang('app.menu.stocks')</a></li>
                <li class="active">{{ __($pageTitle) }}</li>
            </ol>
        </div>

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
                <div class="row panel-heading m-b-10">
                    <div class="col-md-6">
                        <div> {{ $inventory->name }}</div>
                    </div>
                    <div class="col-md-6">
                        <div> {{ $inventory->description }}</div>
                    </div>

                </div>
                <div class="white-box">
                    <h4> @lang('modules.stocks.inventory_products')</h4>
                    @if ( count($products))
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">@lang('modules.stocks.product')</th>

                                    <th scope="col">@lang('modules.stocks.price')</th>

                                    <th scope="col">@lang('modules.stocks.category')</th>

                                    <th>@lang('app.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <th scope="row">{{ $product->id }}</th>
                                        <td scope="row">{{ $product->name }}</td>

                                        <td scope="row">{{ $product->price }}</td>

                                        <td scope="row">
                                            <a href="{{ route('admin.categories.show', $product->category_id) }}">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                            </a>
                                            {{ $product->category_name }}
                                        </td>
                                        <td>
                                            @if($user->cans('edit_inventories'))
                                                
                                            <a href="{{ route('admin.items.edit', $product->id) }}">
                                               <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                           </a></td>
                                            @endif
                                    </tr>

                                @endforeach
                            </tbody>
                        </table>
                    @else
                    <h3>@lang('modules.stocks.no_products')</h3>    
                    @endif
                    
                </div>

            </div>
        </div>
        <!-- .row -->

    @endsection


    @push('footer-script')
        <script src="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
        <script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
        <script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
        <script src="{{ asset('plugins/bower_components/summernote/dist/summernote.min.js') }}"></script>>
    @endpush
