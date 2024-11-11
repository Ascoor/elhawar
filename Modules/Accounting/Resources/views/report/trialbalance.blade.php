@extends('accounting::layouts.report')
@section('report-title') {{__('accounting::modules.accounting.trialbalance')}} @endsection
@section('report-subtitle')
{{__('accounting::modules.accounting.trialbalanceon')}} : {{__('accounting::modules.accounting.from')}} : {{App\Helper\Arabic::arNums($startDate)}} {{__('accounting::modules.accounting.to')}} : {{App\Helper\Arabic::arNums($endDate)}} 
@endsection
@section('report-content')
        <table cellpadding="3" >
            <thead>
                <tr>
                    <th rowspan="2" style="width: 5%">#</th>
                    <th rowspan="2" style="width: 15%">{{__('accounting::modules.accounting.statement')}}</th>
                    <th colspan="4" style="width: 40%">{{__('accounting::modules.accounting.sums')}}</th>
                    <th colspan="4" style="width: 40%">{{__('accounting::modules.accounting.balances')}}</th>
                </tr>
                <tr>
                    <th colspan="2">{{__('accounting::modules.accounting.fromIt')}}</th>
                    <th colspan="2">{{__('accounting::modules.accounting.toIt')}}</th>
                    <th colspan="2">{{__('accounting::modules.accounting.fromIt')}}</th>
                    <th colspan="2">{{__('accounting::modules.accounting.toIt')}}</th>
                </tr>
            </thead>
            <tbody>
                {{$i=0}}
                
                {{-- Credibtors --}}
                @foreach ($credibtorsDCB as $code)
                    <tr>
                        <td style="width: 5%"> {{App\Helper\Arabic::arNums(++$i)}} </td>
                        <td style="width: 15%">{{$code['name']}}</td>
                        @php $whole=abs(intval($code['debtor']));(int)$decimal=abs(($code['debtor']-intval($code['debtor']))*100);@endphp
                        <td>{{App\Helper\Arabic::arNums($decimal)}}</td>
                        <td>{{App\Helper\Arabic::arNums($whole)}}</td>
                        @php $whole=abs(intval($code['creditor']));(int)$decimal=abs(($code['creditor']-intval($code['creditor']))*100);@endphp
                        <td>{{App\Helper\Arabic::arNums($decimal)}}</td>
                        <td>{{App\Helper\Arabic::arNums($whole)}}</td>
                        @php $whole=abs(intval($code['balance']));(int)$decimal=abs(($code['balance']-intval($code['balance']))*100);@endphp
                        <td>@if($code['balance']>0){{App\Helper\Arabic::arNums($decimal)}}@endif</td>
                        <td>@if($code['balance']>0){{App\Helper\Arabic::arNums($whole)}}@endif</td>
                        <td>@if($code['balance']<0){{App\Helper\Arabic::arNums($decimal)}}@endif</td>
                        <td>@if($code['balance']<0){{App\Helper\Arabic::arNums($whole)}}@endif</td>
                    </tr>
                @endforeach
                {{-- /Credibtors --}}


            </tbody>
        </table>
@endsection
