@extends('accounting::layouts.report')
@section('report-title') {{__('accounting::modules.accounting.report')}} @endsection
@section('report-subtitle')
{{__('accounting::modules.accounting.startDate')}} : {{App\Helper\Arabic::arNums($startDate)}}  -- {{__('accounting::modules.accounting.endDate')}} : {{App\Helper\Arabic::arNums($endDate)}}
@endsection
@section('report-content')    
    <table style="text-align: center" >
        <thead>
            <tr>
            <th>{{__('accounting::modules.accounting.revenue')}}</th>

            <th>{{__('accounting::modules.accounting.expenses')}}</th>
            </tr>

        </thead>
        <tbody>
                <tr>
                    <td>
                        <ul>
                        @foreach ($revenTerms as $term)
                            <li>
                                    <h3><b>{{App\Helper\Arabic::arNums($term['name'])}} : {{App\Helper\Arabic::arNums($term['total'])}}</b></h3>
                                @if(!empty($term['subCodes']))
                                    <ol>
                                        @foreach ($term['subCodes'] as $code)
                                                <li>
                                                    <h4> {{App\Helper\Arabic::arNums($code['code'])}}/{{App\Helper\Arabic::arNums($code['breadcrumb'])}} : {{App\Helper\Arabic::arNums($code['report']['total'])}}</h4>
                                                </li>
                                        @endforeach 
                                    </ol>                         
                                @endif  
                            </li>
                        @endforeach

                        @isset($revenMiscTerm)
                            <li>
                                <h3><b>{{App\Helper\Arabic::arNums($revenMiscTerm['name'])}} : {{App\Helper\Arabic::arNums($revenMiscTerm['total'])}}</b></h3>
                            @if(!empty($revenMiscTerm['subCodes']))
                                <ol>
                                    @foreach ($revenMiscTerm['subCodes'] as $code)
                                            <li>
                                                <h4> {{App\Helper\Arabic::arNums($code['code'])}}/{{App\Helper\Arabic::arNums($code['breadcrumb'])}} : {{App\Helper\Arabic::arNums($code['report']['total'])}}</h4>
                                            </li>
                                    @endforeach 
                                </ol>                         
                            @endif  
                            </li>
                        @endisset

                        </ul>
                    </td>

                    <td>
                        <ul>
                        @foreach ($expenTerms as $term)
                            <li>
                                <h3><b>{{App\Helper\Arabic::arNums($term['name'])}} : {{App\Helper\Arabic::arNums($term['total'])}}</b></h3>
                            @if(!empty($term['subCodes']))
                                <ol>
                                    @foreach ($term['subCodes'] as $code)
                                            <li>
                                                <h4> {{App\Helper\Arabic::arNums($code['code'])}}/{{App\Helper\Arabic::arNums($code['breadcrumb'])}} : {{App\Helper\Arabic::arNums($code['report']['total'])}}</h4>
                                            </li>
                                    @endforeach 
                                </ol>                         
                            @endif
                            </li>  
                        @endforeach

                        @isset($expenMiscTerm)
                            <li>
                                <h3><b>{{App\Helper\Arabic::arNums($expenMiscTerm['name'])}} : {{App\Helper\Arabic::arNums($expenMiscTerm['total'])}}</b></h3>
                            @if(!empty($expenMiscTerm['subCodes']))
                                <ol>
                                    @foreach ($expenMiscTerm['subCodes'] as $code)
                                            <li>
                                                <h4> {{App\Helper\Arabic::arNums($code['code'])}}/{{App\Helper\Arabic::arNums($code['breadcrumb'])}} : {{App\Helper\Arabic::arNums($code['report']['total'])}}</h4>
                                            </li>
                                    @endforeach 
                                </ol>                         
                            @endif  
                            </li>
                        @endisset
                        </ul>
                    </td>
                </tr>
        </tbody>
    </table>
    @isset($accMiscTerm)
    <br>
    <br>
    <br>

    <table> 
        <thead>
            <tr>
                <th colspan="2">
                    {{__('accounting::modules.accounting.accounts')}}/{{App\Helper\Arabic::arNums($accMiscTerm['name'])}}
                </th>
                <th>
                    {{__('accounting::modules.accounting.total')}}
                </th>
            </tr>
        </thead>
        <tbody>

        <tr>
            <td colspan="2">
                @if(!empty($accMiscTerm['subCodes']))
                <ol>
                    @foreach ($accMiscTerm['subCodes'] as $code)
                            <li>
                                <h4> {{App\Helper\Arabic::arNums($code['code'])}}/{{App\Helper\Arabic::arNums($code['breadcrumb'])}} : {{App\Helper\Arabic::arNums($code['report']['total'])}}</h4>
                            </li>
                    @endforeach 
                </ol>                         
                @endif  
            </td>
            <td>
                {{App\Helper\Arabic::arNums($accMiscTerm['total'])}}
            </td>
        </tr>
        </tbody>
    </table>
@endisset

@endsection
