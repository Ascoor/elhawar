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
                    <th rowspan="3" style="text-align: center;"><img width="100px" height="100px" src="{{ $employee->image_url }}" alt="usr"/></th>
                    <th></th>
                </tr>

                <tr>
                    <th>  مديرية الشباب والرياضه بالدقهلية </th>
                </tr>
                <tr>
                    <th>الجزيرة - المنصورة</th>
                </tr>
                </thead>
            </table>

        <br>
        <br>
        <br>
        <div class="white-box">
            <table class="styled-table" style="width: 100%; text-align: center; border: 1px solid #0b0b0b; font-size: 14px">
                <thead>
                <tr>
                    <th height="35px" style="font-size: 20px;font-weight: 1000; border: 1px solid #0b0b0b" colspan="2">بيان حاله</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td style="border: 1px solid #0b0b0b">{{ ucwords($employee->name) }}</td>
                    <td style="font-weight: 1000; border: 1px solid #0b0b0b">الاسم</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #0b0b0b">{{ (!is_null($employee->employeeDetail) && !is_null($employee->employeeDetail->designation)) ? ucwords($employee->employeeDetail->designation->name) : '-' }}</td>
                    <td style="font-weight: 1000; border: 1px solid #0b0b0b">الوظيفة</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #0b0b0b">{{strtr($employee->employeeDetail->qualification, array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                    <td style="font-weight: 1000; border: 1px solid #0b0b0b">الؤهل الدراسي</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #0b0b0b">{{strtr($employee->employeeDetail->national_id, array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                    <td style="font-weight: 1000; border: 1px solid #0b0b0b">الرقم القومي</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #0b0b0b"></td>
                    <td style="font-weight: 1000; border: 1px solid #0b0b0b">الموقف من التجنيد</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #0b0b0b">{{strtr((!is_null($employee->employeeDetail)) ? $employee->employeeDetail->address : '-', array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                    <td style="font-weight: 1000; border: 1px solid #0b0b0b">عنوان المراسلات</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #0b0b0b">{{strtr((!is_null($employee->employeeDetail)) ? $employee->employeeDetail->joining_date->format($global->date_format) : '-', array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                    <td style="font-weight: 1000; border: 1px solid #0b0b0b">تاريخ الالتحاق بالعمل</td>
                </tr>
                <tr>
                    <td style="border: 1px solid #0b0b0b">{{strtr($employee->employeeDetail->insuranceNumber, array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                    <td style="font-weight: 1000; border: 1px solid #0b0b0b">الرقم التاميني</td>
                </tr>
                <tr>
                    <td height="25px" style="border: 1px solid #0b0b0b">{{strtr($employee->insuranceStartDate, array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                    <td style="font-weight: 1000; border: 1px solid #0b0b0b">تاريخ الاشتراك في التامين</td>
                </tr>
                <tr>
                    <td height="25px" style="border: 1px solid #0b0b0b">{{strtr($employee->mobile ?? '-', array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                    <td style="font-weight: 1000; border: 1px solid #0b0b0b">رقم الموبيل</td>
                </tr>
                <tr>
                    <td height="25px" style="border: 1px solid #0b0b0b">{{strtr($employee->email, array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                    <td style="font-weight: 1000; border: 1px solid #0b0b0b">الايميل</td>
                </tr>
                <tr>
                    <th colspan="2" style="font-size: 15px;font-weight: 1000; border: 1px solid #0b0b0b">  تحريرا في    {{strtr($date, array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</th>
                </tr>
                </tbody>
            </table>
        </div>
        <br>
        <table class="styled-table" style="width: 100%; text-align: center; border-collapse: none; font-size: 15px">
            <thead>
            <tr>
                <th>مدير عام النادي</th>
                <th>ش . ع</th>
                <th>ملفات</th>
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




