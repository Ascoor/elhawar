@extends('layouts.app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-8 col-md-4 col-sm-4 col-xs-12 bg-title-left">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __($pageTitle) }}
                <span class="m-l-10 text-info" id="total-employee">{{ $totalProducts }}</span> <span
                        class="font-12 text-muted m-l-5">@lang('modules.stocks.products')</span>
            </h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-4 col-sm-8 col-md-8 col-xs-12 text-right bg-title-right">

            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}">@lang('app.menu.stocks')</a></li>
                <li class="active">{{ __($pageTitle) }}</li>
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
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/multiselect/css/multi-select.css') }}">
@endpush
@section('filter-section')
    <form action="" id="filter-form">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label">@lang('modules.productCategory.category')</label>
                    <select class="select2 form-control" name="category_id" id="category_id" data-style="form-control">
                        <option selected value="all">@lang('app.all')</option>
                        @forelse($categories as $category)
                            <option value="{{ $category->id }}">{{ ucwords($category->name) }}</option>
                        @empty
                            <option value="">@lang('messages.noProductCategory')</option>
                        @endforelse
                    </select>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label">@lang('modules.stocks.inventory')</label>
                    <select class="select2 form-control" name="inventory_id" id="inventory_id" data-style="form-control">
                        <option selected value="all">@lang('app.all')</option>
                        @forelse($inventories as $inventory)
                            <option value="{{ $inventory->id }}">{{ ucwords($inventory->name) }}</option>
                        @empty
                            <option value="">@lang('messages.noProductCategory')</option>
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label">@lang('modules.stocks.state')</label>
                    <select class="select2 form-control" name="state" id="state" data-style="form-control">
                        <option selected value="all">@lang('app.all')</option>
                        <option value="expired">@lang('modules.stocks.expired')</option>
                        <option value="not-expired">@lang('modules.stocks.not_expired')</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group p-t-10">
                    <button type="button" class="btn btn-success" id="apply-filters"><i class="fa fa-check"></i>
                        @lang('app.apply')
                    </button>
                    <button type="button" id="reset-filters" class="btn btn-inverse"><i class="fa fa-refresh"></i>
                        @lang('app.reset')</button>
                </div>
            </div>

        </div>
    </form>
