@extends('accounting::layouts.form')

@section('form-panel-heading')@lang('accounting::modules.accounting.editLetter')@endsection
@section('form-inputs')
<h3 class="box-title ">@lang('accounting::modules.accounting.letterDetails')</h3>
<hr>
<div class="form-group col-md-6">
  <label for="letterNumber">@lang('accounting::modules.accounting.letterNumber')</label>
  <input type="text" class="form-control"  maxlength="120" name="letterNumber" id="letterNumber" aria-describedby="helpId" value="{{$letter->letterNumber}}" required>
  <small id="helpId" class="form-text text-muted">@lang('accounting::modules.accounting.enterLetterNumber')</small>
</div>
<div class="form-group col-md-6">
    <label for="letterType">@lang('accounting::modules.accounting.letterType')</label>
    <select class='form-select form-control' name='letterType' id='letterType' required>
        @foreach ($lettersOfGuaranteeTypes as $type)
            <option value="{{$type->id}}" @if ($letter->letterType==$type->id) selected @endif>{{$type->name}}</option>
        @endforeach
    </select>
    <small id="helpId" class="form-text text-muted">@lang('accounting::modules.accounting.selectLetterType')</small>
</div>

<div class="form-group col-md-6">
  <label for="">@lang('accounting::modules.accounting.issuingBank')</label>
  <input type="text" class="form-control" maxlength="120"  name="issuingBank" id="issuingBank" aria-describedby="helpId" value="{{$letter->issuingBank}}" required>
  <small id="helpId" class="form-text text-muted">@lang('accounting::modules.accounting.enterIssuingBank')</small>
</div>

<div class="form-group col-md-6">
    <label for="issuedToCompany">@lang('accounting::modules.accounting.issuedToCompany')</label>
    <input type="text" class="form-control" maxlength="120"  name="issuedToCompany" id="issuedToCompany" aria-describedby="helpId" value="{{$letter->issuedToCompany}}" required>
    <small id="helpId" class="form-text text-muted">@lang('accounting::modules.accounting.enterIssuedToCompany')</small>
</div>
  
<div class="form-group col-md-6">
    <label for="">@lang('accounting::modules.accounting.issuingDate')</label>
    <input type="text" class="form-control datepicker" name="issuingDate" id="issuingDate" aria-describedby="helpId" value="{{$letter->issuingDate}}" required>
    <small id="helpId" class="form-text text-muted">@lang('accounting::modules.accounting.enterIssuingDate')</small>
</div>

<div class="form-group col-md-6">
    <label for="">@lang('accounting::modules.accounting.expirationDate')</label>
    <input type="text" class="form-control datepicker" name="expirationDate" id="expirationDate" aria-describedby="helpId" value="{{$letter->expirationDate}}" required>
    <small id="helpId" class="form-text text-muted">@lang('accounting::modules.accounting.enterExpirationDate')</small>
</div>

<div class="form-group">
    <label for="">@lang('accounting::modules.accounting.letterDescription')</label>
    <textarea  class="form-control datepicker" name="description" id="description" aria-describedby="helpId">{{$letter->description}}</textarea>
    <small id="helpId" class="form-text text-muted">@lang('accounting::modules.accounting.enterLetterDescription')</small>
</div>

<div class="form-group">
    <label for="">@lang('accounting::modules.accounting.amount')</label>
    <input type="number"  step=".01" class="form-control" name="amount" id="amount" aria-describedby="helpId" value="{{$letter->amount}}" required>
    <small id="helpId" class="form-text text-muted">@lang('accounting::modules.accounting.enterLetterAmount')</small>
</div>

@endsection

{{-- Other Independant Blocks --}}
@include('accounting::sections.blocks.jqueryDP')