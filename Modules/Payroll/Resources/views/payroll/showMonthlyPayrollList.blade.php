

<head>

</head>
<body>
<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <table class="styled-table" style="width: 100%; text-align: center; border-collapse: none">
                <thead>
                <tr>
                    <th colspan="5" rowspan="5" style="text-align: left;"> <br><a><img  width="900%" src="{{ $global->logo_url }}" alt="home"/></a></th>
                    <th colspan="8" rowspan="5" style="font-weight: bolder; font-size: 15px">{{$arabicTitle}}</th>
                    <th colspan="4">مديرية الشباب والرياضة</th>
                </tr>
                <tr>
                    <th colspan="4" style="font-size: 12px"> الحوار للالعاب الرياضية</th>
                </tr>
                <tr>
                    <th colspan="4" > الجزيرة-المنصورة</th>
                </tr>
                <tr>
                    <th colspan="4" style="background-color: #9d9d9d"> {{strtr("المشهرة برقم 260 لسنة 2002", array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</th>
                </tr>
                <tr>
                    <th colspan="4"></th>
                </tr>
                <tr>
                    <th style=" background-color: #b5ccd4; border-right: 1px dashed #ffffff" rowspan="2" >خصم</th>
                    <th style=" background-color: #b5ccd4; border-right: 1px dashed #ffffff" rowspan="2" >@lang('payroll::modules.payroll.notices')</th>
                    <th style=" background-color: #b5ccd4; border-right: 1px dashed #ffffff" rowspan="2" >@lang('payroll::modules.payroll.signatureOfReceipt')</th>
                    <th style=" background-color: #b5ccd4; border-right: 1px dashed #ffffff" rowspan="2" >@lang('payroll::modules.payroll.net')</th>
                    <th style=" background-color: #b5ccd4; border-right: 1px dashed #ffffff" rowspan="2" >@lang('payroll::modules.payroll.totalDeductions')</th>
                    <th style=" background-color: #b5ccd4; border-right: 1px dashed #ffffff; border-bottom: 1px dashed #ffffff" rowspan="1" colspan="4">@lang('payroll::modules.payroll.deductions')</th>
                    <th style=" background-color: #b5ccd4; border-right: 1px dashed #ffffff" rowspan="2" >@lang('payroll::modules.payroll.totalAccruals')</th>
                    <th style=" background-color: #b5ccd4; border-right: 1px dashed #ffffff" rowspan="2" >@lang('payroll::modules.payroll.clubPercentageBasic')</th>
                    <th style=" background-color: #b5ccd4; border-right: 1px dashed #ffffff" rowspan="2" >@lang('payroll::modules.payroll.total')</th>
                    <th style=" background-color: #b5ccd4; border-right: 1px dashed #ffffff" rowspan="2" >@lang('payroll::modules.payroll.allowances')</th>
                    <th style=" background-color: #b5ccd4; border-right: 1px dashed #ffffff" rowspan="2" >@lang('payroll::modules.payroll.basic')</th>
                    <th style=" background-color: #b5ccd4; border-right: 1px dashed #ffffff" rowspan="2" >@lang('payroll::modules.payroll.daysNo')</th>
                    <th style=" background-color: #b5ccd4; border-right: 1px dashed #ffffff" rowspan="2" >@lang('payroll::modules.payroll.designation')</th>
                    <th style=" background-color: #b5ccd4; border-right: 1px dashed #ffffff" rowspan="2" >@lang('app.name')</th>
                    <th colspan="1" style=" background-color: #b5ccd4; border-left: 1px dashed #ffffff" rowspan="2" >#</th>
                </tr>
                <tr>
                    <th style=" background-color: #b5ccd4; border-right: 1px dashed #ffffff" >@lang('payroll::modules.payroll.incomeTaxes')</th>
                    <th style=" background-color: #b5ccd4; border-right: 1px dashed #ffffff" >@lang('payroll::modules.payroll.others')</th>
                    <th style=" background-color: #b5ccd4; border-right: 1px dashed #ffffff" >@lang('payroll::modules.payroll.employeePercentage')</th>
                    <th style=" background-color: #b5ccd4; border-left: 1px dashed #ffffff" >@lang('payroll::modules.payroll.clubPercentage')</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($contents as $item)
                        <tr>
                                
                            
                            <td colspan="1" style=" border: 1px solid black" >
                                {{-- <table  bordercolor="blue">
                                    <tr>
                                        <td>Table 2</td>
                                    </tr>
                                    <tr>
                                        <td> Table 2 </td>
                                    </tr>
                                </table> --}}
                                 <table  bordercolor="blue">
                                    {{-- <tr>
                                        <td>{{$item['thisMonthAbsence']}}</td>
                                    </tr>

                                    <tr>
                                        <td> {{ $item['previousMonthAbsence'] }} </td>
                                    </tr>
                                    --}}

                                     <tr>
                                        <td>  {{ $item['lateCount'] }} </td>
                                    </tr>

                                    <tr>
                                        <td>  {{ $item['leaveCount'] }} </td>
                                    </tr> 

                                    <tr>
                                        <td>  {{ $item['markAbsentUnpaid'] }} </td>
                                    </tr>
 {{--
                                    <tr>
                                        <td>  {{ $item['markLate3Days1AbsentUnpaid'] }} </td>
                                    </tr> --}}

                                    {{-- <tr>
                                     
                                        <td>  {{ $item['markPermission3Days1AbsentUnpaid'] }} </td>
                                    </tr> --}}

                                    {{-- <tr>
                                        <td>  {{ $item['markLate2HalfDay1AbsentUnpaid'] }} </td>
                                    </tr> --}}

                                    
                                    <tr>
                                        <td>  {{ $item['penalityDuration'] }} </td>
                                    </tr>

                                    {{-- penalityDuration --}}

                                </table>
                                {{--  --}}
                                
                                {{-- {{$item['thisMonthAbsence']}} --}}
                                {{-- {{ $item['previousMonthAbsence'] }}, --}}
                                {{-- {{ $item['late'] }}, --}}
                                {{-- {{ $item['permissions'] }},
                                {{ $item['leaveCount'] }}, --}}
                                {{-- {{ $item['markAbsentUnpaid'] }},
                                {{ $item['markLate3Days1AbsentUnpaid'] }},
                                {{ $item['markPermission3Days1AbsentUnpaid'] }},
                                {{ $item['markLate2HalfDay1AbsentUnpaid'] }}, --}}

                               
                            
                            </td>
                            <td style=" border: 1px solid black" ></td>
                            <td style=" border: 1px solid black" ></td>
                            {{-- $content[$ind]['reasonOtherDed'] --}}
                            

                            <td style=" border: 1px solid black" >{{strtr($item['Net'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td style=" border: 1px solid black" >{{strtr($item['TotalDeductions'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td style=" border: 1px solid black" >{{strtr($item['TDS'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            {{-- <td style=" border: 1px solid black" >90000</td> --}}
                            <td style=" border: 1px solid black" >{{strtr($item['OtherDifferences'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td style=" border: 1px solid black" >{{strtr($item['ded2'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td style=" border: 1px solid black" >{{strtr($item['ded1'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td style=" border: 1px solid black" >{{strtr($item['TotalAccruals'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td style=" border: 1px solid black" >{{strtr($item['ear1'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td style=" border: 1px solid black" >{{strtr($item['Total'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td style=" border: 1px solid black" >{{strtr($item['Allowance'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td style=" border: 1px solid black" >{{strtr($item['Basic'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td style=" border: 1px solid black" >{{strtr($item['NoOfDays'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td style=" border: 1px solid black" >{{strtr($item['designation'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td style=" border: 1px solid black" >{{strtr($item['name'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td style=" border: 1px solid black" >{{strtr($item['ind'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                        </tr>
                    @endforeach
                <tr>
                    <td style=" border: 1px solid black" ></td>
                    <td style=" border: 1px solid black" ></td>
                    <td style=" border: 1px solid black" >{{$totalNet}}</td>
                    <td style=" border: 1px solid black" >{{$totalTdeduc}}</td>
                    <td style=" border: 1px solid black" >{{$totalTDS}}</td>
                    <td style=" border: 1px solid black" >{{$tDiffOthers}}</td>
                    <td style=" border: 1px solid black" >{{$totalDed2}}</td>
                    <td style=" border: 1px solid black" >{{$totalDed1}}</td>
                    <td style=" border: 1px solid black" >{{$totalAccuir}}</td>
                    <td style=" border: 1px solid black" >{{$totalEar1}}</td>
                    <td style=" border: 1px solid black" >{{$totalTotal}}</td>
                    <td style=" border: 1px solid black" >{{$totalAllow}}</td>
                    <td style=" border: 1px solid black" >{{$totalBasic}}</td>
                    <td style=" border: 1px solid black" colspan="4">@lang('payroll::modules.payroll.total')</td>
                </tr>
                <tr>
                    <td style=" border: 1px solid black; font-weight: bolder; font-size: 15px;font-weight: 300; font-style: normal;" colspan="17">{{$arabicTotalAmount}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>




