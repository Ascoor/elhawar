@extends('accounting::layouts.form')

@section('form-panel-heading')@lang('accounting::modules.accounting.editCheck')@endsection
@section('form-inputs')
<h3 class="box-title ">@lang('accounting::modules.accounting.checkDetails')</h3>
<hr>


<div class="form-group col-md-6">
  <label for="borrower">@lang('accounting::modules.accounting.checkNumber')</label>
  <input type="text" class="form-control " maxlength="120" name="number" id="number" aria-describedby="helpId" value="{{$check->number}}" required>
  <small id="helpId" class="form-text text-muted">@lang('accounting::modules.accounting.enterNumber')</small>
</div>

<div class="form-group col-md-6">
    <label for="borrower">@lang('accounting::modules.accounting.checkStatus')</label>
          <select class="form-control" name="status" id="status" data-style="form-control">
              <option value="in" @if ($check->status=='in') selected @endif>@lang('accounting::modules.accounting.inbound')</option>
              <option value="out" @if ($check->status=='out') selected @endif>@lang('accounting::modules.accounting.outgoing')</option>
          </select>
    <small id="helpId" class="form-text text-muted">@lang('accounting::modules.accounting.selectCheckStatus')</small>
  </div>

  <div class="form-group col-md-6">
    <label for="borrower">@lang('accounting::modules.accounting.cashed')</label>
          <select class="form-control" name="cashed" id="cashed" data-style="form-control">
              <option value="1" @if ($check->cashed=='1') selected @endif>@lang('accounting::modules.accounting.yes')</option>
              <option value="0" @if ($check->cashed=='0') selected @endif>@lang('accounting::modules.accounting.no')</option>
          </select>
    <small id="helpId" class="form-text text-muted">@lang('accounting::modules.accounting.selectCahsedStatus')</small>
  </div>

<div class="form-group col-md-6">
    <label for="borrower">@lang('accounting::modules.accounting.accountType')</label>
          <select class="form-control" name="accountType" id="accountType" data-style="form-control">
              @foreach ($accountTypes as $type)
                  <option value="{{ $type->id }}" @if ($check->bank_account_type_id==$type->id) selected @endif>{{ $type->name }}</option>
              @endforeach
          </select>
    <small id="helpId" class="form-text text-muted">@lang('accounting::modules.accounting.selectAccountType')</small>
</div>
  

<div class="form-group col-md-6">
    <label for="">@lang('accounting::modules.accounting.bankName')</label>
    <div id='banknameInputWrapper'>
        @if(!empty($check->bankName))
        <input type="text" maxlength="120" class="form-control" name="bankName" id="bankName" aria-describedby="helpId" value="{{$check->bankName}}" required>
        @else
            <select class='form-select form-input select2' style='width:100%' name='code_id' required><option value={{$check->code_id}} selected>{{$check->bankCode->breadcrumb}}</option></select>
        @endif
    </div>

    <small id="helpId" class="form-text text-muted">@lang('accounting::modules.accounting.enterBankName')</small>
</div>

<div class="form-group col-md-6">
    <label for="">@lang('accounting::modules.accounting.date')</label>
    <input type="text" class="form-control datepicker" name="date" id="date" aria-describedby="helpId" value="{{$check->date}}" required>
    <small id="helpId" class="form-text text-muted">@lang('accounting::modules.accounting.enterDate')</small>
</div>

<div class="form-group">
    <label for="">@lang('accounting::modules.accounting.recipient')</label>
    <input type="text"  maxlength="120" class="form-control"  name="recipient" id="recipient" aria-describedby="helpId" value="{{$check->recipient}}" required>
    <small id="helpId" class="form-text text-muted">@lang('accounting::modules.accounting.enterRecipient')</small>
</div>

<div class="form-group">
    <label for="">@lang('accounting::modules.accounting.amount')</label>
    <input type="number"  step=".01" class="form-control" name="amount" id="amount" aria-describedby="helpId" value="{{$check->amount}}" required>
    <small id="helpId" class="form-text text-muted">@lang('accounting::modules.accounting.enterAmount')</small>
</div>

@endsection

@push('footer-script')
<script>
function updateBanknameInput()
{
    var currentCheckStatus=document.querySelector('#status').value;
    var banknameInputWrapper=document.querySelector('#banknameInputWrapper');
    if(currentCheckStatus == "out")
    {
        banknameInputWrapper.innerHTML="<select class='form-select form-input select2' style='width:100%' name='code_id' required><option disabled>{{__('accounting::modules.accounting.code')}}</option></select>"
        initSelectors();
    }
    else
    {
        banknameInputWrapper.innerHTML="<input type='text' maxlength='120' class='form-control' name='bankName' id='bankName' aria-describedby='helpId' value='{{old('bankName')}}' required>"
    }
}
</script>
@endpush
{{-- Other Independant Blocks --}}
@include('accounting::sections.blocks.jqueryDP')
@php ($select2URL=route('admin.accounting.dailyrecords.ajax',['credibtors','selCodeAll']))
@php ($select2SentData="type:'CREDIBTOR'")
@include('accounting::sections.blocks.select2')
