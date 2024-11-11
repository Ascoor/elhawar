

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
            <table class="styled-table" style="width: 100%; text-align: center; border-collapse: none; font-size: 9px">
                <thead>
                <tr>
                    <th rowspan="5" style="text-align: center;"> <br><a><img  width="900%" src="{{ $global->logo_url }}" alt="home"/></a></th>
                    <th rowspan="5" style="font-weight: bolder; font-size: 9px">{{$arabicTitle}}</th>
                    <th>مديرية الشباب والرياضة</th>
                </tr>
                <tr>
                    <th> الحوار للالعاب الرياضية</th>
                </tr>
                <tr>
                    <th> الجزيرة-المنصورة</th>
                </tr>
                <tr>
                    <th style="; background-color: #1796c4; color:azure">{{strtr("المشهرة برقم 260 لسنة 2002", array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</th>
                </tr>
                <tr>
                    <th></th>
                </tr>
                </thead>
            </table>
            <table class="styled-table" style="width: 100%; text-align: center; font-size: 9px">
                <thead style="background: #2596be">
                <tr>
                    <th style="border: 1px sold #3378c2; background-color: #1796c4; color:azure; font-size: 4px">الصافي</th>
                    <th style="border: 1px sold #3378c2; background-color: #1796c4; color:azure; font-size: 4px">المخصوم</th>
                    @foreach ($monthslabels as $monthslabel)
                    <th style="border: 1px sold #3378c2; background-color: #1796c4; color:azure">{{strtr($monthslabel, array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</th>
                    @endforeach
                    <th style="border: 1px sold #3378c2; background-color: #1796c4; color:azure; font-size:4px">الاعتيادي</th>
                    <th style="border: 1px sold #3378c2; background-color: #1796c4; color:azure" colspan="3">الرقم القومي</th>
                    <th style="border: 1px sold #3378c2; background-color: #1796c4; color:azure; font-size:6px" colspan="2">تاريخ الالتحاق بالمنشاة</th>
                    <th style="border: 1px sold #3378c2; background-color: #1796c4; color:azure; font-size:6px" colspan="2">تاريخ الاشتراك في التامين</th>
                    <th style="border: 1px sold #3378c2; background-color: #1796c4; color:azure" colspan="3">الرقم التاميني</th>
                    <th style="border: 1px sold #3378c2; background-color: #1796c4; color:azure" colspan="2">الوظيفة</th>
                    <th style="border: 1px sold #3378c2; background-color: #1796c4; color:azure" colspan="3">الاسم</th>
                    <th style="border: 1px sold #3378c2; background-color: #1796c4; color:azure"> م </th>
                </tr>
                </thead>
                <tbody style="">
                    @foreach ($contents as $content )
                        <tr> 
                            <td style="border: 0.5px sold #0b0b0b; font-size:6px">{{strtr($content['left_leaves'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td style="border: 0.5px sold #0b0b0b; font-size:6px">{{strtr($content['taken_leaves'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td style="border: 0.5px sold #0b0b0b; font-size:6px">{{strtr($content['m12'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td style="border: 0.5px sold #0b0b0b; font-size:6px">{{strtr($content['m11'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td style="border: 0.5px sold #0b0b0b; font-size:6px">{{strtr($content['m10'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td style="border: 0.5px sold #0b0b0b; font-size:6px">{{strtr($content['m9'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td style="border: 0.5px sold #0b0b0b; font-size:6px">{{strtr($content['m8'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td style="border: 0.5px sold #0b0b0b; font-size:6px">{{strtr($content['m7'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td style="border: 0.5px sold #0b0b0b; font-size:6px">{{strtr($content['m6'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td style="border: 0.5px sold #0b0b0b; font-size:6px">{{strtr($content['m5'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td style="border: 0.5px sold #0b0b0b; font-size:6px">{{strtr($content['m4'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td style="border: 0.5px sold #0b0b0b; font-size:6px">{{strtr($content['m3'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td style="border: 0.5px sold #0b0b0b; font-size:6px">{{strtr($content['m2'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td style="border: 0.5px sold #0b0b0b; font-size:6px">{{strtr($content['m1'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td style="border: 0.5px sold #0b0b0b; font-size:6px">{{strtr($content['regular_leave_balance'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td style="border: 0.5px sold #0b0b0b; font-size:6px" colspan="3">{{strtr($content['national_id'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td style="border: 0.5px sold #0b0b0b; font-size:6px" colspan="2">{{strtr($content['joining_date'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td style="border: 0.5px sold #0b0b0b; font-size:6px" colspan="2">{{strtr($content['insuranceStartDate'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td style="border: 0.5px sold #0b0b0b; font-size:6px" colspan="3">{{strtr($content['insuranceNumber'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td style="border: 0.5px sold #0b0b0b; font-size:6px" colspan="2">{{strtr($content['designation'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td style="border: 0.5px sold #0b0b0b; font-size:6px" colspan="3">{{strtr($content['name'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td style="border: 0.5px sold #0b0b0b; font-size:6px">{{strtr($content['ind'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        <table class="styled-table" style="width: 100%; text-align: center; border-collapse: none; font-size: 15px">
            <thead>
            <tr>
                <th>مدير عام النادي</th>
                <th>ش . ع</th>
                <th>مسئول الاجازات</th>
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




