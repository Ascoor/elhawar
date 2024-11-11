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
                <li><a href="{{ route('admin.invoices.index') }}">{{ __($pageTitle) }}</a></li>
                <li class="active">@lang('app.addNew')</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection

@push('head-script')
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">

    <link rel="stylesheet"
        href="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/switchery/dist/switchery.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/select2.min.css') }}">

    <style>
        .dropdown-content {
            width: 250px;
            max-height: 250px;
            overflow-y: scroll;
            overflow-x: hidden;
        }

        #product-box .select2-results__option--highlighted[aria-selected] {
            background-color: #ffffff !important;
            color: #000000 !important;
        }

        #product-box .select2-results__option[aria-selected=true] {
            background-color: #ffffff !important;
            color: #000000 !important;
        }

        #product-box .select2-results__option[aria-selected] {
            cursor: default !important;
        }

        #selectProduct {
            width: 200px !important;
        }

    </style>
@endpush

@section('content')

    <div class="sortable">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-inverse">
                    <div class="panel-heading">@lang('modules.libraries.create')  {{ $request_type }}  @lang('modules.libraries.request')  </div>
                    <div class="panel-wrapper collapse in" aria-expanded="true">
                        <div class="panel-body">
                            {!! Form::open(['id' => 'resourceRequest', 'class' => 'ajax-form', 'method' => 'POST']) !!}
                            <div class="form-body">
                                <hr>
                                <div class="row">
                                    @if ($request_type === "turn_in")
                                        <div class="col-md-4">
                                            <label for=""> @lang('modules.libraries.select_borrowing')</label>
                                            <select class="select2 form-control" name="borrower_select"  data-placeholder="select Borrower" id="borrower-select" onchange="handleBorrowingSelect()" data-style="form-control">
                                                <option value="">--</option>
                                                @foreach ($borrowed as $borrowed_resource)
                                                <option value="{{$borrowed_resource->id}}">{{$borrowed_resource->borrower_name}}</option>
                                                @endforeach
                                            </select>
            
                                        </div>
                                    @endif
                                    <div class="col-md-4">
                                        
                                        @if($request_type === "turn_in")
                                            
                                        <label for="">@lang('modules.libraries.selected_resource')</label>
                                            <select readonly class="form-control"id="selectedResource" name="resource" >
                                                <option value="">--</option>
                                                @foreach ($borrowed as $borrowed_resource)
                                                    <option value="{{$borrowed_resource->resources}}">{{$borrowed_resource->resource_name}}</option>
                                                @endforeach
                                            </select>
                                        @else
                                        <label for="">@lang('modules.libraries.select_resource')</label>
                                        <select class="select2 form-control" name="resource"  data-placeholder="Select Product State" id="select-resource" onchange="handleResourceSelect()" data-style="form-control">
                                            <option value="">--</option>
                                            @foreach ($resources as $resource)
                                            <option value="{{$resource->id}}">{{$resource->name}}</option>
                                            @endforeach
                                        </select>
                                        @endif
                                        
        
                                    </div>
                                    <div class="col-md-2 ">
                                        @if($request_type === "turn_in")
                                            
                                        <label for="">@lang('modules.libraries.quantity') </label>
                                        <input class="form-control" id="numberofBorrowed" name = "number" type="text"  readonly>
                                            
                                        @else
                                        <label for=""> @lang('modules.libraries.available')</label>
                                        <input class="form-control" id="available" type="text" value="" disabled>
                                        @endif 
                                    </div>
                                    @if($request_type !== "turn_in")
                                    <div class="col-md-2 ">
                                        <label for=""> @lang('modules.libraries.quantity')</label>
                                        <input class="form-control" id="quan" name="number" type="number" value="1" min="1" max="1" >
                                    </div>
                                    @endif

                                    <div class="col-md-2">
                                        @if($request_type === "turn_in")
                                        <label for="">@lang('modules.libraries.due')</label>
                                        <input class="form-control" id="dueDate" type="text" value="" disabled>
                                        @else
                                        <label for="">@lang('modules.libraries.due')</label>
                                        <input type="date" class="form-control" name="date">
                                        @endif
                                    </div>
                                    </div>
                                </div>
                                <div class="row m-t-15">
                                    @if($request_type !== "turn_in")
                                        <div class="box-title">
                                            @lang('modules.libraries.borrower')
                                        </div>

                                        <div id="selectUser">

                                        </div>
{{--                                        <div class="col-md-2">--}}
{{--                                            <label for="">@lang('modules.libraries.borrower')</label>--}}
{{--                                            <select class="select form-control"  name="brrower" data-placeholder="Select Brrower"  data-style="form-control">--}}
{{--                                                <option value="">--</option>--}}
{{--                                                @foreach ($clients as $client)--}}
{{--                                                    <option value="{{$client->id}}">{{$client->name}}</option>--}}
{{--                                                @endforeach--}}

{{--                                            </select>--}}
{{--                                        </div>--}}

                                    @endif
                                </div>
                                <div class="form-actions m-t-10 col-md-12">
                                    <button type="submit" id="save-form" class="btn btn-success"> <i class="fa fa-check"></i>
                                        @lang('modules.libraries.create') </button>
                                    <a href="{{ route('admin.stocks.index') }}" class="btn btn-default">@lang('app.back')</a>
                                </div>
        
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- .row -->
    </div>



@endsection

@push('footer-script')
    <script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
  <script type="text/javascript">
    @if($request_type === "turn_in")
        function handleBorrowingSelect() {
            var resources = {
                @foreach ($borrowed as $borrowed_resource)
                "{{ $borrowed_resource->id}}" : 
                { 'resourceName' : "{{ $borrowed_resource->resource_name}}",
                    'borrowerName' : "{{ $borrowed_resource->borrower_name}}",
                    'number': "{{ $borrowed_resource->borrowed}}",
                    'due': "{{ $borrowed_resource->due_date}}",
                    'resourceId' : "{{$borrowed_resource->resources}}",
                },
                @endforeach  
                }
                let selected = document.getElementById('borrower-select').value;
                // console.log(document.getElementById('selectedResource'));
                document.getElementById('selectedResource').selectedIndex = resources[selected].resourceId;
                document.getElementById('numberofBorrowed').setAttribute('value',resources[selected].number);
                document.getElementById('dueDate').setAttribute('value',resources[selected].due);
                // console.log(resources);
     }
           
       
    @endif    
       
        $('#save-form').click(function() {
                    $.easyAjax({
                        url: '{{ route('admin.libraries.request.store', [$request_type]) }}',
                        container: '#resourceRequest',
                        type: "POST",
                        redirect: true,
                        file: true
        })
      });
      var resources = {
            @foreach ($resources as $resource)
            "{{ $resource->id}}" : "{{ $resource->item_in_stock}}", 
            @endforeach
        };
        function handleResourceSelect() {
            var resources = {
                @foreach ($resources as $resource)
                "{{ $resource->id}}" : "{{ $resource->item_in_stock}}", 
                @endforeach
            };
    
        let selectResource = document.getElementById("select-resource");
        let available = document.getElementById("available");
        let selectResourceId = selectResource.value
        // console.log("id:" , selectResourceId);
        let selectResourceValue = resources[selectResourceId];
        available.setAttribute('value', selectResourceValue);
        document.getElementById('quan').setAttribute('max',selectResourceValue)
      }
      
      
  </script>
    <script src="{{ asset('plugins/select2/select2.min.js') }}"></script>
  @include('club.select_user_script')
@endpush
