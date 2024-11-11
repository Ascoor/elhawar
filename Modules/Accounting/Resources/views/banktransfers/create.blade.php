@extends('accounting::layouts.form')

@section('form-panel-heading')@lang('accounting::modules.accounting.addNewTransfer')@endsection
@section('form-inputs')
<h3 class="box-title ">@lang('accounting::modules.accounting.transferDetails')</h3>
<hr>


<div class="form-group col-md-6">
  <label for="borrower">@lang('accounting::modules.accounting.transferNumber')</label>
  <input type="text" class="form-control " maxlength="120" name="number" id="number" aria-describedby="helpId" value="{{old('number')}}" required>
  <small id="helpId" class="form-text text-muted">@lang('accounting::modules.accounting.enterNumber')</small>
</div>

<div class="form-group col-md-6">
    <label for="borrower">@lang('accounting::modules.accounting.transferStatus')</label>
          <select class="form-control" name="status" id="status" data-style="form-control">
              <option value="in" @if (old('status')=='in') selected @endif>@lang('accounting::modules.accounting.inbound')</option>
              <option value="out" @if (old('status')=='out') selected @endif>@lang('accounting::modules.accounting.outgoing')</option>
          </select>
    <small id="helpId" class="form-text text-muted">@lang('accounting::modules.accounting.selectTransferStatus')</small>
  </div>
  

<div class="form-group col-md-6">
    <label for="borrower">@lang('accounting::modules.accounting.accountType')</label>
          <select class="form-control" name="accountType" id="accountType" data-style="form-control">
              @foreach ($accountTypes as $type)
                  <option value="{{ $type->id }}" @if (old('accountType')==$type->id) selected @endif>{{ $type->name }}</option>
              @endforeach
          </select>
    <small id="helpId" class="form-text text-muted">@lang('accounting::modules.accounting.selectAccountType')</small>
</div>
  

{{-- <div class="form-group col-md-6">
    <label for="">@lang('accounting::modules.accounting.bankName')</label>
    <input type="text" maxlength="120" class="form-control" name="bankName" id="bankName" aria-describedby="helpId" value="{{old('bankName')}}" required>
    <small id="helpId" class="form-text text-muted">@lang('accounting::modules.accounting.enterBankName')</small>
</div> --}}


{{-- ROLA --}}

<div class="form-group col-md-6">
    <label for="borrower">@lang('accounting::modules.accounting.bankName')</label>
    <select id="code_id" name="code_id" class='select2 form-control form-select' style='width:100%' required></select>
    <small id="helpId" class="form-text text-muted">@lang('accounting::modules.accounting.enterBankName')</small>
  </div>

<div class="form-group col-md-6">
    <label for="">@lang('accounting::modules.accounting.date')</label>
    <input type="text" class="form-control datepicker" name="date" id="date" aria-describedby="helpId" value="{{old('date')}}" required>
    <small id="helpId" class="form-text text-muted">@lang('accounting::modules.accounting.enterDate')</small>
</div>

<div class="form-group col-md-6">
    <label for="">@lang('accounting::modules.accounting.recipient')</label>
    <input type="text"  maxlength="120" class="form-control"  name="recipient" id="recipient" aria-describedby="helpId" value="{{old('recipient')}}" required>
    <small id="helpId" class="form-text text-muted">@lang('accounting::modules.accounting.enterRecipient')</small>
</div>

<div class="form-group">
    <label for="">@lang('accounting::modules.accounting.amount')</label>
    <input type="number"  step=".01" class="form-control" name="amount" id="amount" aria-describedby="helpId" value="@if (old('amount')!=null){{old('amount')}}@else{{"0.00"}}@endif" required>
    <small id="helpId" class="form-text text-muted">@lang('accounting::modules.accounting.enterAmount')</small>
</div>

@endsection

{{-- Other Independant Blocks --}}
@include('accounting::sections.blocks.jqueryDP')


{{-- Rola --}}
@php ($select2URL=route('admin.accounting.dailyrecords.ajax',['credibtors','selCode']))
@php ($select2SentData="type:'CREDIBTOR'")
@include('accounting::sections.blocks.select2')