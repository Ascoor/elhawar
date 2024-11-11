@extends('accounting::layouts.form')

@section('form-panel-heading')@lang('accounting::modules.accounting.addNewCheck')@endsection
@section('form-inputs')
<h3 class="box-title ">@lang('accounting::modules.accounting.checkDetails')</h3>
<hr>


<div class="form-group col-md-6">
  <label for="borrower">@lang('accounting::modules.accounting.checkNumber')</label>
  <input type="text" class="form-control " maxlength="120" name="number" id="number" aria-describedby="helpId" value="{{old('number')}}" required>
  <small id="helpId" class="form-text text-muted">@lang('accounting::modules.accounting.enterNumber')</small>
</div>

<div class="form-group col-md-6">
    <label for="borrower">@lang('accounting::modules.accounting.checkStatus')</label>
          <select class="form-control" name="status" id="status" onChange="updateBanknameInput()" data-style="form-control">
              <option value="in" @if (old('status')=='in') selected @endif>@lang('accounting::modules.accounting.inbound')</option>
              <option value="out" @if (old('status')=='out') selected @endif>@lang('accounting::modules.accounting.outgoing')</option>
          </select>
    <small id="helpId" class="form-text text-muted">@lang('accounting::modules.accounting.selectCheckStatus')</small>
  </div>

  <div class="form-group col-md-6">
    <label for="borrower">@lang('accounting::modules.accounting.cashed')</label>
          <select class="form-control" name="cashed" id="cashed" data-style="form-control">
              <option value="1" @if (old('cashed')=='1') selected @endif>@lang('accounting::modules.accounting.yes')</option>
              <option value="0" @if (old('cashed')=='0') selected @endif>@lang('accounting::modules.accounting.no')</option>
          </select>
    <small id="helpId" class="form-text text-muted">@lang('accounting::modules.accounting.selectCahsedStatus')</small>
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
    <label for="">@lang('accounting::modules.accounting.bankName')rrrrrrr</label>
    <div id='banknameInputWrapper'>
        @if(!is_null(old('bankName')) || is_null(old('code_id')))
            <input type="text" maxlength="120" class="form-control" name="bankName" id="bankName" aria-describedby="helpId" value="{{old('bankName')}}" required>
        @else
            <select class='form-select form-input select2' style='width:100%' name='code_id' required><option value="">{{__('accounting::modules.accounting.code')}}</option></select>
        @endif
    </div>
    <small id="helpId" class="form-text text-muted">@lang('accounting::modules.accounting.enterBankName')</small>
</div> --}}
<div class="form-group col-md-6">
    {{-- <label for="">@lang('accounting::modules.accounting.bankName')</label> --}}
    {{-- <div > --}}
        {{-- id='banknameInputWrapper' --}}
        {{-- <select class="form-control" name="code_id" id="code_id" data-style="form-control">
            @foreach ($codeTypes as $type)
            
            @if($type->type == 'CREDIBTOR') 
            @if($type->level != 1 )
                 
            

            @endif

            <option value="{{ $type->id }}" @if (old('code_id')==$type->id) selected @endif>{{ $type->name }}</option> 
            @endif
            
            @endforeach
        </select> --}}

        {{-- ROLA --}}
        <div class="form-group">
            <label for="borrower">@lang('accounting::modules.accounting.bankName')</label>
            <select id="code_id" name="code_id" class='select2 form-control form-select' style='width:100%' required></select>
            <small id="helpId" class="form-text text-muted">@lang('accounting::modules.accounting.enterBankName')</small>
          </div>
        
        {{-- <select class="form-control" name="code_id" id="code_id" data-style="form-control">
            @foreach ($codeTypes as $parent)
            
            @if($parent->code == null && $parent->level= 1)
            {{ $indexCounter= @count($parent->code) }}
            @foreach ($codeTypes as $child) 
            
            {{ $indexSubChildCounter=$child[indexCounter] }}

            @if ($indexSubChildCounter == $indexCounter )

                <option value="{{ $type->id }}" @if (old('code_id')==$type->id) selected @endif>{{ $type->name }}</option> 
            
            @endif
            @endforeach
            @endif



            @if($type->type == 'CREDIBTOR') 
            <option value="{{ $type->id }}" @if (old('code_id')==$type->id) selected @endif>{{ $type->name }}</option> 
            @endif
            
            @endforeach
        </select> --}}
        
    {{-- </div> --}}

    <small id="helpId" class="form-text text-muted">@lang('accounting::modules.accounting.enterBankName')</small>
</div>

<div class="form-group col-md-6">
    <label for="">@lang('accounting::modules.accounting.date')</label>
    <input type="text" class="form-control datepicker" name="date" id="date" aria-describedby="helpId" value="{{old('date')}}" required>
    <small id="helpId" class="form-text text-muted">@lang('accounting::modules.accounting.enterDate')</small>
</div>

<div class="form-group">
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

@push('footer-script')
{{-- @forelse($categories as $category)
<option value="{{ $category->id }}">
    @lang('app.'.$category->category_name)
</option>
@empty
<option value="">@lang('messages.noCategoryAdded')</option>
@endforelse  --}}
<script>
function updateBanknameInput()
{
    var currentCheckStatus=document.querySelector('#status').value;
    var banknameInputWrapper=document.querySelector('#banknameInputWrapper');
    // if(currentCheckStatus == "out")
    // {
        // banknameInputWrapper.innerHTML="<select class='form-select form-input select2' style='width:100%' name='code_id' required><option disabled>{{__('accounting::modules.accounting.code')}}</option></select>"
       
        banknameInputWrapper.innerHTML= '<select class="select2 form-control client-category"  id="category_id" name="code_id" required> <option disabled>{{ __("accounting::modules.accounting.code")}}</option></select>'
        initSelectors();
    // }
    // else
    // {
    //     banknameInputWrapper.innerHTML="<input type='text' maxlength='120' class='form-control' name='bankName' id='bankName' aria-describedby='helpId' value='{{old('bankName')}}' required>"
    // }
}
</script>
@endpush
{{-- Other Independant Blocks --}}
@include('accounting::sections.blocks.jqueryDP')
@php ($select2URL=route('admin.accounting.dailyrecords.ajax',['credibtors','selCode']))
@php ($select2SentData="type:'CREDIBTOR'")
@include('accounting::sections.blocks.select2')

{{-- @php ($select2URL=route('admin.accounting.dailyrecords.ajax',['credibtors','selCodeAll']))
@php ($select2SentData="type:'CREDIBTOR'")
@include('accounting::sections.blocks.select2') --}}

