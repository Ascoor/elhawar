@extends('accounting::layouts.report')
@section('report-title') {{__('accounting::modules.accounting.expenrevenReport')}} @endsection
@section('report-subtitle')
{{__('accounting::modules.accounting.onPeriod')}}  {{__('accounting::modules.accounting.from')}} : {{App\Helper\Arabic::arNums($startDate)}} {{__('accounting::modules.accounting.to')}} : {{App\Helper\Arabic::arNums($endDate)}} 
@endsection
@section('report-content')
    <table style="text-align: center"  cellpadding="2" cellspacing="2" nobr="true">
        <thead>
            <tr>
                <th style="width: 50%">{{__('accounting::modules.accounting.revenue')}}</th>
                <th style="width: 50%">{{__('accounting::modules.accounting.expenses')}}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                    <td>
                        <table cellpadding="2" cellspacing="2" nobr="true">
                            <thead>
                                <tr>
                                    <th style="width: 50%">

                                    </th >
                                    
                                    <th style="width: 25%">
                                        {{__('accounting::modules.accounting.partial')}}
                                    </th>
                                    
                                    <th style="width: 25%">
                                        {{__('accounting::modules.accounting.whole')}}
                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach ($revenCodes as $code )

                                    @if(count($code)==2)
                                    <tr>
                                        <td>
                                            <u style="font-weight:bold;font-style:italic">{{App\Helper\Arabic::arNums($code[0])}}</u>
                                        </td>
                                        <td>
                                            
                                        </td>
                                        <td>
                                            {{App\Helper\Arabic::arNums($code[1],1)}}
                                        </td>                                
                                    </tr>

                                    @elseIF(count($code)==3)

                                    <tr>
                                        <td>
                                            <u style="font-weight:bold;font-style:italic">{{App\Helper\Arabic::arNums($code[0])}}</u>
                                        </td>
                                        <td>
                                            
                                        </td>
                                        <td>
                                            
                                        </td>                                
                                    </tr>

                                        @foreach($code[2] as $subCode)
                                            <tr>
                                                <td>
                                                    {{App\Helper\Arabic::arNums($subCode[0])}}
                                                </td>
                                                <td>
                                                    {{App\Helper\Arabic::arNums($subCode[1],1)}}
                                                </td>
                                                <td>
                                                    
                                                </td>                                
                                            </tr>                             
                                        @endforeach

                                        <tr>
                                            <td>
                                                
                                            </td>
                                            <td>
                                                
                                            </td>
                                            <td>
                                              {{App\Helper\Arabic::arNums($code[1],1)}}
                                            </td>                                
                                        </tr>     

                                    @endif
                                    
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                    
                    <td>
                        <table cellpadding="2" cellspacing="2" nobr="true">
                            <thead>
                                <tr>
                                    <th style="width: 50%">

                                    </th >
                                    
                                    <th style="width: 25%">
                                        {{__('accounting::modules.accounting.partial')}}
                                    </th>
                                    
                                    <th style="width: 25%">
                                        {{__('accounting::modules.accounting.whole')}}
                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach ($expenCodes as $code )

                                    @if(count($code)==2)
                                    <tr>
                                        <td>
                                            <u style="font-weight:bold;font-style:italic">{{App\Helper\Arabic::arNums($code[0])}}</u>
                                        </td>
                                        <td>
                                            
                                        </td>
                                        <td>
                                            {{App\Helper\Arabic::arNums($code[1],1)}}
                                        </td>                                
                                    </tr>

                                    @elseIF(count($code)==3)

                                    <tr>
                                        <td>
                                            <u style="font-weight:bold;font-style:italic">{{App\Helper\Arabic::arNums($code[0])}}</u>
                                        </td>
                                        <td>
                                            
                                        </td>
                                        <td>
                                            
                                        </td>                                
                                    </tr>

                                        @foreach($code[2] as $subCode)
                                            <tr>
                                                <td>
                                                    {{App\Helper\Arabic::arNums($subCode[0])}}
                                                </td>
                                                <td>
                                                    {{App\Helper\Arabic::arNums($subCode[1],1)}}
                                                </td>
                                                <td>
                                                    
                                                </td>                                
                                            </tr>                             
                                        @endforeach

                                        <tr>
                                            <td>
                                                
                                            </td>
                                            <td>
                                                
                                            </td>
                                            <td>
                                            {{App\Helper\Arabic::arNums($code[1],1)}}
                                            </td>                                
                                        </tr>     

                                    @endif                      

                                @endforeach
                            </tbody>
                        </table>
                    </td>
            </tr>

        </tbody>
        <tfoot>
            <tr>
                <td>
                    {{__('accounting::modules.accounting.total')}} : 
                    {{App\Helper\Arabic::arNums($totalReven,1)}} 
                </td>
                <td>
                    {{__('accounting::modules.accounting.total')}} : 
                    {{App\Helper\Arabic::arNums($totalExpen,1)}} 
                </td>
            </tr>
        </tfoot>
    </table>

@endsection