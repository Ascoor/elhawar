@extends('accounting::layouts.report')
@section('report-title') {{__('accounting::modules.accounting.deprecationSheet')}} @endsection
@section('report-subtitle')
{{__('accounting::modules.accounting.onPeriod')}}  {{__('accounting::modules.accounting.from')}} : {{App\Helper\Arabic::arNums($startDate)}} {{__('accounting::modules.accounting.to')}} : {{App\Helper\Arabic::arNums($endDate)}}
@endsection
@section('report-content')    
<style>
#tbl > tbody > tr > td , #a
{
    font-weight: 500;
    font-size: 13px!important;
}    
</style>
    <table style="text-align: center" cellpadding="3" id='tbl'> 
        <thead>
            <tr>
                <th style="width: 15%">{{__('accounting::modules.accounting.asset')}}</th>
                <th style="width: 10%">{{__('accounting::modules.accounting.balance')}}</th>
                <th style="width: 10%">{{__('accounting::modules.accounting.additions')}}</th>
                <th style="width: 12.5%">{{__('accounting::modules.accounting.total')}}</th>
                <th style="width: 5%">{{__('accounting::modules.accounting.percentageOfDeprecation')}}</th>
                <th style="width: 10%">{{__('accounting::modules.accounting.yearlyDeprecation')}}</th>
                <th style="width: 12.5%">{{__('accounting::modules.accounting.previousDeprecationSum')}}</th>
                <th style="width: 12.5%">{{__('accounting::modules.accounting.currentDeprecationSum')}}</th>
                <th style="width: 12.5%">{{__('accounting::modules.accounting.currentValueForAsset')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($outputData as $asset)
                <tr>
                    <td style="width: 15%;font-size:13px;" > {{App\Helper\Arabic::arNums($asset['name'])}}</td>
                    <td style="width: 10%;font-size:14px;font-weight:700"> {{App\Helper\Arabic::arNums($asset['balance'],1)}}</td>
                    <td style="width: 10%;font-size:14px;font-weight:700"> {{App\Helper\Arabic::arNums($asset['additions'],1)}}</td>
                    <td style="width: 12.5%;font-size:14px;font-weight:700"> {{App\Helper\Arabic::arNums($asset['totalBalance'],1)}}</td>
                    <td style="width: 5%;font-size:14px;font-weight:700"> {{App\Helper\Arabic::arNums($asset['deprecationPercentage'].'% ')}}</td>
                    <td style="width: 10%;font-size:14px;font-weight:700"> {{App\Helper\Arabic::arNums($asset['additionsDeprecation'],1)}}</td>
                    <td style="width: 12.5%;font-size:14px;font-weight:700"> {{App\Helper\Arabic::arNums($asset['previousDeprecation'],1)}}</td>
                    <td style="width: 12.5%;font-size:14px;font-weight:700"> {{App\Helper\Arabic::arNums($asset['totalDeprecation'],1)}}</td>
                    <td style="width: 12.5%;font-size:14px;font-weight:700"> {{App\Helper\Arabic::arNums($asset['currentValue'],1)}}</td>
                </tr>
            @endforeach
        </tbody>

    </table>

@endsection
