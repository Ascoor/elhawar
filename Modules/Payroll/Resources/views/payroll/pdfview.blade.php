

<head>
    <style>
img{
    border: 1px solid #213775;
    border-radius: 25px;
}
    </style>
</head>
<body>
<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <table class="styled-table" style="width: 100%; text-align: center; border-collapse: none; font-size: 12px">
                <thead>
                <tr>
                    <th rowspan="5" style="text-align: center;"> <br><a><img  width="1200%" src="{{ $global->logo_url }}" alt="home"/></a></th>
                    <th rowspan="5" style="font-weight: bolder; font-size: 15px"></th>
                    <th>مديرية الشباب والرياضة</th>
                </tr>
                <tr>
                    <th> الحوار للالعاب الرياضية</th>
                </tr>
                <tr>
                    <th> الجزيرة-المنصورة</th>
                </tr>
                <tr>
                    <th style="background-color: #9d9d9d">{{strtr("المشهرة برقم 260 لسنة 2002", array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</th>
                </tr>
                <tr>
                    <th></th>
                </tr>
                </thead>
            </table>
        </div>
            <table class="styled-table" style="width: 100%; text-align: center; border-collapse: none; font-size: 18px">
                <thead>
                <tr>
                    <th rowspan="3" style="text-align: center;"><img width="100px" height="100px" src="{{ $salarySlip->user->image_url }}" alt="usr"/></th>
                    <th></th>
                </tr>

                <tr>
                    <th> بيان مفردات مرتب عن شهر {{$arabicTitle}} </th>
                </tr>
                <tr>
                    <th>صوره غير قابلة للصرف</th>
                </tr>
                </thead>
            </table>
            <table class="styled-table" style="width: 100%; text-align: right; border-collapse: none; font-size: 12px">
                <thead>
                <tr>
                    <th height="20px" width="25%">{{ $designation_name }}</th>
                    <th width="15%">@lang('app.accountNo') :/</th>
                    <th width="35%">{{ $salarySlip->user->name }}</th>
                    <th width="10%">@lang('app.name') :/  </th>
                </tr>
                <tr>
                    <th>{{$Insured}}  مؤمن علية </th>
                    <th>الموقف من التامين</th>
                    <th width="35%">{{ $designation_name }}</th>
                    <th width="10%">@lang('payroll::modules.payroll.designation') :/</th>
                </tr>
                </thead>
            </table>
        <br>
        <div class="white-box">
            <table class="styled-table" style="width: 100%; text-align: center; border: 1px solid #0b0b0b; font-size: 14px">
                <thead>
                <tr>
                    <th style="font-size: 20px;font-weight: 1000; border: 1px solid #0b0b0b" colspan="2">@lang('payroll::modules.payroll.deductions')</th>
                    <th height="35px" style="font-size: 20px;font-weight: 1000; border: 1px solid #0b0b0b" colspan="2">@lang('payroll::modules.payroll.accruals')</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td height="25px" style="border: 1px solid #0b0b0b">{{strtr($deductionsArr['ded1'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                    <td style="font-weight: 1000; border: 1px solid #0b0b0b">@lang('payroll::modules.payroll.clubPercentage'){{strtr("18.75%", array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                    <td style="border: 1px solid #0b0b0b">{{strtr($basic, array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                    <td style="font-weight: 1000; border: 1px solid #0b0b0b">@lang('payroll::modules.payroll.basic')</td>
                </tr>
                <tr>
                    <td height="25px" style="border: 1px solid #0b0b0b">{{strtr($deductionsArr['ded2'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                    <td style="font-weight: 1000; border: 1px solid #0b0b0b">@lang('payroll::modules.payroll.employeePercentage'){{strtr("11%", array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                    <td style="border: 1px solid #0b0b0b">{{strtr($allownces, array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                    <td style="font-weight: 1000; border: 1px solid #0b0b0b">@lang('payroll::modules.payroll.allowances')</td>
                </tr>
                <tr>
                    <td height="25px" style="border: 1px solid #0b0b0b"></td>
                    <td style="font-weight: 1000; border: 1px solid #0b0b0b"></td>
                    <td style="border: 1px solid #0b0b0b">{{strtr($total, array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                    <td style="font-weight: 1000; border: 1px solid #0b0b0b">@lang('payroll::modules.payroll.total')</td>
                </tr>
                <tr>
                    <td height="25px" style="border: 1px solid #0b0b0b">{{strtr($penalities, array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                    <td style="font-weight: 1000; border: 1px solid #0b0b0b">@lang("app.menu.penalties")</td>
                    <td style="border: 1px solid #0b0b0b"></td>
                    <td style="font-weight: 1000; border: 1px solid #0b0b0b"></td>
                </tr>
                <tr>
                    <td height="25px" style="border: 1px solid #0b0b0b">{{strtr($deductionsArr['TDS'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                    <td style="font-weight: 1000; border: 1px solid #0b0b0b">@lang('payroll::modules.payroll.incomeTaxes')</td>
                    <td style="border: 1px solid #0b0b0b"></td>
                    <td style="font-weight: 1000; border: 1px solid #0b0b0b"></td>
                </tr>
                <tr>
                    <td height="25px" style="border: 1px solid #0b0b0b">{{strtr($diffFromOrg, array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                    <td style="font-weight: 1000; border: 1px solid #0b0b0b">@lang('payroll::modules.payroll.otherDeductions')</td>
                    <td style="border: 1px solid #0b0b0b"></td>
                    <td style="font-weight: 1000; border: 1px solid #0b0b0b"></td>
                </tr>
                <tr>
                    <td height="25px" style="border: 1px solid #0b0b0b"></td>
                    <td style="font-weight: 1000; border: 1px solid #0b0b0b"></td>
                    <td style="border: 1px solid #0b0b0b">{{strtr($earArr['ear1'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                    <td style="font-weight: 1000; border: 1px solid #0b0b0b">@lang('payroll::modules.payroll.clubPercentage') {{strtr("18.75%", array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                </tr>
                <tr>
                    <td height="25px" style="border: 1px solid #0b0b0b"></td>
                    <td style="font-weight: 1000; border: 1px solid #0b0b0b"></td>
                    <td style="border: 1px solid #0b0b0b">{{strtr($totalAcc, array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                    <td style="font-weight: 1000; border: 1px solid #0b0b0b">@lang('payroll::modules.payroll.totalAccruals')</td>
                </tr>
                <tr>
                    <td height="25px" style="border: 1px solid #0b0b0b">{{strtr($deductionsArr['TotalDeductions'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                    <td style="font-weight: 1000; border: 1px solid #0b0b0b">@lang('payroll::modules.payroll.totalDeductions')</td>
                    <td style="border: 1px solid #0b0b0b"></td>
                    <td style="font-weight: 1000; border: 1px solid #0b0b0b"></td>
                </tr>
                <tr>
                    <td height="25px" style="border: 1px solid #0b0b0b"></td>
                    <td style="font-weight: 1000; border: 1px solid #0b0b0b"></td>
                    <td style="border: 1px solid #0b0b0b">{{strtr($Net, array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                    <td style="font-weight: 1000; border: 1px solid #0b0b0b">@lang('payroll::modules.payroll.net')</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="white-box">
            <table class="styled-table" style="width: 100%; text-align: center; border: 1px solid #0b0b0b; font-size: 14px">
                <thead>
                <tr>
                    <th colspan="8" style="font-size: 20px;font-weight: 1000; border: 1px solid #0b0b0b"> خصم للغياب والتاخير والجزاءات</th>
                </tr>
                <tr>
                    <th> {{strtr($Absent, array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</th>
                    <th> ايام غياب </th>
                    <th>  {{strtr($holidays, array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</th>
                    <th> اجازات-مدفوعه </th>
                    <th>  {{strtr($late, array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</th>
                    <th> تاخير </th>
                    <th>  {{strtr($halfDay, array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</th>
                    <th> نصف يوم </th>
                </tr>
                <tr>
                    <th> {{strtr($permission, array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</th>
                    <th> اذن\تصريح </th>
                </tr>
                </thead>
            </table>
        </div>
        <table class="styled-table" style="width: 100%; text-align: center; border-collapse: none; font-size: 15px">
            <thead>
            <tr>
                <th>مدير عام النادي</th>
                <th>ش . ع</th>
                <th>المرتبات</th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            </thead>
        </table>
        </div>
    </div>

</body>




