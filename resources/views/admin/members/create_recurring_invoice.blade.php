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
                <li><a href="{{ route('admin.invoice-recurring.index') }}">{{ __($pageTitle) }}</a></li>
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
    .recurringPayment {
        display: none;
    }
    .label-font{
        font-weight: 500 !important;
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
                                <div id="members" >
                                    <div class="form-group col-md-3" id="mem">
                                        <label for="family_id" class="required">@lang('app.member_id')</label>
                                        <select class="select2 form-control client-category" data-placeholder="@lang('modules.members.choose_member')"  id="member_id" name="member_id" onchange="disableCategory()">
                                            @foreach($members as $member)
                                                <option value="{{ $member->member_id}}">{{ ucwords($member->member_id) }} --- {{ ucwords($member->name) }}</option>
                                            @endforeach

                                        </select>
                                    </div>

                                    <div class="col-md-3" id="cate">
                                        <div class="form-group">
                                            <label>@lang('app.category')</label>
                                            <select class="form-control select_cat" name="category_id" id="category_id" onchange="disableSelectMember({{$renewSetting[0]->main_annual_fees}},{{$renewSetting[0]->affiliate_annual_fees}})">
                                                <option value="">--</option>
                                                @foreach($categories as $category)
                                                    <option value="{{$category->id}}">@lang('app.'.$category->category_name)</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2" style="display: none">
                                        <div class="form-group">
                                            <label class="control-label">@lang('modules.invoices.currency')</label>
                                            <select class="form-control" name="currency_id" id="currency_id">
                                                <option value="1"></option>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="col-md-3" >

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
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">@lang('app.dueDate')</label>
                                            <div class="input-icon">
                                                <input type="text" class="form-control" name="due_date" id="due_date" value="{{ Carbon\Carbon::today()->addDays($invoiceSetting->due_after)->format($global->date_format) }}">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="row" style="display: none">
                                <div class="col-md-4 billingInterval">
                                    <div class="form-group">
                                        <label class="control-label ">@lang('modules.invoices.billingCycle')</label>
                                        <div class="input-icon">
                                            <input type="number" class="form-control" name="billing_cycle" id="billing_cycle" value="-1" placeholder="-1">
                                        </div>
                                        <p class="text-bold">@lang('messages.setForInfinite')</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">@lang('modules.invoices.billingFrequency')</label>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <select class="form-control" onchange="changeRotation(this.value);" name="rotation" id="rotation">
{{--                                                    <option value="daily">@lang('app.daily')</option>--}}
{{--                                                    <option value="weekly">@lang('app.weekly')</option>--}}
{{--                                                    <option value="bi-weekly">@lang('app.bi-weekly')</option>--}}
{{--                                                    <option value="monthly">@lang('app.monthly')</option>--}}
{{--                                                    <option value="quarterly">@lang('app.quarterly')</option>--}}
{{--                                                    <option value="half-yearly">@lang('app.half-yearly')</option>--}}
                                                    <option value="annually">@lang('app.annually')</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 dayOfWeek">
                                    <div class="form-group">
                                        <label class="control-label required">@lang('modules.expensesRecurring.dayOfWeek')</label>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <select class="form-control required"  name="day_of_week" id="dayOfWeek">
                                                    <option value="1">@lang('app.sunday')</option>
                                                    <option value="2">@lang('app.monday')</option>
                                                    <option value="3">@lang('app.tuesday')</option>
                                                    <option value="4">@lang('app.wednesday')</option>
                                                    <option value="5">@lang('app.thursday')</option>
                                                    <option value="6">@lang('app.friday')</option>
                                                    <option value="7">@lang('app.saturday')</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 dayOfMonth">
                                    <div class="form-group">
                                        <label class="control-label required">@lang('modules.expensesRecurring.dayOfMonth')</label>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <select class="form-control"  name="day_of_month" id="dayOfMonth">
                                                    @for($m=1; $m<=31; ++$m)
                                                        <option value="{{ $m }}">{{ $m }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" id="client_can_stop" name="client_can_stop" value="false">
                            <div class="row">
                                <div class="col-xs-12  visible-md visible-lg">
                                    <div class="col-md-3 font-bold" style="padding: 8px 15px">
                                        @lang('modules.invoices.item')
                                    </div>
                                    <div class="col-md-2 font-bold" style="padding: 8px 15px">
                                        @lang('modules.invoices.qty')
                                    </div>
                                    <div class="col-md-2 font-bold" style="padding: 8px 15px">
                                        @lang('modules.invoices.unitPrice')
                                    </div>
                                    <div class="col-md-1 text-center font-bold" style="padding: 8px 15px">
                                        @lang('modules.invoices.amount')
                                    </div>
                                    <div class="col-md-1" style="padding: 8px 15px">
                                        &nbsp;
                                    </div>
                                </div>
                                <div id="sortable">
                                    <div class="row">
                                        <div class="col-xs-12 item-row margin-top-5">
                                            <div class="col-md-3">
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label class="control-label hidden-md hidden-lg">@lang('modules.invoices.item')</label>
                                                        <div class="input-group">
                                                            <div class="input-group-addon"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></div>
                                                            <input type="text" class="form-control item_name" name="item_name[]" value="اشتراك عضو عامل">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" id="isMainMembershipItem[]" name="isMainMembershipItem[]" value="1">
                                            <div class="col-md-2">

                                                <div class="form-group">
                                                    <label class="control-label hidden-md hidden-lg">@lang('modules.invoices.qty')</label>
                                                    <input type="number" min="1" class="form-control quantity" value="1" name="quantity[]" >
                                                </div>


                                            </div>
                                            <div class="col-md-2">
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label class="control-label hidden-md hidden-lg">@lang('modules.invoices.unitPrice')</label>
                                                        <input type="text"  class="form-control cost_per_item" name="cost_per_item[]" value="{{$renewSetting[0]->main_annual_fees}}" >
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-1 border-dark  text-center">
                                                <label class="control-label hidden-md hidden-lg">@lang('modules.invoices.amount')</label>

                                                <p class="form-control-static"><span class="amount-html" id="amountName">{{$renewSetting[0]->main_annual_fees}}</span></p>
                                                <input type="hidden" class="amount" name="amount[]" value="{{$renewSetting[0]->main_annual_fees}}">
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <textarea name="item_summary[]" class="form-control" placeholder="@lang('app.description')" rows="1"></textarea>
                                                </div>
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
                                    <div class="row">
                                        <div class="col-xs-12 item-row margin-top-5">
                                            <div class="col-md-3">
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label class="control-label hidden-md hidden-lg">@lang('modules.invoices.item')</label>
                                                        <div class="input-group">
                                                            <div class="input-group-addon"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></div>
                                                            <input type="text" class="form-control item_name" name="item_name[]" value="مصاريف ادارية للعضوية">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" id="isMainMembershipItem[]" name="isMainMembershipItem[]" value="0">
                                            <div class="col-md-2">

                                                <div class="form-group">
                                                    <label class="control-label hidden-md hidden-lg">@lang('modules.invoices.qty')</label>
                                                    <input type="number" min="1" class="form-control quantity" value="1" name="quantity[]" >
                                                </div>


                                            </div>
                                            <div class="col-md-2">
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label class="control-label hidden-md hidden-lg">@lang('modules.invoices.unitPrice')</label>
                                                        <input type="text"  class="form-control cost_per_item" name="cost_per_item[]" value="{{$renewSetting[0]->administrative_expenses}}" >
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-1 border-dark  text-center">
                                                <label class="control-label hidden-md hidden-lg">@lang('modules.invoices.amount')</label>

                                                <p class="form-control-static"><span class="amount-html">{{$renewSetting[0]->administrative_expenses}}</span></p>
                                                <input type="hidden" class="amount" name="amount[]" value="{{$renewSetting[0]->administrative_expenses}}">
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <textarea name="item_summary[]" class="form-control" placeholder="@lang('app.description')" rows="1"></textarea>
                                                </div>
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
                                    <div class="row">
                                        <div class="col-xs-12 item-row margin-top-5">
                                            <div class="col-md-3">
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label class="control-label hidden-md hidden-lg">@lang('modules.invoices.item')</label>
                                                        <div class="input-group">
                                                            <div class="input-group-addon"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></div>
                                                            <input type="text" class="form-control item_name" name="item_name[]" value="طباعة كارنية">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" id="isMainMembershipItem[]" name="isMainMembershipItem[]" value="0">
                                            <div class="col-md-2">

                                                <div class="form-group">
                                                    <label class="control-label hidden-md hidden-lg">@lang('modules.invoices.qty')</label>
                                                    <input type="number" min="1" class="form-control quantity" value="1" name="quantity[]" >
                                                </div>


                                            </div>
                                            <div class="col-md-2">
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label class="control-label hidden-md hidden-lg">@lang('modules.invoices.unitPrice')</label>
                                                        <input type="text"  class="form-control cost_per_item" name="cost_per_item[]" value="{{$renewSetting[0]->card_printing}}" >
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-1 border-dark  text-center">
                                                <label class="control-label hidden-md hidden-lg">@lang('modules.invoices.amount')</label>

                                                <p class="form-control-static"><span class="amount-html">{{$renewSetting[0]->card_printing}}</span></p>
                                                <input type="hidden" class="amount" name="amount[]" value="{{$renewSetting[0]->card_printing}}">
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <textarea name="item_summary[]" class="form-control" placeholder="@lang('app.description')" rows="1"></textarea>
                                                </div>
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
                                    <div class="row">
                                        <div class="col-xs-12 item-row margin-top-5">
                                            <div class="col-md-3">
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label class="control-label hidden-md hidden-lg">@lang('modules.invoices.item')</label>
                                                        <div class="input-group">
                                                            <div class="input-group-addon"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></div>
                                                            <input type="text" class="form-control item_name" name="item_name[]" value="طابع معاقين للعضوية">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" id="isMainMembershipItem[]" name="isMainMembershipItem[]" value="0">
                                            <div class="col-md-2">

                                                <div class="form-group">
                                                    <label class="control-label hidden-md hidden-lg">@lang('modules.invoices.qty')</label>
                                                    <input type="number" min="1" class="form-control quantity" value="1" name="quantity[]" >
                                                </div>


                                            </div>
                                            <div class="col-md-2">
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label class="control-label hidden-md hidden-lg">@lang('modules.invoices.unitPrice')</label>
                                                        <input type="text"  class="form-control cost_per_item" name="cost_per_item[]" value="{{$renewSetting[0]->disabled_stamp}}" >
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-1 border-dark  text-center">
                                                <label class="control-label hidden-md hidden-lg">@lang('modules.invoices.amount')</label>

                                                <p class="form-control-static"><span class="amount-html">{{$renewSetting[0]->disabled_stamp}}</span></p>
                                                <input type="hidden" class="amount" name="amount[]" value="{{$renewSetting[0]->disabled_stamp}}">
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <textarea name="item_summary[]" class="form-control" placeholder="@lang('app.description')" rows="1"></textarea>
                                                </div>
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
                                    <div class="row">
                                        <div class="col-xs-12 item-row margin-top-5">
                                            <div class="col-md-3">
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label class="control-label hidden-md hidden-lg">@lang('modules.invoices.item')</label>
                                                        <div class="input-group">
                                                            <div class="input-group-addon"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></div>
                                                            <input type="text" class="form-control item_name" name="item_name[]" value="طابع شهيد للعضوية">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" id="isMainMembershipItem[]" name="isMainMembershipItem[]" value="0">
                                            <div class="col-md-2">

                                                <div class="form-group">
                                                    <label class="control-label hidden-md hidden-lg">@lang('modules.invoices.qty')</label>
                                                    <input type="number" min="1" class="form-control quantity" value="1" name="quantity[]" >
                                                </div>


                                            </div>
                                            <div class="col-md-2">
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label class="control-label hidden-md hidden-lg">@lang('modules.invoices.unitPrice')</label>
                                                        <input type="text"  class="form-control cost_per_item" name="cost_per_item[]" value="{{$renewSetting[0]->martyr_stamp}}" >
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-1 border-dark  text-center">
                                                <label class="control-label hidden-md hidden-lg">@lang('modules.invoices.amount')</label>

                                                <p class="form-control-static"><span class="amount-html">{{$renewSetting[0]->martyr_stamp}}</span></p>
                                                <input type="hidden" class="amount" name="amount[]" value="{{$renewSetting[0]->martyr_stamp}}">
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <textarea name="item_summary[]" class="form-control" placeholder="@lang('app.description')" rows="1"></textarea>
                                                </div>
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
                                    <div class="row">
                                        <div class="col-xs-12 item-row margin-top-5">
                                            <div class="col-md-3">
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label class="control-label hidden-md hidden-lg">@lang('modules.invoices.item')</label>
                                                        <div class="input-group">
                                                            <div class="input-group-addon"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></div>
                                                            <input type="text" class="form-control item_name" name="item_name[]" value="رفع الكفاءة الانشائية">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" id="isMainMembershipItem[]" name="isMainMembershipItem[]" value="0">
                                            <div class="col-md-2">

                                                <div class="form-group">
                                                    <label class="control-label hidden-md hidden-lg">@lang('modules.invoices.qty')</label>
                                                    <input type="number" min="1" class="form-control quantity" value="1" name="quantity[]" >
                                                </div>


                                            </div>
                                            <div class="col-md-2">
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label class="control-label hidden-md hidden-lg">@lang('modules.invoices.unitPrice')</label>
                                                        <input type="text"  class="form-control cost_per_item" name="cost_per_item[]" value="{{$renewSetting[0]->enhancing_constructions}}" >
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-1 border-dark  text-center">
                                                <label class="control-label hidden-md hidden-lg">@lang('modules.invoices.amount')</label>

                                                <p class="form-control-static"><span class="amount-html">{{$renewSetting[0]->enhancing_constructions}}</span></p>
                                                <input type="hidden" class="amount" name="amount[]" value="{{$renewSetting[0]->enhancing_constructions}}">
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <textarea name="item_summary[]" class="form-control" placeholder="@lang('app.description')" rows="1"></textarea>
                                                </div>
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
                                </div>
                                <div class="col-xs-12 m-t-5">
                                    <button type="button" class="btn btn-info" id="add-item"><i class="fa fa-plus"></i> @lang('modules.invoices.addItem')</button>
                                </div>
                                <div class="col-xs-8">
                                    <div class="form-group" >
                                        <label class="control-label">@lang('app.note')</label>
                                        <textarea class="form-control" name="note" id="note" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="col-xs-4 ">
                                    <div class="row" style="display: none">
                                        <div class="col-md-6">@lang('modules.invoices.subTotal')</div>
                                        <div class="col-md-6"> <p class="form-control-static col-xs-6 col-md-2" >
                                                <span class="sub-total">0.00</span>
                                            </p></div>
                                        <input type="hidden" class="sub-total-field" name="sub_total" value="0">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">@lang('modules.invoices.discount')</div>
                                        <div class="col-md-4"><input type="number" min="0" value="0" name="discount_value" class="form-control discount_value"></div>
                                        <div class="col-md-4">
                                            <select class="form-control" name="discount_type" id="discount_type">
                                                <option value="percent">%</option>
                                                <option value="fixed">@lang('modules.invoices.amount')</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row m-t-5" id="invoice-taxes" style="display: none">
                                        <div class="col-md-6">@lang('modules.invoices.tax')</div>
                                        <div class="col-md-6">
                                            <p class="form-control-static col-xs-6 col-md-2" >
                                            <span class="tax-percent">0.00</span>
                                        </p>
                                        </div>
                                    </div>
                                    <div class="row m-t-5 font-bold">
                                        <div class="col-md-6">@lang('modules.invoices.total')</div>
                                        <div class="col-md-6">
                                        <p class="form-control-static col-xs-6 col-md-2" >
                                            <span id="total" class="total">105.00</span>
                                        </p>
                                        </div>
                                        <input type="hidden" class="total-field" name="total" value="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" id="save-form-2" class="btn btn-success"><i class="fa fa-check"></i>
                                @lang('app.save')
                            </button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>    <!-- .row -->

    {{--Ajax Modal--}}
    <div class="modal fade bs-modal-md in" id="taxModal" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-md" id="modal-data-application">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <span class="caption-subject font-red-sunglo bold uppercase" id="modelHeading"></span>
                </div>
                <div class="modal-body">
                    @lang('app.loading')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn default" data-dismiss="modal">@lang('app.close')</button>
                    <button type="button" class="btn blue">@lang('app.save') @lang('changes')</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{--Ajax Modal Ends--}}
@endsection

@push('footer-script')
<script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/switchery/dist/switchery.min.js') }}"></script>
<script src="{{ asset('plugins/select2/select2.min.js') }}"></script>
<script>
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
    changeRotation($('#rotation').val());
    $('#infinite-expenses').change(function () {
        if($(this).is(':checked')){
            $('.billingInterval').hide();
        }
        else{
            $('.billingInterval').show();
        }
    });
    function changeRotation (rotationValue){
        if(rotationValue == 'weekly' || rotationValue == 'bi-weekly'){
            $('.dayOfWeek').show().fadeIn(300);
            $('.dayOfMonth').hide().fadeOut(300);
        }
        else if(rotationValue == 'monthly' || rotationValue == 'quarterly' || rotationValue == 'half-yearly' || rotationValue == 'annually'){
            $('.dayOfWeek').hide().fadeOut(300);
            $('.dayOfMonth').show().fadeIn(300);
        }
        else{
            $('.dayOfWeek').hide().fadeOut(300);
            $('.dayOfMonth').hide().fadeOut(300);
        }
    }
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
            }
        });
    }
    // Switchery
    var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
    $('.js-switch').each(function () {
        new Switchery($(this)[0], $(this).data());
    });
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
    $('#save-form-2').click(function(){
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
            url:'{{route('admin.members.membership-renew-store')}}',
            container:'#storePayments',
            type: "POST",
            redirect: true,
            data:$('#storePayments').serialize()
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
            +'</div>'
            +'</div>'
            +'<input type="hidden" id="isMainMembershipItem[]" name="isMainMembershipItem[]" value="0">'

            +'<div class="col-md-2">'
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


            +'<div class="col-md-1 text-center">'
            +'<label class="control-label hidden-md hidden-lg">@lang('modules.invoices.amount')</label>'
            +'<p class="form-control-static"><span class="amount-html">0.00</span></p>'
            +'<input type="hidden" class="amount" name="amount[]">'
            +'</div>'

            +'<div class="col-md-3">'
            +'<div class="form-group">'
            +'<textarea name="item_summary[]" class="form-control" placeholder="@lang('app.description')" rows="1"></textarea>'
            +'</div>'
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
    $('#storePayments').on('keyup change','.quantity,.cost_per_item,.item_name, .discount_value, .select_cat', function () {
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
    function calculateTotal(){
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
                            console.log(taxList[itemTaxName[i]]);
                         
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
    function disableCategory() {
        document.getElementById('cate').style.display = "none";
        };
    function disableSelectMember(main,affi) {
        var catValue = document.getElementById('category_id');
        document.getElementById('mem').style.display = "none";
        var amount = document.getElementsByName('amount[]');
        var UnitPrice = document.getElementsByName('cost_per_item[]');
        var amountname = document.getElementById('amountName');
        var itemName = document.getElementsByName('item_name[]');
        if(parseInt(catValue.value) === 2){
            amount[0].value=affi;
            UnitPrice[0].value=affi;
            amountname.innerText=affi;
            itemName[0].value='اشتراك عضو تابع';
        }else{
            amount[0].value=main;
            UnitPrice[0].value=main;
            amountname.innerText=main;
            itemName[0].value='اشتراك عضو عامل';
        }

        };
    function recurringPayment() {
        var recurring = $('#recurring_payment').val();

        if(recurring == 'yes')
        {
            $('.recurringPayment').show().fadeIn(300);
        } else {
            $('.recurringPayment').hide().fadeOut(300);
        }
    }
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
</script>
@endpush

