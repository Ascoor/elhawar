@extends('accounting::layouts.DTFilterList')

{{-- Needed Routes --}}
@section('createRoute'){{ route('admin.accounting.banktransfers.create') }}@endsection
@section('destroyRoute'){{route('admin.accounting.banktransfers.delete')}}@endsection


{{-- Filter inputs and attributes --}}
@section('dt-filter-form-inputs')

<div class="col-xs-12">
    <h5 > <i class="fa fa-calendar-o"></i> @lang('accounting::modules.accounting.date')</h5>
    <div class="form-group">
            <input type="text" class="form-control datepicker " style="margin-bottom:5px" id="start-date" placeholder="@lang('accounting::modules.accounting.from')" value=""/>
            <input type="text" class="form-control datepicker " style="margin-bottom:5px" id="end-date" placeholder="@lang('accounting::modules.accounting.to')" value=""/>
    </div>
</div>

<div class="col-xs-12">
    <h5> <i class="fa fa-file-text-o"></i> @lang('accounting::modules.accounting.accountType')</h5>
    <div class="form-group">
        <select class="form-control" name="accountType" id="accountType" data-style="form-control">
            <option value="all">@lang('app.all')</option>
            @foreach ($accountTypes as $type)
                <option value="{{ $type->id }}">{{ $type->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="col-xs-12">
    <h5> <i class="fa fa-file-text-o"></i> @lang('accounting::modules.accounting.transferStatus')</h5>
    <div class="form-group">
        <select class="form-control" name="status" id="status" data-style="form-control">
            <option value="all">@lang('app.all')</option>
            <option value="in">@lang('accounting::modules.accounting.inbound')</option>
            <option value="out">@lang('accounting::modules.accounting.outgoing')</option>
        </select>
    </div>
</div>

@endsection

@section('dt-filter-data')
    var startDate=document.querySelector('#start-date').value;
    var endDate=document.querySelector('#end-date').value;

    data['accountType']=document.querySelector('#accountType').value;
    data['status']=document.querySelector('#status').value;
    data['startDate']=(startDate=='')?null:startDate;
    data['endDate']=(endDate=='')?null:endDate;
@endsection

@section('dt-filter-reset')
document.querySelector('#accountType').selectedIndex = 0;
document.querySelector('#accountType').value = 'all';
document.querySelector('#status').selectedIndex = 0;
document.querySelector('#status').value = 'all';

    document.querySelectorAll('.datepicker').forEach(element => {
        element.value='';
    });
@endsection

{{-- Additional Independant Blocks --}}
@include('accounting::sections.blocks.jqueryDP')
