@extends('accounting::layouts.report')
@section('report-title') {{__('accounting::modules.accounting.balanceSheet')}} @endsection
@section('report-subtitle')
{{__('accounting::modules.accounting.onPeriod')}}  {{__('accounting::modules.accounting.from')}} : {{App\Helper\Arabic::arNums(date('d-m-Y',strtotime($startDate)))}} {{__('accounting::modules.accounting.to')}} : {{App\Helper\Arabic::arNums(date('d-m-Y',strtotime($endDate)))}}
@endsection
@section('report-content')    
    <table style="text-align: center" cellpadding="3" > 
        <thead>
            <tr>
                <th style="width: 50%">{{__('accounting::modules.accounting.assets')}}</th>
                <th style="width: 50%">{{__('accounting::modules.accounting.liabilities')}}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                    <td>
                        <table cellpadding="3" >
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
                                @foreach ($codesData['assets'] as $code)

                                    @if($code['type'])
                                        <tr>
                                            <td >
                                                <u style="font-weight:bold;">{{App\Helper\Arabic::arNums($code['name'])}}</u>
                                            </td>
                                            <td>
                                                
                                            </td>
                                            <td>
                                                
                                            </td>                                
                                        </tr>

                                        @foreach($code['subCodes'] as $subCode)
                                            <tr>
                                                <td>
                                                    {{App\Helper\Arabic::arNums($subCode['name'])}}
                                                </td>
                                                <td style="font-size:13px;font-weight:700">
                                                    {{App\Helper\Arabic::arNums(array_key_exists('deprecable',$subCode)?$subCode['oldBalance']:$subCode['balance'],1)}}
                                                </td>
                                                <td>
                                                    
                                                </td>                                
                                            </tr>  
                                            @if(array_key_exists('deprecable',$subCode))
                                                <tr>
                                                    <td>
                                                        {{__('accounting::modules.accounting.additions')}}
                                                    </td>
                                                    <td style="font-size:13px;font-weight:700">
                                                        {{App\Helper\Arabic::arNums($subCode['additions'],1)}}
                                                    </td>
                                                    <td>
                                                        
                                                    </td>                                
                                                </tr>  
                                                <tr>
                                                    <td>
                                                        {{__('accounting::modules.accounting.sumDeprecation')}}
                                                    </td>
                                                    <td style="font-size:13px;font-weight:700">
                                                        {{App\Helper\Arabic::arNums($subCode['deprecation'],1)}}
                                                    </td>
                                                    <td style="font-size:13px;font-weight:700">
                                                        {{App\Helper\Arabic::arNums($subCode['balance'],1)}}
                                                    </td>                                
                                                </tr>                                                                                        
                                            @endif
                                        @endforeach


                                        <tr>
                                            <td>
                                                
                                            </td>
                                            <td>
                                                
                                            </td>
                                            <td style="font-size:13px;font-weight:700">
                                              {{App\Helper\Arabic::arNums($code['balance'],1)}}
                                            </td>                                
                                        </tr>     
                                    

                                    @else
                                        @if(!array_key_exists('deprecable',$code))
                                            <tr>
                                                <td>
                                                    <u style="font-weight:bold;">{{App\Helper\Arabic::arNums($code['name'])}}</u>
                                                </td>
                                                <td style="font-size:13px;font-weight:700">
                                                    {{App\Helper\Arabic::arNums($code['balance'],1)}}
                                                </td>
                                                <td style="font-size:13px;font-weight:700">
                                                    {{App\Helper\Arabic::arNums($code['balance'],1)}}
                                                </td>                                
                                            </tr>
                                        @else
                                            <tr>
                                                <td>
                                                    {{App\Helper\Arabic::arNums($code['name'])}}
                                                </td>
                                                <td  style="font-size:13px;font-weight:700">
                                                    {{App\Helper\Arabic::arNums(array_key_exists('deprecable',$code)?$code['oldBalance']:$code['balance'],1)}}
                                                </td>
                                                <td>
                                                    
                                                </td>                                
                                            </tr>  
                                            <tr>
                                                <td>
                                                    {{__('accounting::modules.accounting.additions')}}
                                                </td>
                                                <td style="font-size:13px;font-weight:700">
                                                    {{App\Helper\Arabic::arNums($code['additions'],1)}}
                                                </td>
                                                <td>
                                                    
                                                </td>                                
                                            </tr>  
                                            <tr>
                                                <td>
                                                    {{__('accounting::modules.accounting.sumDeprecation')}}
                                                </td>
                                                <td style="font-size:13px;font-weight:700">
                                                    {{App\Helper\Arabic::arNums($code['deprecation'],1)}}
                                                </td>
                                                <td style="font-size:13px;font-weight:700">
                                                    {{App\Helper\Arabic::arNums($code['balance'],1)}}
                                                </td>                                
                                            </tr>                                                                                        
                                        @endIF
                                    @endif
                                                                        
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                    
                    <td>
                        <table cellpadding="3" >
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
                                                                
                                @foreach ($codesData['liabilities'] as $code)

                                    @if($code['type'])
                                        <tr>
                                            <td>
                                                <u style="font-weight:bold;">{{App\Helper\Arabic::arNums($code['name'])}}</u>
                                            </td>
                                            <td>
                                                
                                            </td>
                                            <td>
                                                
                                            </td>                                
                                        </tr>

                                        @foreach($code['subCodes'] as $subCode)
                                            <tr>
                                                <td>
                                                    {{App\Helper\Arabic::arNums($subCode['name'])}}
                                                </td>
                                                <td style="font-size:13px;font-weight:700">
                                                    {{App\Helper\Arabic::arNums(array_key_exists('deprecable',$subCode)?$subCode['oldBalance']:$subCode['balance'],1)}}
                                                </td>
                                                <td>
                                                    
                                                </td>                                
                                            </tr>  
                                            @if(array_key_exists('deprecable',$subCode))
                                                <tr>
                                                    <td>
                                                        {{__('accounting::modules.accounting.additions')}}
                                                    </td>
                                                    <td style="font-size:13px;font-weight:700">
                                                        {{App\Helper\Arabic::arNums($subCode['additions'],1)}}
                                                    </td>
                                                    <td>
                                                        
                                                    </td>                                
                                                </tr>  
                                                <tr>
                                                    <td>
                                                        {{__('accounting::modules.accounting.sumDeprecation')}}
                                                    </td>
                                                    <td style="font-size:13px;font-weight:700">
                                                        {{App\Helper\Arabic::arNums($subCode['deprecation'],1)}}
                                                    </td>
                                                    <td style="font-size:13px;font-weight:700">
                                                        {{App\Helper\Arabic::arNums($code['balance'],1)}}
                                                    </td>                                
                                                </tr>                                                                                        
                                            @endif
                                        @endforeach


                                        <tr>
                                            <td>
                                                
                                            </td>
                                            <td>
                                                
                                            </td>
                                            <td style="font-size:13px;font-weight:700">
                                              {{App\Helper\Arabic::arNums($code['balance'],1)}}
                                            </td>                                
                                        </tr>     
                                    

                                    @else
                                        @if(!array_key_exists('deprecable',$code))
                                            <tr>
                                                <td>
                                                    <u style="font-weight:bold;">{{App\Helper\Arabic::arNums($code['name'])}}</u>
                                                </td>
                                                <td style="font-size:13px;font-weight:700">
                                                    {{App\Helper\Arabic::arNums($code['balance'],1)}}
                                                </td>
                                                <td style="font-size:13px;font-weight:700">
                                                    {{App\Helper\Arabic::arNums($code['balance'],1)}}
                                                </td>                                
                                            </tr>
                                        @else
                                            <tr>
                                                <td>
                                                    {{App\Helper\Arabic::arNums($code['name'])}}
                                                </td>
                                                <td style="font-size:13px;font-weight:700">
                                                    {{App\Helper\Arabic::arNums(array_key_exists('deprecable',$code)?$code['oldBalance']:$code['balance'],1)}}
                                                </td>
                                                <td>
                                                    
                                                </td>                                
                                            </tr>  
                                            <tr>
                                                <td>
                                                    {{__('accounting::modules.accounting.additions')}}
                                                </td>
                                                <td style="font-size:13px;font-weight:700">
                                                    {{App\Helper\Arabic::arNums($code['additions'],1)}}
                                                </td>
                                                <td>
                                                    
                                                </td>                                
                                            </tr>  
                                            <tr>
                                                <td>
                                                    {{__('accounting::modules.accounting.sumDeprecation')}}
                                                </td>
                                                <td style="font-size:13px;font-weight:700">
                                                    {{App\Helper\Arabic::arNums($code['deprecation'],1)}}
                                                </td>
                                                <td style="font-size:13px;font-weight:700">
                                                    {{App\Helper\Arabic::arNums($code['balance'],1)}}
                                                </td>                                
                                            </tr>                                                                                        
                                        @endIF
                                    @endif
                                                                        
                                @endforeach
                            </tbody>
                        </table>
                    </td>
            </tr>

        </tbody>
        <tfoot>
            <tr>
                
                <td style="font-size:13px;font-weight:700">
                    {{__('accounting::modules.accounting.total')}} : 
                    {{App\Helper\Arabic::arNums($codesData['totalAssets'],1)}} 
                </td>

                <td style="font-size:13px;font-weight:700">
                        {{__('accounting::modules.accounting.total')}} :
                        {{App\Helper\Arabic::arNums($codesData['totalLiabilities'],1)}}
                </td>

            </tr>
        </tfoot>

    </table>

@endsection
