<html>
<head>
    <meta charset="UTF-8">

    <title>{{__('accounting::modules.accounting.report')}}</title>
    <style>
        table, th, td {
  border: 1px solid black;
}

td
{
    padding:4px 4px 4px 4px;
    
}


th
{
    padding:4px 4px 4px 4px;
}


        </style>
</head>
<body>

<center>

    <div style='width:100%;text-align:center'>
        <h1>
            <b style="text-align:center">
                {{__('accounting::modules.accounting.JournalEnrty')}} / {{$type}} / {{__('accounting::modules.accounting.onPeriod')}}  {{__('accounting::modules.accounting.from')}} : {{App\Helper\Arabic::arNums($startDate)}}  {{__('accounting::modules.accounting.to')}} :{{App\Helper\Arabic::arNums($endDate)}}
            </b>
        </h1>
    </div>

    <table >
        <thead>

            <tr>
                <th style="width: 15%;text-align:center">{{__('accounting::modules.accounting.journalEntryNo')}}</th>
                <th style="width: 10%;text-align:center">{{__('accounting::modules.accounting.debtor')}} </th>
                <th style="width: 10%;text-align:center">{{__('accounting::modules.accounting.creditor')}} </th>
                <th style="width: 55%;text-align:center">{{__('accounting::modules.accounting.statement')}}</th>
                <th style="width: 10%;text-align:center">{{__('accounting::modules.accounting.date')}}</th>
            </tr>

        </thead>
        <tbody>
    
            @foreach ($records as $record)
                        @php
                            $rowspan=$record->entries->count()+2;
                            $debitCount=$record->entries->where('type','=','DEBIT')->count();
                            $creditCount=$record->entries->where('type','=','CREDIT')->count();
                            $rowspan+=($debitCount >1)?1:0;
                            $rowspan+=($creditCount >1)?1:0;
                        @endphp
                        
                        @foreach ($record->entries->where('type','=','DEBIT') as $entry)
                                
                            @if ($loop->first)

                                    <tr style="border:none;">
                                            <td style="width: 15%;border:none;border-left:1px solid black;;text-align:center;direction:ltr"  rowspan="{{($rowspan)}}">{{App\Helper\Arabic::arNums($record->journalEntryNo)}}</td>
                                            <td style="width: 10%;border:none;border-left:1px solid black;text-align:center"></td>
                                            <td style="width: 10%;border:none;border-left:1px solid black;text-align:center"></td>
                                            <td style="width: 55%;border:none;border-left:1px solid black;border-right:1px solid black;"></td>
                                            <td style="width: 10%;border:none;text-align:center"  rowspan="{{$rowspan}}">{{App\Helper\Arabic::arNums(date('m/d',strtotime($record->date)))}}</td>
                                    </tr>
                                    @if ($debitCount>1)
                                        <tr style="border:none;">
                                            <td style="width: 10%;border:none;border-left:1px solid black;text-align:center"></td>
                                            <td style="width: 10%;border:none;border-left:1px solid black;text-align:center"></td>
                                            <td style="width: 55%;border:none;border-left:1px solid black;border-right:1px solid black;">
                                                {{__('accounting::modules.accounting.fromMentioned')}}
                                            </td>
                                        </tr>
                                    @endif

                            @endif

                                <tr style="border:none;">
                                    <td style="width: 10%;border:none;border-left:1px solid black;text-align:center">{{App\Helper\Arabic::arNums($entry->amount)}}</td>
                                    <td style="width: 10%;border:none;border-left:1px solid black;text-align:center"></td>
                                    <td style="width: 55%;border:none;border-left:1px solid black;border-right:1px solid black;">
                                        @if (!($debitCount >1)){{__('accounting::modules.accounting.from')}}  @endif {{__('accounting::modules.accounting.shortStatement')}}  {{App\Helper\Arabic::arNums($entry->code->code)}} - {{App\Helper\Arabic::arNums($entry->code->breadcrumb)}}
                                    </td>
                                </tr>


                        @endForeach

                        @if ($creditCount >1)
                        <tr style="border:none;">
                            <td style="width: 10%;border:none;border-left:1px solid black;text-align:center"></td>
                            <td style="width: 10%;border:none;border-left:1px solid black;text-align:center"></td>
                            <td style="width: 55%;border:none;border-left:1px solid black;border-right:1px solid black;">
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                {{__('accounting::modules.accounting.toMentioned')}}
                            </td>
                        </tr>
                        @endif



                        @foreach ($record->entries->where('type','=','CREDIT') as $entry)
                        <tr style="border:none;">
                            <td style="width: 10%;border:none;border-left:1px solid black;text-align:center"></td>
                            <td style="width: 10%;border:none;border-left:1px solid black;text-align:center">{{App\Helper\Arabic::arNums($entry->amount)}}</td>
                            <td style="width: 55%;border:none;border-left:1px solid black;border-right:1px solid black;">
                                &nbsp;&nbsp;&nbsp;&nbsp;                    
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                @if (!($creditCount >1)){{__('accounting::modules.accounting.to')}}  @endif {{__('accounting::modules.accounting.shortStatement')}}  {{App\Helper\Arabic::arNums($entry->code->code)}} - {{App\Helper\Arabic::arNums($entry->code->breadcrumb)}}
                            </td>
                        </tr>
                    @endForeach

                        <tr style="border:none;">
                            <td style="width: 10%;border:none;border-left:1px solid black;"></td>
                            <td style="width: 10%;border:none;border-left:1px solid black;"></td>
                            <td style="width: 55%;border:none;border-left:1px solid black;border-right:1px solid black;text-align:center;border-bottom:1px solid black">
                                <div name="description" style="width:100%;background-color:#ffffff;"> @if(!is_null($record->description) && !empty($record->description)) ({{App\Helper\Arabic::arNums($record->description)}}) @endIF</div>
                            </td>
                        </tr>
            @endForeach
        <tbody>
    </table>

        




</center>
</body>
</html>