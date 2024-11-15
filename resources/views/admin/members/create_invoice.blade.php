<style>
    #members .select2-container{
        width: 537px !important;
    }
</style>
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

    <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
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
            cursor:default !important;
        }
        #selectProduct {
            width: 200px !important;
        }
    </style>
@endpush

@section('content')

    <div class="row">
        <div class="col-xs-12">

            <div class="panel panel-inverse">
                <div class="panel-heading"> @lang('modules.invoices.addInvoice')</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        {!! Form::open(['id'=>'storePayments','class'=>'ajax-form','method'=>'POST']) !!}
                        <div class="form-body">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">@lang('app.invoice') #</label>
                                        <div>
                                            <div class="input-group">
                                                <div class="input-group-addon"><span class="invoicePrefix" data-prefix="{{ $invoiceSetting->invoice_prefix }}">{{ $invoiceSetting->invoice_prefix }}</span>#<span class="noOfZero" data-zero="{{ $invoiceSetting->invoice_digit }}">{{ $zero }}</span></div>
                                                <input type="text"  class="form-control readonly-background" readonly name="invoice_number" id="invoice_number" value="@if(is_null($lastInvoice))1 @else{{ ($lastInvoice) }}@endif">
                                            </div>
                                        </div>
                                    </div>

                                </div>



                            </div>
                            <h3 class="box-title ">@lang('app.select') @lang('modules.members.user')</h3>
                            <hr>
                            <div class="row">

                                <div class="col-xs-6 col-md-3">
                                    <div class="radio radio-info">
                                        <input id="employees_butt" name="membership" value="1"
                                               type="radio" checked="checked">
                                        <label for="employees_butt">@lang('app.membershipRenew')</label>
                                    </div>
                                </div>

                                <div class="col-xs-6 col-md-3">
                                    <div class="radio radio-info">
                                        <input id="members_butt" name="membership" value="0"
                                               type="radio">
                                        <label for="members_butt">@lang('app.menu.members')</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"  id="employees">
                                    <div class="form-group">
                                        <label>@lang('app.category')</label>
                                        <select class="form-control" name="category_id" id="category_id">
                                            <option value="">--</option>
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{ ucwords($category->category_name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div id="members" style="display: none">
                                    <div class="form-group" >
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div>
                                                        <label >@lang('app.member_id') </label>
                                                    </div>
                                                    <select id="selectMember"  name="user_id" class="select2 form-control" >
                                                    </select>
                                                </div>


                                            </div>

                                        </div>

                                    </div>
{{--                                    <div class="col-md-4" >--}}
{{--                                        <div class="form-group">--}}
{{--                                            <label for="">@lang('app.member_id')--}}
{{--                                            </label>--}}
{{--                                            <input type="text" id="member_id" name="member_id" class="form-control" value="">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">

                                    <div class="form-group" >
                                        <label class="control-label">@lang('modules.invoices.invoiceDate')</label>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="input-icon">
                                                    <input type="text" class="form-control" name="issue_date" id="invoice_date" value="{{ Carbon\Carbon::today()->format($global->date_format) }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">@lang('app.dueDate')</label>
                                        <div class="input-icon">
                                            <input type="text" class="form-control" name="due_date" id="due_date" value="{{ Carbon\Carbon::today()->addDays($invoiceSetting->due_after)->format($global->date_format) }}">
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">@lang('modules.invoices.currency')</label>
                                        <select class="form-control select2" name="currency_id" id="currency_id">
                                            @foreach($currencies as $currency)
                                                <option value="{{ $currency->id }}" @if($global->currency_id == $currency->id) selected @endif>{{ $currency->currency_symbol.' ('.$currency->currency_code.')' }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">@lang('modules.invoices.showShippingAddress')
                                            <a class="mytooltip" href="javascript:void(0)">
                                                <i class="fa fa-info-circle"></i>
                                                <span class="tooltip-content5">
                                                        <span class="tooltip-text3">
                                                            <span class="tooltip-inner2">
                                                                @lang('modules.invoices.showShippingAddressInfo')
                                                            </span>
                                                        </span>
                                                    </span>
                                            </a>
                                        </label>
                                        <div class="switchery-demo">
                                            <input type="checkbox" id="show_shipping_address" name="show_shipping_address" class="js-switch " data-color="#00c292" data-secondary-color="#f96262" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div id="shippingAddress">

                                    </div>
                                </div>
                            </div>

                            @if(count($fields) > 0)
                                <h3 class="box-title">@lang('modules.projects.otherInfo')</h3>
                                <div class="row">
                                    @foreach($fields as $field)
                                        <div class="col-md-3">
                                            <label>{{ ucfirst($field->label) }}</label>
                                            <div class="form-group">
                                                @if( $field->type == 'text')
                                                    <input type="text" name="custom_fields_data[{{$field->name.'_'.$field->id}}]" class="form-control" placeholder="{{$field->label}}" value="{{$editUser->custom_fields_data['field_'.$field->id] ?? ''}}">
                                                @elseif($field->type == 'password')
                                                    <input type="password" name="custom_fields_data[{{$field->name.'_'.$field->id}}]" class="form-control" placeholder="{{$field->label}}" value="{{$editUser->custom_fields_data['field_'.$field->id] ?? ''}}">
                                                @elseif($field->type == 'number')
                                                    <input type="number" name="custom_fields_data[{{$field->name.'_'.$field->id}}]" class="form-control" placeholder="{{$field->label}}" value="{{$editUser->custom_fields_data['field_'.$field->id] ?? ''}}">

                                                @elseif($field->type == 'textarea')
                                                    <textarea name="custom_fields_data[{{$field->name.'_'.$field->id}}]" class="form-control" id="{{$field->name}}" cols="3">{{$editUser->custom_fields_data['field_'.$field->id] ?? ''}}</textarea>

                                                @elseif($field->type == 'radio')
                                                    <div class="radio-list">
                                                        @foreach($field->values as $key=>$value)
                                                            <label class="radio-inline @if($key == 0) p-0 @endif">
                                                                <div class="radio radio-info">
                                                                    <input type="radio" name="custom_fields_data[{{$field->name.'_'.$field->id}}]" id="optionsRadios{{$key.$field->id}}" value="{{$value}}" @if(isset($editUser) && $editUser->custom_fields_data['field_'.$field->id] == $value) checked @elseif($key==0) checked @endif>>
                                                                    <label for="optionsRadios{{$key.$field->id}}">{{$value}}</label>
                                                                </div>
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                @elseif($field->type == 'select')
                                                    {!! Form::select('custom_fields_data['.$field->name.'_'.$field->id.']',
                                                            $field->values,
                                                            isset($editUser)?$editUser->custom_fields_data['field_'.$field->id]:'',['class' => 'form-control gender'])
                                                    !!}

                                                @elseif($field->type == 'checkbox')
                                                    <div class="mt-checkbox-inline custom-checkbox checkbox-{{$field->id}}">
                                                        <input type="hidden" name="custom_fields_data[{{$field->name.'_'.$field->id}}]"
                                                               id="{{$field->name.'_'.$field->id}}" value=" ">
                                                        @foreach($field->values as $key => $value)
                                                            <label class="mt-checkbox mt-checkbox-outline">
                                                                <input name="{{$field->name.'_'.$field->id}}[]"
                                                                       type="checkbox" onchange="checkboxChange('checkbox-{{$field->id}}', '{{$field->name.'_'.$field->id}}')" value="{{$value}}"> {{$value}}
                                                                <span></span>
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                @elseif($field->type == 'date')
                                                    <input type="text" class="form-control date-picker" size="16" name="custom_fields_data[{{$field->name.'_'.$field->id}}]"
                                                           value="{{ isset($editUser->dob)?Carbon\Carbon::parse($editUser->dob)->format('Y-m-d'):Carbon\Carbon::now()->format($global->date_format)}}">
                                                @endif
                                                <div class="form-control-focus"> </div>
                                                <span class="help-block"></span>

                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            @endif

                            <hr>
                            @if(in_array('products', $modules))
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group m-b-10 product-select" id="product-select">
                                            <select id="selectProduct" name="select"  data-placeholder="Select a product">
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="row">

                                <div class="col-xs-12  visible-md visible-lg">

                                    <div class="@if($invoiceSetting->hsn_sac_code_show) col-md-3 @else col-md-4 @endif font-bold" style="padding: 8px 15px">
                                        @lang('modules.invoices.item')
                                    </div>

                                    @if($invoiceSetting->hsn_sac_code_show)
                                        <div class="col-md-1 font-bold" style="padding: 8px 15px">
                                            @lang('modules.invoices.hsnSacCode')
                                        </div>
                                    @endif

                                    <div class="col-md-1 font-bold" style="padding: 8px 15px">
                                        @lang('modules.invoices.qty')
                                    </div>

                                    <div class="col-md-2 font-bold" style="padding: 8px 15px">
                                        @lang('modules.invoices.unitPrice')
                                    </div>

                                    <div class="col-md-2 font-bold" style="padding: 8px 15px">
                                        @lang('modules.invoices.tax') <a href="javascript:;" id="tax-settings" ><i class="ti-settings text-info"></i></a>
                                    </div>

                                    <div class="col-md-2 text-center font-bold" style="padding: 8px 15px">
                                        @lang('modules.invoices.amount')
                                    </div>

                                    <div class="col-md-1" style="padding: 8px 15px">
                                        &nbsp;
                                    </div>

                                </div>

                                <div id="sortable">
                                    <div class="col-xs-12 item-row margin-top-5">

                                        <div class="col-md-3">
                                            <div class="row">
                                                <div class="form-group">
                                                    <label class="control-label hidden-md hidden-lg">@lang('modules.invoices.item')</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></div>
                                                        <input type="text" class="form-control item_name" name="item_name[]">
                                                        <input type="number"  name="item_id[]" hidden>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <textarea name="item_summary[]" class="form-control" placeholder="@lang('app.description')" rows="2"></textarea>
                                                </div>
                                            </div>

                                        </div>
                                        @if($invoiceSetting->hsn_sac_code_show)
                                            <div class="col-md-1">
                                                <label class="control-label hidden-md hidden-lg">@lang('modules.invoices.hsnSacCode')</label>
                                                <input type="text" class="form-control" name="hsn_sac_code[]" >

                                            </div>
                                        @endif

                                        <div class="col-md-1">

                                            <div class="form-group">
                                                <label class="control-label hidden-md hidden-lg">@lang('modules.invoices.qty')</label>
                                                <input type="number" min="1" class="form-control quantity" value="1" name="quantity[]" >
                                            </div>


                                        </div>

                                        <div class="col-md-2">
                                            <div class="row">
                                                <div class="form-group">
                                                    <label class="control-label hidden-md hidden-lg">@lang('modules.invoices.unitPrice')</label>
                                                    <input type="text"  class="form-control cost_per_item" name="cost_per_item[]" value="0" >
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-md-2">

                                            <div class="form-group">
                                                <label class="control-label hidden-md hidden-lg">@lang('modules.invoices.type')</label>
                                                <select id="multiselect" name="taxes[0][]"  multiple="multiple" class="selectpicker form-control type">
                                                    @foreach($taxes as $tax)
                                                        <option data-rate="{{ $tax->rate_percent }}" value="{{ $tax->id }}">{{ $tax->tax_name }}: {{ $tax->rate_percent }}%</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>

                                        <div class="col-md-2 border-dark  text-center">
                                            <label class="control-label hidden-md hidden-lg">@lang('modules.invoices.amount')</label>

                                            <p class="form-control-static"><span class="amount-html">0.00</span></p>
                                            <input type="hidden" class="amount" name="amount[]" value="0">
                                        </div>

                                        <div class="col-md-1 text-right visible-md visible-lg">
                                            <button type="button" class="btn remove-item btn-circle btn-danger"><i class="fa fa-remove"></i></button>
                                        </div>
                                        <div class="col-md-1 hidden-md hidden-lg">
                                            <div class="row">
                                                <button type="button" class="btn btn-circle remove-item btn-danger"><i class="fa fa-remove"></i> @lang('app.remove')</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>


                                <div class="col-xs-12 m-t-5">
                                    <button type="button" class="btn btn-info" id="add-item"><i class="fa fa-plus"></i> @lang('modules.invoices.addItem')</button>
                                </div>

                                <div class="col-xs-12 ">


                                    <div class="row">
                                        <div class="col-md-offset-9 col-xs-6 col-md-1 text-right p-t-10" >@lang('modules.invoices.subTotal')</div>

                                        <p class="form-control-static col-xs-6 col-md-2" >
                                            <span class="sub-total">0.00</span>
                                        </p>


                                        <input type="hidden" class="sub-total-field" name="sub_total" value="0">
                                    </div>

                                    <div class="row">
                                        <div class="col-md-offset-9 col-md-1 text-right p-t-10">
                                            @lang('modules.invoices.discount')
                                        </div>
                                        <div class="form-group col-xs-6 col-md-1" >
                                            <input type="number" min="0" value="0" name="discount_value" class="form-control discount_value">
                                        </div>
                                        <div class="form-group col-xs-6 col-md-1" >
                                            <select class="form-control" name="discount_type" id="discount_type">
                                                <option value="percent">%</option>
                                                <option value="fixed">@lang('modules.invoices.amount')</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row m-t-5" id="invoice-taxes">
                                        <div class="col-md-offset-9 col-md-1 text-right p-t-10">
                                            @lang('modules.invoices.tax')
                                        </div>

                                        <p class="form-control-static col-xs-6 col-md-2" >
                                            <span class="tax-percent">0.00</span>
                                        </p>
                                    </div>

                                    <div class="row m-t-5 font-bold">
                                        <div class="col-md-offset-9 col-md-1 col-xs-6 text-right p-t-10" >@lang('modules.invoices.total')</div>

                                        <p class="form-control-static col-xs-6 col-md-2" >
                                            <span class="total">0.00</span>
                                        </p>


                                        <input type="hidden" class="total-field" name="total" value="0">
                                    </div>

                                </div>

                            </div>

                            <div class="col-xs-12">

                                <div class="form-group" >
                                    <label class="control-label">@lang('app.note')</label>
                                    <textarea class="form-control" name="note" id="note" rows="5"></textarea>
                                </div>

                            </div>

                        </div>
                        <div class="form-actions" style="margin-top: 70px">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="dropup">
                                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            @lang('app.save') <span class="caret"></span>
                                        </button>
                                        <ul role="menu" class="dropdown-menu">
                                            <li>
                                                <a href="javascript:;" class="save-form" data-type="save">
                                                    <i class="fa fa-save"></i> @lang('app.save')
                                                </a>
                                            </li>
                                            <li class="divider"></li>
                                            <li>
                                                <a href="javascript:;" class="save-form" data-type="draft">
                                                    <i class="fa fa-file"></i> @lang('app.saveDraft')
                                                </a>
                                            </li>
                                            <li class="divider"></li>
                                            <li>
                                                <a href="javascript:void(0);" class="save-form" data-type="send">
                                                    <i class="fa fa-send"></i> @lang('app.saveSend')
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>    <!-- .row -->




@endsection

@push('footer-script')
    {{--<script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>--}}
    <script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>

    <script src="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/switchery/dist/switchery.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/select2.min.js') }}"></script>

    <script>
        function checkboxChange(parentClass, id){
            var checkedData = '';
            $('.'+parentClass).find("input[type= 'checkbox']:checked").each(function () {
                if(checkedData !== ''){
                    checkedData = checkedData+', '+$(this).val();
                }
                else{
                    checkedData = $(this).val();
                }
            });
            $('#'+id).val(checkedData);
        }

        $(document).ready(function(){
            var products = {!! json_encode($products) !!}
                var  selectedID = '';
            $("#selectProduct").select2({
                data: products,
                placeholder: "Select a Product",
                allowClear: true,
                escapeMarkup: function(markup) {
                    return markup;
                },
                templateResult: function(data) {
                    var htmlData = '<b>'+data.title+'</b> <a href="javascript:;" class="btn btn-success btn btn-outline btn-xs waves-effect pull-right">@lang('app.add') <i class="fa fa-plus" aria-hidden="true"></i></a>';
                    return htmlData;
                },
                templateSelection: function(data) {
                    $('#select2-selectProduct-container').html('@lang('app.add') @lang('app.menu.products')');
                    $("#selectProduct").val('');
                    selectedID = data.id;
                    return '';
                },
            }).on('change', function (e) {
                if(selectedID){
                    addProduct(selectedID);
                    $('#select2-selectProduct-container').html('@lang('app.add') @lang('app.menu.products')');
                }
                selectedID = '';
            }).on('select2:open', function (event) {
                $('span.select2-container--open').attr('id', 'product-box');
            });
        });

        getCompanyName();

        function getCompanyName(){
            var projectID = $('#project_id').val();
            var url = "{{ route('admin.all-invoices.get-client-company') }}";
            if(projectID != '' && projectID !== undefined )
            {
                url = "{{ route('admin.all-invoices.get-client-company',':id') }}";
                url = url.replace(':id', projectID);
            }
            $.ajax({
                type: 'GET',
                url: url,
                success: function (data) {
                    if(projectID != '')
                    {
                        $('#companyClientName').text('{{ __('app.company_name') }}');
                    } else {
                        $('#companyClientName').text('{{ __('app.client_name') }}');
                    }

                    $('#client_company_div').html(data.html);
                    if ($('#show_shipping_address').prop('checked') === true) {
                        checkShippingAddress();
                    }
                }
            });
        }

        function checkShippingAddress() {
            var projectId = $('#project_id').val();
            var clientId = $('#client_company_id').length > 0 ? $('#client_company_id').val() : $('#client_id').val();
            var showShipping = $('#show_shipping_address').prop('checked') === true ? 'yes' : 'no';

            var url = `{{ route('admin.all-invoices.checkShippingAddress') }}?showShipping=${showShipping}`;
            if (clientId !== '') {
                url += `&clientId=${clientId}`;
            }

            $.ajax({
                type: 'GET',
                url: url,
                success: function (response) {
                    if (response) {
                        if (response.switch === 'off') {
                            showShippingSwitch.click();
                        }
                        else {
                            if (response.show !== undefined) {
                                $('#shippingAddress').html('');
                            } else {
                                $('#shippingAddress').html(response.view);
                            }
                        }
                    }
                }
            });
        }

        // Switchery
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

        $('.js-switch').each(function () {
            new Switchery($(this)[0], $(this).data());
        });

        var showShippingSwitch = document.getElementById('show_shipping_address');

        showShippingSwitch.onchange = function() {
            if (showShippingSwitch.checked) {
                checkShippingAddress();
            }
            else {
                $('#shippingAddress').html('');
            }
        }

        $(function () {
            $( "#sortable" ).sortable();
        });

        $(".select2").select2({
            formatNoMatches: function () {
                return "{{ __('messages.noRecordFound') }}";
            }
        });

        jQuery('#invoice_date, #due_date').datepicker({
            autoclose: true,
            todayHighlight: true,
            weekStart:'{{ $global->week_start }}',
            format: '{{ $global->date_picker_format }}',
        });

        $('.save-form').click(function(){
            var type = $(this).data('type');
            calculateTotal();

            var discount = $('.discount-amount').html();
            var total = $('.total-field').val();

            if(parseFloat(discount) > parseFloat(total)){
                $.toast({
                    heading: 'Error',
                    text: "{{ __('messages.discountMoreThenTotal') }}",
                    position: 'top-right',
                    loaderBg:'#ff6849',
                    icon: 'error',
                    hideAfter: 3500
                });
                return false;
            }

            $.easyAjax({
                url:'{{route('admin.all-invoices.store')}}',
                container:'#storePayments',
                type: "POST",
                redirect: true,
                data:$('#storePayments').serialize()+ "&type=" + type
            })
        });

        $('#add-item').click(function () {
            var i = $(document).find('.item_name').length;
            var item = '<div class="col-xs-12 item-row margin-top-5">'

                +'<div class="col-md-3">'
                +'<div class="row">'
                +'<div class="form-group">'
                +'<label class="control-label hidden-md hidden-lg">@lang('modules.invoices.item')</label>'
                +'<div class="input-group">'
                +'<div class="input-group-addon"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></div>'
                +'<input type="text" class="form-control item_name" name="item_name[]" >'
                +'</div>'
                +'</div>'

                +'<div class="form-group">'
                +'<textarea name="item_summary[]" class="form-control" placeholder="@lang('app.description')" rows="2"></textarea>'
                +'</div>'

                +'</div>'

                +'</div>'

                +'<div class="col-md-1">'

                +'<div class="form-group">'
                +'<label class="control-label hidden-md hidden-lg">@lang('modules.invoices.hsnSacCode')</label>'
                +'<input type="text"  class="form-control" name="hsn_sac_code[]" >'
                +'</div>'


                +'</div>'


                +'<div class="col-md-1">'

                +'<div class="form-group">'
                +'<label class="control-label hidden-md hidden-lg">@lang('modules.invoices.qty')</label>'
                +'<input type="number" min="1" class="form-control quantity" value="1" name="quantity[]" >'
                +'</div>'


                +'</div>'

                +'<div class="col-md-2">'
                +'<div class="row">'
                +'<div class="form-group">'
                +'<label class="control-label hidden-md hidden-lg">@lang('modules.invoices.unitPrice')</label>'
                +'<input type="text" min="0" class="form-control cost_per_item" value="0" name="cost_per_item[]">'
                +'</div>'
                +'</div>'

                +'</div>'


                +'<div class="col-md-2">'

                +'<div class="form-group">'
                +'<label class="control-label hidden-md hidden-lg">@lang('modules.invoices.tax')</label>'
                +'<select id="multiselect'+i+'" name="taxes['+i+'][]"  multiple="multiple" class="selectpicker form-control type">'
                    @foreach($taxes as $tax)
                +'<option data-rate="{{ $tax->rate_percent }}" value="{{ $tax->id }}">{{ $tax->tax_name.': '.$tax->rate_percent }}%</option>'
                    @endforeach
                +'</select>'
                +'</div>'


                +'</div>'

                +'<div class="col-md-2 text-center">'
                +'<label class="control-label hidden-md hidden-lg">@lang('modules.invoices.amount')</label>'
                +'<p class="form-control-static"><span class="amount-html">0.00</span></p>'
                +'<input type="hidden" class="amount" name="amount[]">'
                +'</div>'

                +'<div class="col-md-1 text-right visible-md visible-lg">'
                +'<button type="button" class="btn remove-item btn-circle btn-danger"><i class="fa fa-remove"></i></button>'
                +'</div>'

                +'<div class="col-md-1 hidden-md hidden-lg">'
                +'<div class="row">'
                +'<button type="button" class="btn remove-item btn-danger"><i class="fa fa-remove"></i> @lang('app.remove')</button>'
                +'</div>'
                +'</div>'

                +'</div>';

            $(item).hide().appendTo("#sortable").fadeIn(500);
            $('#multiselect'+i).selectpicker();
            hsnSacColumn();
        });

        hsnSacColumn();
        function hsnSacColumn(){
            @if($invoiceSetting->hsn_sac_code_show)
            $('input[name="item_name[]"]').parent("div").parent('div').parent('div').parent('div').removeClass( "col-md-4");
            $('input[name="item_name[]"]').parent("div").parent('div').parent('div').parent('div').addClass( "col-md-3");
            $('input[name="hsn_sac_code[]"]').parent("div").parent('div').show();
            @else
            $('input[name="hsn_sac_code[]"]').parent("div").parent('div').hide();
            $('input[name="item_name[]"]').parent("div").parent('div').parent('div').parent('div').removeClass( "col-md-3");
            $('input[name="item_name[]"]').parent("div").parent('div').parent('div').parent('div').addClass( "col-md-4");
            @endif
        }

        $('#storePayments').on('click','.remove-item', function () {
            $(this).closest('.item-row').fadeOut(300, function() {
                $(this).remove();
                $('.item-row').each(function(index){
                    $(this).find('.selectpicker').attr('name', 'taxes['+index+'][]');
                    $(this).find('.selectpicker').attr('id', 'multiselect'+index);
                });
                calculateTotal();
            });
        });

        $('#storePayments').on('keyup change','.quantity,.cost_per_item,.item_name, .discount_value', function () {
            var quantity = $(this).closest('.item-row').find('.quantity').val();

            var perItemCost = $(this).closest('.item-row').find('.cost_per_item').val();

            var amount = (quantity*perItemCost);

            $(this).closest('.item-row').find('.amount').val(decimalupto2(amount).toFixed(2));
            $(this).closest('.item-row').find('.amount-html').html(decimalupto2(amount).toFixed(2));

            calculateTotal();


        });

        $('#storePayments').on('change','.type, #discount_type', function () {
            var quantity = $(this).closest('.item-row').find('.quantity').val();

            var perItemCost = $(this).closest('.item-row').find('.cost_per_item').val();

            var amount = (quantity*perItemCost);

            $(this).closest('.item-row').find('.amount').val(decimalupto2(amount).toFixed(2));
            $(this).closest('.item-row').find('.amount-html').html(decimalupto2(amount).toFixed(2));

            calculateTotal();


        });

        function calculateTotal()
        {
            var subtotal = 0;
            var discount = 0;
            var tax = '';
            var taxList = new Object();
            var taxTotal = 0;
            var discountType = $('#discount_type').val();
            var discountValue = $('.discount_value').val();

            $(".quantity").each(function (index, element) {
                var itemTax = [];
                var itemTaxName = [];
                var discountedAmount = 0;

                $(this).closest('.item-row').find('select.type option:selected').each(function (index) {
                    itemTax[index] = $(this).data('rate');
                    itemTaxName[index] = $(this).text();
                });
                var itemTaxId = $(this).closest('.item-row').find('select.type').val();

                var amount = parseFloat($(this).closest('.item-row').find('.amount').val());
                if(discountType == 'percent' && discountValue != ''){
                    discountedAmount = parseFloat(amount - ((parseFloat(amount)/100)*parseFloat(discountValue)));
                }
                else{
                    discountedAmount = parseFloat(amount - (parseFloat(discountValue)));
                }

                if(isNaN(amount)){ amount = 0; }

                subtotal = (parseFloat(subtotal)+parseFloat(amount)).toFixed(2);
                if(itemTaxId != ''){
                    for(var i = 0; i<=itemTaxName.length; i++)
                    {
                        if(typeof (taxList[itemTaxName[i]]) === 'undefined'){
                            if (discountedAmount > 0) {
                                taxList[itemTaxName[i]] = ((parseFloat(itemTax[i])/100)*parseFloat(discountedAmount));
                            } else {
                                taxList[itemTaxName[i]] = ((parseFloat(itemTax[i])/100)*parseFloat(amount));
                            }
                        }
                        else{
                            if (discountedAmount > 0) {
                                taxList[itemTaxName[i]] = parseFloat(taxList[itemTaxName[i]]) + ((parseFloat(itemTax[i])/100)*parseFloat(discountedAmount));

                            } else {
                                taxList[itemTaxName[i]] = parseFloat(taxList[itemTaxName[i]]) + ((parseFloat(itemTax[i])/100)*parseFloat(amount));
                            }
                        }
                    }
                }
            });


            $.each( taxList, function( key, value ) {
                if(!isNaN(value)){
                    tax = tax+'<div class="col-md-offset-8 col-md-2 text-right p-t-10">'
                        +key
                        +'</div>'
                        +'<p class="form-control-static col-xs-6 col-md-2" >'
                        +'<span class="tax-percent">'+(decimalupto2(value)).toFixed(2)+'</span>'
                        +'</p>';
                    taxTotal = taxTotal+decimalupto2(value);
                }
            });

            if(isNaN(subtotal)){  subtotal = 0; }

            $('.sub-total').html(decimalupto2(subtotal).toFixed(2));
            $('.sub-total-field').val(decimalupto2(subtotal));



            if(discountValue != ''){
                if(discountType == 'percent'){
                    discount = ((parseFloat(subtotal)/100)*parseFloat(discountValue));
                }
                else{
                    discount = parseFloat(discountValue);
                }

            }

            $('#invoice-taxes').html(tax);

            var totalAfterDiscount = decimalupto2(subtotal-discount);

            totalAfterDiscount = (totalAfterDiscount < 0) ? 0 : totalAfterDiscount;

            var total = decimalupto2(totalAfterDiscount+taxTotal);

            $('.total').html(total.toFixed(2));
            $('.total-field').val(total.toFixed(2));

        }

        function recurringPayment() {
            var recurring = $('#recurring_payment').val();

            if(recurring == 'yes')
            {
                $('.recurringPayment').show().fadeIn(300);
            } else {
                $('.recurringPayment').hide().fadeOut(300);
            }
        }

    </script>
    <script>
        $("#selectMember").select2({
            templateResult: function(data) {
            }
        }).on('select2:open', function (event) {
            $('span.select2-container--open').attr('id', 'member-box');
        });

        function handler(event){
            var target = $(event.target);

            if(target.parents('span#member-box') ){

                if(event.target.value.length >= 3){
                    url = "{{ route('admin.members.search-member',':key') }}";
                    let key = event.target.value;
                    url = url.replace(':key',key);
                    $.ajax({
                        type: 'GET',
                        url: url,
                        success: function (data) {
                            console.log(data)
                            // $('#selectMember').val([]);
                            $('#selectMember').select2('data', null);
                            for (option of data){
                                console.log("option:" + option)
                                if ($('#selectMember').find("option[value='" + option.id + "']").length) {
                                    $('#selectMember').val(option.user_id).trigger('change');
                                } else {
                                    // Create a DOM Option and pre-select by default
                                    var newOption = new Option(option.name + ' (' + option.member_id + ')', option.user_id, true, true);
                                    // Append it to the select
                                    $('#selectMember').append(newOption).trigger('change');
                                }
                            }

                        }
                    });
                }
                else {
                    $('#selectMember').val(null).trigger('change');
                }
            }

        }

        document.addEventListener('keyup', handler, true);
    </script>
    <script>
        $('#tax-settings').click(function () {
            var url = '{{ route('admin.taxes.create')}}';
            $('#modelHeading').html('Manage Project Category');
            $.ajaxModal('#taxModal', url);
        });
        function decimalupto2(num) {
            var amt =  Math.round(num * 100) / 100;
            return parseFloat(amt.toFixed(2));
        }

        function addProduct(id) {
            var currencyId = $('#currency_id').val();
            $.easyAjax({
                url:'{{ route('admin.all-invoices.update-item') }}',
                type: "GET",
                data: { id: id, currencyId: currencyId },
                success: function(response) {
                    $(response.view).hide().appendTo("#sortable").fadeIn(500);
                    var noOfRows = $(document).find('#sortable .item-row').length;
                    var i = $(document).find('.item_name').length-1;
                    var itemRow = $(document).find('#sortable .item-row:nth-child('+noOfRows+') select.type');
                    itemRow.attr('id', 'multiselect'+i);
                    itemRow.attr('name', 'taxes['+i+'][]');
                    $(document).find('#multiselect'+i).selectpicker();
                    calculateTotal();
                }
            });
        }
        $('#employees_butt').change(function () {
            if($(this).is(':checked')){
                $('#employees').show();
                $('#clients').hide();
                $('#members').hide();

                // $('#client_id').prop("name" , "");
                // $('#members').prop("name" , "");
                // $('#employee_id').prop("name" , "user_id");
            }
            // else{
            //     $('#new_fields').hide();
            //     $('#related_session_id').prop("name" , "session_id");
            // }
        })
        $('#members_butt').change(function () {
            if($(this).is(':checked')){
                $('#members').show();
                $('#employees').hide();
                $('#clients').hide();
                // $('#employee_id').prop("name" , "");
                // $('#client_id').prop("name" , "");
                // $('#member_id').prop("name" , "member_id");
            }
            // else{
            //     $('#related_fields').hide();
            //     $('#new_session_id').prop("name" , "session_id");
            // }
        })
    </script>
@endpush

