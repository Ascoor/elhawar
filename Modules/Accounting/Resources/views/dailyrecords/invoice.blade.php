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
    padding:2px;
    
}


th
{
    padding:2px;
}


        </style>
</head>
<body>

<center>
    <div style='width:100%;text-align:center'>
        <h1>
            <b style="text-align:center;">
                {{__('accounting::modules.accounting.report')}} / {{$type}} / {{__('accounting::modules.accounting.journalEntryNo')}} : <span style='direction:ltr!important'> {{App\Helper\Arabic::arNums($record['journalEntryNo'])}}</span> / {{__('accounting::modules.accounting.date')}} : {{App\Helper\Arabic::arNums($record['date'])}}
            </b>
        </h1>
    </div>

    @php
        $rowspan=$record->entries->count()+1;
        $debitCount=$record->entries->where('type','=','DEBIT')->count();
        $creditCount=$record->entries->where('type','=','CREDIT')->count();
        $rowspan+=($debitCount >1)?1:0;
        $rowspan+=($creditCount >1)?1:0;
    @endphp



    <table >
        <thead>

            <tr>
                <th style="width: 15%">{{__('accounting::modules.accounting.debtor')}}</th>
                <th style="width: 15%">{{__('accounting::modules.accounting.creditor')}} </th>
                <th style="width: 50%">{{__('accounting::modules.accounting.statement')}}</th>
                <th style="width: 20%" rowspan="{{$rowspan}}">{{__('accounting::modules.accounting.date')}}</th>
            </tr>

        </thead>
        <tbody>

            @foreach ($record->entries->where('type','=','DEBIT') as $entry)

                @if ($loop->first)
                    <tr style="border:none;">
                        <td style="width: 15%;border:none;border-left:1px solid black"></td>
                        <td style="width: 15%;border:none;border-left:1px solid black"></td>
                        <td style="width: 50%;border:none;border-left:1px solid black;border-right:1px solid black;"></td>
                        <td style="width: 20%;border:none;">{{App\Helper\Arabic::arNums(date('m/d',strtotime($record->date)))}}</td>
                    </tr>

                    @if ($debitCount >1)
                        <tr style="border:none;">
                            <td style="width: 15%;border:none;border-left:1px solid black"></td>
                            <td style="width: 15%;border:none;border-left:1px solid black"></td>
                            <td style="width: 50%;border:none;border-left:1px solid black;border-right:1px solid black;">
                                {{__('accounting::modules.accounting.fromMentioned')}}
                            </td>
                        </tr>
                    @endIf
                @endIf

                <tr style="border:none;">
                    <td style="width: 15%;border:none;border-left:1px solid black">{{App\Helper\Arabic::arNums($entry->amount)}}</td>
                    <td style="width: 15%;border:none;border-left:1px solid black"></td>
                    <td style="width: 50%;border:none;border-left:1px solid black;border-right:1px solid black;">
                        @if (!($debitCount >1)) {{__('accounting::modules.accounting.from')}}  @endif {{__('accounting::modules.accounting.shortStatement')}}  {{App\Helper\Arabic::arNums($entry->code->code)}} - {{App\Helper\Arabic::arNums($entry->code->breadcrumb)}}
                    </td>

                 </tr>

            @endForeach

            @if ($creditCount >1)
            <tr style="border:none;">
                <td style="width: 15%;border:none;border-left:1px solid black"></td>
                <td style="width: 15%;border:none;border-left:1px solid black"></td>
                <td style="width: 50%;border:none;border-left:1px solid black;border-right:1px solid black;">
                    &nbsp;&nbsp;&nbsp;&nbsp;
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
                <td style="width: 15%;border:none;border-left:1px solid black"></td>
                <td style="width: 15%;border:none;border-left:1px solid black">{{App\Helper\Arabic::arNums($entry->amount)}}</td>
                <td style="width: 50%;border:none;border-left:1px solid black;border-right:1px solid black;">
                    
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;

                    @if (!($creditCount >1)){{__('accounting::modules.accounting.to')}}  @endif {{__('accounting::modules.accounting.shortStatement')}} {{App\Helper\Arabic::arNums($entry->code->code)}} - {{App\Helper\Arabic::arNums($entry->code->breadcrumb)}}
                </td>
            </tr>
        @endForeach

            <tr style="border:none;">
                <td style="width: 15%;border:none;border-left:1px solid black"></td>
                <td style="width: 15%;border:none;border-left:1px solid black"></td>
                <td style="width: 50%;border:none;border-left:1px solid black;border-right:1px solid black;text-align:center">
                    <div name="description" style="width:100%;background-color:#ffffff;">@if(!is_null($record->description) && !empty($record->description)) ({{App\Helper\Arabic::arNums($record->description)}}) @endIF</div>
                </td>
                <td style="width: 20%;border:none;"></td>
            </tr>

        <tbody>
    </table>

    <div >       
        <label >{{__('accounting::modules.accounting.approval')}}</label>
        <div class="table-responsive mb-2">
        
        <table class="table">
            <thead>
                <tr>
                    <th>{{__('accounting::modules.accounting.reviewer_assign')}}</th>
                    <th>{{__('accounting::modules.accounting.financial_accountant_assign')}}</th>
                    <th>{{__('accounting::modules.accounting.financial_director_assign')}}</th>
        
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$record->reviewer_assign ? __('accounting::modules.accounting.yes') : __('accounting::modules.accounting.no')}}</td>
                    <td>{{$record->financial_accountant_assign ? __('accounting::modules.accounting.yes') : __('accounting::modules.accounting.no')}}</td>
                    <td>{{$record->financial_director_assign ? __('accounting::modules.accounting.yes') : __('accounting::modules.accounting.no')}}</td>
                </tr>
            </tbody>
        </table>
        </div>
        
        




</center>
</body>
</html>