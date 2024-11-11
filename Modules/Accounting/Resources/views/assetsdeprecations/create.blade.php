@extends('accounting::layouts.form')

@section('form-panel-heading')@lang('accounting::modules.accounting.addAssetDeprecation')@endsection
@section('form-inputs')
<h3 class="box-title ">@lang('accounting::modules.accounting.assetDeprecationInfo')</h3>
<hr>


<div class="form-group">
  <label for="borrower">@lang('accounting::modules.accounting.assetCode')</label>
  <select name="code_id" class='select2 form-control form-select' style='width:100%' required></select>
  <small id="helpId" class="form-text text-muted">@lang('accounting::modules.accounting.selectAssetCode')</small>
</div>

<div class="form-group">
    <label for="borrower">@lang('accounting::modules.accounting.percentageOfDeprecation')</label>
    <input type='number' name='precentageOfDeprecation' class='form-control' step='0.1'  value="{{old('precentageOfDeprecation')}}"  required>
    <small id="helpId" class="form-text text-muted">@lang('accounting::modules.accounting.enterPercentageOfDepreaction')</small>
</div>

<div class="form-group">
    <label for="borrower">@lang('accounting::modules.accounting.numberOfYears')</label>
    <input type='number' name='numberOfYears' step='0.1'  class='form-control' value="{{old('numberOfYears')}}"  required>
    <small id="helpId" class="form-text text-muted">@lang('accounting::modules.accounting.enterDeprecationNumberOfYears')</small>
</div>



@endsection

{{-- Other Independant Blocks --}}
@php ($select2URL=route('admin.accounting.dailyrecords.ajax',['credibtors','selCodeAll']))
@php ($select2SentData="type:'CREDIBTOR'")
@include('accounting::sections.blocks.select2')

