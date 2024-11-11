@extends('accounting::layouts.form')

@section('form-panel-heading')@lang('accounting::modules.accounting.editInsurance')@endsection
@section('form-inputs')
<h3 class="box-title ">@lang('accounting::modules.accounting.insuranceDetails')</h3>
<hr>
<div class="form-group">
    <label for="insuranceType">@lang('accounting::modules.accounting.insuranceType')</label>
    <select class='form-select form-control' name='insuranceType' id='insuranceType' required>
        @foreach ($insuranceTypes as $type)
            <option value="{{$type->id}}" @if ($insurance->insurance_type_id==$type->id) selected @endif>{{$type->name}}</option>
        @endforeach
    </select>
    <small id="helpId" class="form-text text-muted">@lang('accounting::modules.accounting.selectInsuranceType')</small>
</div>

<div class="form-group col-md-6">
    <label for="">@lang('accounting::modules.accounting.paymentDate')</label>
    <input type="text" class="form-control datepicker" name="paymentDate" id="paymentDate" aria-describedby="helpId" value="{{$insurance->paymentDate}}" required>
    <small id="helpId" class="form-text text-muted">@lang('accounting::modules.accounting.enterPaymentDate')</small>
</div>

<div class="form-group col-md-6">
    <label for="">@lang('accounting::modules.accounting.returnDate')</label>
    <input type="text" class="form-control datepicker" name="returnDate" id="returnDate" aria-describedby="helpId" value="{{$insurance->returnDate}}" required>
    <small id="helpId" class="form-text text-muted">@lang('accounting::modules.accounting.enterReturnDate')</small>
</div>

<div class="form-group">
    <label for="">@lang('accounting::modules.accounting.insurancePurpose')</label>
    <textarea  class="form-control datepicker" name="purpose" id="purpose" aria-describedby="helpId">{{$insurance->purpose}}</textarea>
    <small id="helpId" class="form-text text-muted">@lang('accounting::modules.accounting.enterInsurancePurpose')</small>
</div>

<div class="form-group">
    <label for="">@lang('accounting::modules.accounting.amount')</label>
    <input type="number"  step=".01" class="form-control" name="amount" id="amount" aria-describedby="helpId" value="{{$insurance->amount}}" required>
    <small id="helpId" class="form-text text-muted">@lang('accounting::modules.accounting.enterInsuranceAmount')</small>
</div>

@endsection

{{-- Other Independant Blocks --}}
@include('accounting::sections.blocks.jqueryDP')