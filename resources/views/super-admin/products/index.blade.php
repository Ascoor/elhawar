@extends('layouts.super-admin')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 bg-title-left">
            <h4 class="page-title"> Products
                <span class="text-info b-l p-l-10 m-l-5">15</span> <span class="font-12 text-muted m-l-5"> @lang('app.total')
                    Product</span>
            </h4>
        </div>


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
            <div class="white-box">
                <button data-toggle="collapse" data-target="#collapseInventory" aria-controls="collapseInventory"
                    class="btn btn-primary">New Product</button>
                <div id="collapseInventory" class="collapse row" aria-labelledby="headingOne">
                    <form class="row d-flex" method="POST" action="{{ route('admin.items.store') }}">
                        @csrf
                        <div class="form-group col-md-12">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="product name">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="item_in_stock">Item In Stock</label>
                            <input type="number" name="item_in_stock" class="form-control" id="item_in_stock"
                                placeholder="item in stock default is 1">
                        </div>
                        <div class="form-group col-md-6 d-flex p-2 bd-highlight">
                            <p>Select inventories that the product will be put in and set the price for each one.</p>
                            @foreach ($inventories as $inventory)
                                <div class="form-check">
                                    <input class="form-check-input" name="{{ $inventory->id }}" type="checkbox"
                                        id="{{ $inventory->id }}" data-toggle="collapse"
                                        data-target="#i{{ $inventory->id }}" aria-expanded="true"
                                        aria-controls="i{{ $inventory->id }}">

                                    <label class="form-check-label" for="{{ $inventory->id }}">
                                        {{ $inventory->name }}
                                    </label>
                                    <input type="text" class="collapse collapse-horizontal collapse"
                                        name="i{{ $inventory->id }}" aria-labelledby="i{{ $inventory->id }}"
                                        id="i{{ $inventory->id }}" placeholder="Price">

                                </div>
                            @endforeach


                        </div>
                        <div class="form-group col-md-6">
                            <label for="status">Product Status</label>
                            <select name="status" id="status" class="form-">
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}">{{ $status->status }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModal">
                                select product category
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <select name="category" id="">
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6"><button type="submit" class="btn btn-primary mb-2">Add</button></div>
                    </form>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Product</th>
                            <th scope="col">Inventory Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Product Status</th>
                            <th scope="col">Category</th>

                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <th scope="row">{{ $product->id }}</th>
                                <td scope="row">{{ $product->name }}</td>
                                <td scope="row">
                                    <a href="{{ route('admin.stocks.show', $product->inventory_id) }}">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                    {{ $product->inventory_name }}
                                </td>
                                <td scope="row">{{ $product->price }}</td>
                                <td scope="row">{{ $product->status }}</td>
                                <td scope="row">
                                    <a href="{{ route('admin.categories.show', $product->category_id) }}">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                    {{ $product->category_name }}
                                </td>
                                <td><a href="{{ route('admin.products.show', $product->id) }}"><i class="fa fa-eye"
                                            aria-hidden="true"></i></a>
                                    <a href="{{ route('admin.products.edit', $product->id) }}">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>

                        @endforeach
                    </tbody>
                </table>


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
