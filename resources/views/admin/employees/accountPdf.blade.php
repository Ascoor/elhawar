

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
                    <th rowspan="5" style="text-align: center;"> <br><a><img  width="1000%" src="{{ $global->logo_url }}" alt="home"/></a></th>
                    <th rowspan="5" style="font-weight: bolder; font-size: 12px">{{$arabicTitle}}</th>
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
        <div class="white-box">
            <table class="styled-table" style="width: 100%; text-align: center; font-size: 14px">
                <thead>
                <tr>
                    <th style="border: 1px sold #0b0b0b" colspan="2">مبلغ</th>
                    <th style="border: 1px sold #0b0b0b" colspan="2">وظيفه</th>
                    <th style="border: 1px sold #0b0b0b" colspan="3">اسم</th>
                    <th style="border: 1px sold #0b0b0b" colspan="3">رقم حساب</th>
                    <th style="border: 1px sold #0b0b0b">رقم</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($contents as $content )
                        <tr>
                            <td style="border: 1px sold #0b0b0b; font-size: 10px"colspan="2">{{strtr($content['Net'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td style="border: 1px sold #0b0b0b; font-size: 10px"colspan="2">{{strtr($content['designation'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td style="border: 1px sold #0b0b0b; font-size: 10px"colspan="3">{{strtr($content['name'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td style="border: 1px sold #0b0b0b; font-size: 10px"colspan="3">{{strtr($content['banck_account'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td style="border: 1px sold #0b0b0b; font-size: 10px">{{strtr($content['ind'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                        </tr>
                    @endforeach
                </tbody>
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