@endsection
@section('content')

    <div class="row">
        @if(Session::has('successful_message'))
        <div class="alert alert-success">
        {{ Session::get('successful_message') }}
        </div>
        @elseif(Session::has('error'))
        <div class="alert alert-danger">
            {{ Session::get('error') }}
            </div>
        @endif
        <div class="col-xs-12">
            <div class="white-box">
                @if($user->cans('add_inventories'))
                    <button data-toggle="collapse" data-target="#collapseInventory" aria-controls="collapseInventory" class="btn btn-outline btn-success btn-sm m-b-10">  
                        @lang('app.addNew') @lang('app.menu.products')
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </button>
                    <div id="collapseInventory" class="collapse row" aria-labelledby="headingOne">
                    <form id="createItem" class="row d-flex" method="POST" action="{{ route('admin.items.store') }}">
                        @csrf
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">  @lang('modules.stocks.name')</label>
                                <input type="text" name="name" class="form-control" id="name" placeholder=@lang('modules.stocks.product')>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            {{-- <label> </label> --}}
                            <label > 
                                @lang('modules.stocks.category') 
                                <a href="javascript:;" id="addProjectCategory" class="text-info">
                                    <i class="ti-settings text-info"></i>
                                </a>
                            </label>
                            <select class="select2 form-control" name="category" id="">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>
                        <div class="form-group col-md-2 m-t-15 bd-highlight">
                            <!-- Button trigger modal -->
                            <div data-toggle="modal" class="btn btn-danger" data-target="#inventoreis">
                                <i class="ti-settings text-white"></i>   @lang('modules.stocks.inventory_data')
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="inventoreis" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel"><p> @lang('modules.stocks.inventory_modal')</p></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body row">
                                            @foreach ($inventories as $inventory)
                                                <div class="form-check col-md-6">
                                                    <input class="form-check-input" name="{{ $inventory->id }}" type="checkbox"
                                                           id="{{ $inventory->id }}" data-toggle="collapse"
                                                           data-target="#i{{ $inventory->id }}" aria-expanded="true"
                                                           aria-controls="i{{ $inventory->id }}">

                                                    <label class="form-check-label" for="{{ $inventory->id }}">
                                                        {{ $inventory->name }}
                                                    </label>
                                                    {{-- <div class="collapse collapse-horizontal collapse" id="i{{ $inventory->id }}" aria-labelledby="i{{ $inventory->id }}"> --}}
                                                    <div id="i{{ $inventory->id }}" aria-labelledby="i{{ $inventory->id }}">
                                                        <input type="number" name="s{{ $inventory->id }}" min="1" placeholder=@lang("modules.stocks.item_in_stock")>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="form-group col-md-3">
                            <label>@lang("app.price")</label>
                            <input class="form-control" placeholder=@lang("app.price") type="number"  name="price">
                        </div>
                        <div class="form-group col-md-3">
                            <label>@lang("modules.stocks.expiration_date")</label>
                            <input class="form-control" placeholder="expiration date" type="date"  name="expiration_date">
                        </div>
                        <div class="form-group col-md-3 m-t-15">
                            <div class="form-group">

                                <div class="checkbox checkbox-info">
                                    <input id="purchase_allow" name="purchase_allow" value="1"
                                           type="checkbox">
                                    <label for="purchase_allow">@lang('app.purchaseAllow')</label>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-12 m-b-10"><button type="submit" class="btn btn-primary mb-2">@lang('app.add')</button></div>
                    </form>
                </div>
                @endif
                <div class="table-responsive">
                    {!! $dataTable->table(['class' => 'table table-bordered table-hover toggle-circle default footable-loaded footable']) !!}
                </div>

            </div>

        </div>
    </div>
    <!-- .row -->
    <div class="modal fade bs-modal-md in" id="taxModal" role="dialog" aria-labelledby="myModalLabel"
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
@endsection

@push('footer-script')
    <script src="{{ asset('plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script>
    <script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/multiselect/js/jquery.multi-select.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('js/datatables/buttons.server-side.js') }}"></script>
    {!! $dataTable->scripts() !!}
    <script>
        $('#createItem').on('click', '#addProjectCategory', function () {

        var url = '{{ route('admin.categories.create')}}';
        $('#modelHeading').html('Manage Project Category');
        $.ajaxModal('#taxModal', url);
        });
        $('#products-table').on('preXhr.dt', function (e, settings, data) {
            var startDate = $('#start-date').val();
            if (startDate == '') {
                startDate = null;
            }
            var endDate = $('#end-date').val();
            if (endDate == '') {
                endDate = null;
            }
            var category_id = $('#category_id').val();
            var projectID = $('#projectID').val();
            if (!projectID) {
                projectID = 'all';
            }
            var inventory_id = $('#inventory_id').val();
            var state = $('#state').val();
            data['startDate'] = startDate;
            data['endDate'] = endDate;
            data['category_id'] = category_id;
            data['projectID'] = projectID;
            data['state'] = state;
        });
        function loadTable(){
            window.LaravelDataTables["products-table"].draw();
        }
        $('.toggle-filter').click(function () {
            $('#ticket-filters').toggle('slide');
        })
        $('#apply-filters').click(function () {
            loadTable();
        });
        $('#reset-filters').click(function () {
            $('#filter-form')[0].reset();
            $('#category_id').val('all');
            $('#state').val('all');
            $('#status').selectpicker('render');
            $('#projectID').select2();
            $('#reportrange span').html('');
            loadTable();
        })

        $('#apply-filters').click(function () {
            loadTable();
        });
        $('#reset-filters').click(function () {
            $('#filter-form')[0].reset();
            $('#category_id').val('all');
            $('#state').val('all');
            $('#status').selectpicker('render');
            $('#projectID').select2();
            $('#reportrange span').html('');
            loadTable();
        })
    </script>


@endpush
