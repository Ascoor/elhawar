@extends('accounting::layouts.DTFilterList')

{{-- Needed Routes --}}
@section('createRoute'){{ route('admin.accounting.insurances.create') }}@endsection
@section('destroyRoute'){{route('admin.accounting.insurances.delete')}}@endsection


{{-- Filter inputs and attributes --}}
@section('dt-filter-form-inputs')
<div class="col-xs-12">
    <h5 > <i class="fa fa-calendar-o"></i> @lang('accounting::modules.accounting.returnDate')</h5>
    <div class="form-group">
            <input type="text" class="form-control datepicker " style="margin-bottom:5px" id="start-date" placeholder="@lang('accounting::modules.accounting.from')" value=""/>
            <input type="text" class="form-control datepicker " style="margin-bottom:5px" id="end-date" placeholder="@lang('accounting::modules.accounting.to')" value=""/>
    </div>
</div>

<div class="col-xs-12">
    <h5> <i class="fa fa-file-text-o"></i> @lang('accounting::modules.accounting.insuranceType')</h5>
    <div class="form-group">
        <select class="form-control" name="insuranceType" id="insuranceType" data-style="form-control">
            <option value="all">@lang('app.all')</option>
            @foreach ($insuranceTypes as $type)
                <option value="{{ $type->id }}">{{ $type->name }}</option>
            @endforeach
        </select>
    </div>
</div>
@endsection

@section('dt-filter-data')
    var startDate=document.querySelector('#start-date').value;
    var endDate=document.querySelector('#end-date').value;

    data['insuranceType']=document.querySelector('#insuranceType').value;
    data['startDate']=(startDate=='')?null:startDate;
    data['endDate']=(endDate=='')?null:endDate;
@endsection

@section('dt-filter-reset')
    document.querySelector('#insuranceType').selectedIndex = 0;
    document.querySelector('#insuranceType').value = 'all';
    document.querySelectorAll('.datepicker').forEach(element => {
        element.value='';
    });
@endsection

{{-- Additional Independant Blocks --}}
@include('accounting::sections.blocks.jqueryDP')
