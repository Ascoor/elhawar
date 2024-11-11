<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{__('accounting::modules.accounting.report')}}</title>
    <style>
    table, th, td {
    border: 1px solid black;
    page-break-inside: avoid; 
    }

    td
    {
        padding:2px;
    }

    </style>
</head>
<body>

    <table style="width: 100%;border:none; text-align: center;" >
        <thead style="border:none">
            <tr style="border:none">
                <th style="border:none">
                    {!!__('accounting::modules.accounting.tcpdf_report_head')!!}
                </th>
                @if (App::isLocale('ar')) 
                     <th style="border:none;"></th>
                @endif
                <th style="border:none;"><img src="{{$tcpdf_logo}}"></th>
                @if (App::isLocale('en')) 
                <th style="border:none;"></th>
                @endif

            </tr>
        </thead>
    </table>
    <table class="styled-table" style="width: 100%; text-align: center;">
        <thead>
        <tr>
            <th style="background-color:antiquewhite"><h2>@yield('report-title')</h2></th>
        </tr>
        <tr>
            <th style="background-color: azure"><h4>@yield('report-subtitle')</h4></th>
        </tr>
        </thead>
    </table>

    @yield('report-content')
    
</body>
</html>