@extends('layouts.app')
@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12" style="width: fit-content">
            <h4 class="page-title" {{__('accounting::modules.accounting.rtl')}}><i class="{{ $pageIcon }}"></i> {{ $pageTitle }}</h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}" {{__('accounting::modules.accounting.rtl')}}>@lang('app.menu.home')</a></li>
                <li class="active" {{__('accounting::modules.accounting.rtl')}}>{{ $pageTitle }}</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection


@section('content')
<div class="row">

    <div class="col-md-12">
        <div class="white-box">



<div class="table-responsive-lg">
    <h4 class='text-center'> 

            {{__('accounting::modules.accounting.startDate')}} : {{$startDate}}  &emsp;   {{__('accounting::modules.accounting.endDate')}} : {{$endDate}}

    </h4>
<table class="table table-bordered data-table text-center" {{__('accounting::modules.accounting.rtl')}}>
    <thead>
        <tr>
            <th class='text-center'>#</th>
            <th class='text-center'>{{__('accounting::modules.accounting.date')}}</th>
            <th class='text-center'>{{__('accounting::modules.accounting.journalEntryNo')}}</th>
            <th class='text-center'>{{__('accounting::modules.accounting.debtor')}}</th>
            <th class='text-center'>{{__('accounting::modules.accounting.creditor')}}</th>
            <th class='text-center'>{{__('accounting::modules.accounting.balance')}}</th>
            <th class='text-center'>{{__('accounting::modules.accounting.statement')}}</th>
        </tr>
    </thead>
    <tbody>
        @empty($sheet['date'])
            <tr>
                <td colspan="7">{{__('accounting::modules.accounting.noData')}}</td>
            </tr>
        @endempty
        @for ($i=0;$i<count($sheet['date']);$i++)
            <tr>
                    <td>{{$i+1}}</td>
                    <td>{{$sheet['date'][$i]}}</td>
                    <td><a href="{{route('admin.accounting.dailyrecords.preview',$sheet['journalEntryID'][$i])}}" target="_blank">{{$sheet['journalEntryNo'][$i]}}</a></td>
                    <td>@if ($sheet['transaction'][$i] >= 0) {{$sheet['transaction'][$i] }}@else{{0}}@endIF</td>
                    <td>@if ($sheet['transaction'][$i] < 0) {{($sheet['transaction'][$i] * -1)}}@else{{0}}@endIF</td>
                    <td>{{$sheet['balance'][$i]}}</td>
                    <td>{{$sheet['excerpt'][$i]}}</td>
                    
            </tr>
        @endfor

        @if (!empty($sheet['date']))
            <tr>
                <td>{{__('accounting::modules.accounting.sum')}}</td>
                <td></td>
                <td></td>
                <td>{{$sheetTotals['totalDebtor']}}</td>
                <td>{{$sheetTotals['totalCreditor']}}</td>
                <td>{{$sheetTotals['totalBalance']}}</td>
                <td></td>          
            </tr>
        @endif

    </tbody>
</table>
</div>

</div>
</div>
</div>
    </div>
    </div>

@endsection

