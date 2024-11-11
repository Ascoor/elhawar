@extends('accounting::layouts.report')
@section('report-title') {{__('accounting::modules.accounting.generaledgersheet')}} @endsection
@section('report-subtitle')
{{$breadcrumb}}<br>
{{__('accounting::modules.accounting.onPeriod')}}  {{__('accounting::modules.accounting.from')}} : {{App\Helper\Arabic::arNums(date('d-m-Y',strtotime($startDate)))}} {{__('accounting::modules.accounting.to')}} : {{App\Helper\Arabic::arNums(date('d-m-Y',strtotime($endDate)))}}
@endsection
@section('report-content')   
<style>
    th,td{
        text-align: center!important;
        border: 1px solid black;
    }
</style>  
<table class="table table-bordered data-table text-center" {{__('accounting::modules.accounting.rtl')}}>
    <thead  {{__('accounting::modules.accounting.rtl')}}>
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
    <tbody {{__('accounting::modules.accounting.rtl')}}>
        @empty($sheet['date'])
            <tr>
                <td colspan="7">{{__('accounting::modules.accounting.noData')}}</td>
            </tr>
        @endempty
        @for ($i=0;$i<count($sheet['date']);$i++)
            <tr>
                    <td {{__('accounting::modules.accounting.rtl')}}> {{App\Helper\Arabic::arNums($i+1)}} </td>
                    <td {{__('accounting::modules.accounting.rtl')}}> {{App\Helper\Arabic::arNums($sheet['date'][$i])}}</td>
                    <td {{__('accounting::modules.accounting.rtl')}}> {{App\Helper\Arabic::arNums($sheet['journalEntryNo'][$i])}}</td>
                    <td {{__('accounting::modules.accounting.rtl')}}>@if ($sheet['transaction'][$i] >= 0){{App\Helper\Arabic::arNums($sheet['transaction'][$i],1) }}@else{{App\Helper\Arabic::arNums(0,1)}}@endIF</td>
                    <td {{__('accounting::modules.accounting.rtl')}}>@if ($sheet['transaction'][$i] < 0) {{App\Helper\Arabic::arNums(($sheet['transaction'][$i] * -1),1)}}@else{{App\Helper\Arabic::arNums(0,1)}}@endIF</td>
                    <td {{__('accounting::modules.accounting.rtl')}}> {{App\Helper\Arabic::arNums($sheet['balance'][$i],1)}}</td>
                    <td {{__('accounting::modules.accounting.rtl')}}> {{App\Helper\Arabic::arNums($sheet['excerpt'][$i])}}</td>
                    
            </tr>
        @endfor

        @if (!empty($sheet['date']))
            <tr>
                <td>{{__('accounting::modules.accounting.sum')}}</td>
                <td></td>
                <td></td>
                <td> {{App\Helper\Arabic::arNums($sheetTotals['totalDebtor'],1)}}</td>
                <td> {{App\Helper\Arabic::arNums($sheetTotals['totalCreditor'],1)}}</td>
                <td> {{App\Helper\Arabic::arNums($sheetTotals['totalBalance'],1)}}</td>
                <td></td>          
            </tr>
        @endif

    </tbody>
</table>

@endsection
