@extends('accounting::layouts.form')

@section('form-panel-heading')@lang('accounting::modules.accounting.addNewLoad')@endsection
@section('form-inputs')
<h3 class="box-title ">@lang('accounting::modules.accounting.loanDetails')</h3>
<hr>
<div class="form-group">
  <label for="borrower">@lang('accounting::modules.accounting.borrower')</label>
  <input type="text" maxlength="120" class="form-control" maxlength="120" name="borrower" id="borrower" aria-describedby="helpId" value="{{old('borrower')}}" required>
  <small id="helpId" class="form-text text-muted">@lang('accounting::modules.accounting.enterBorrowerName')</small>
</div>

<div class="form-group col-md-6">
    <label for="">@lang('accounting::modules.accounting.issuingDate')</label>
    <input type="text" class="form-control datepicker" name="issuingDate" id="issuingDate" aria-describedby="helpId" value="{{old('issuingDate')}}" required>
    <small id="helpId" class="form-text text-muted">@lang('accounting::modules.accounting.enterLoanIssuingDate')</small>
</div>

<div class="form-group col-md-6">
    <label for="">@lang('accounting::modules.accounting.claimingDate')</label>
    <input type="text" class="form-control datepicker" name="expirationDate" id="expirationDate" aria-describedby="helpId" value="{{old('expirationDate')}}" required>
    <small id="helpId" class="form-text text-muted">@lang('accounting::modules.accounting.enterLoanClaimingDate')</small>
</div>

<div class="form-group">
    <label for="">@lang('accounting::modules.accounting.loanDescription')</label>
    <textarea  class="form-control datepicker" name="description" id="description" aria-describedby="helpId">{{old('description')}}</textarea>
    <small id="helpId" class="form-text text-muted">@lang('accounting::modules.accounting.enterLoanDescription')</small>
</div>

<div class="form-group">
    <label for="">@lang('accounting::modules.accounting.amount')</label>
    <input type="number"  step=".01" class="form-control" name="amount" id="amount" aria-describedby="helpId" value="@if (old('amount')!=null){{old('amount')}}@else{{"0.00"}}@endif" required>
    <small id="helpId" class="form-text text-muted">@lang('accounting::modules.accounting.enterLoanAmount')</small>
</div>

@endsection

{{-- Other Independant Blocks --}}
@include('accounting::sections.blocks.jqueryDP')