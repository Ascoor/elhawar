

<head>
    <style>
        .bigH{
            height: 30px;
        }
        .midH{
            height: 22px;
        }
        .smalH{
            height: 15px;
        }
    </style>
</head>
<body>
<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <table class="styled-table" style="width: 100%; text-align: center; border-collapse: none">
                <thead>
                <tr>
                    <th colspan="2" rowspan="5" class="smalH" style="text-align: left;"> <br><a><img  width="900%" src="{{ $global->logo_url }}" alt="home"/></a></th>
                    <th colspan="3" class="smalH" style="font-weight: bolder; font-size: 18px">{{strtr($arabicTitle1, array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</th>
                    <th colspan="2" class="smalH">مديرية الشباب والرياضة</th>
                </tr>
                <tr>
                    <th colspan="3" class="smalH" style="font-weight: bolder; font-size: 18px">{{strtr($arabicTitle2, array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</th>
                    <th colspan="2" class="smalH" style="font-size: 15px"> الحوار للالعاب الرياضية</th>
                </tr>
                <tr>
                    <th colspan="3" rowspan="3" class="smalH" style="font-weight: bolder; font-size: 18px">{{strtr($arabicTitle3, array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</th>
                    <th colspan="2" class="smalH"> الجزيرة-المنصورة</th>
                </tr>
                <tr>
                    <th colspan="2" class="smalH" style="background-color: #9d9d9d"> {{strtr("المشهرة برقم 260 لسنة 2002", array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</th>
                </tr>
                <tr>
                    <th colspan="2" class="smalH"></th>
                </tr>
                <tr>
                    <td  class="midH" style=" border: none; font-weight: bolder; font-size: 15px;font-weight: 300; font-style: normal;" colspan="7"></td>
                </tr>
                <tr>
                    <td  class="midH" style=" border: none; font-weight: bolder; font-size: 15px;font-weight: 300; font-style: normal;" colspan="7"></td>
                </tr>
                <tr>
                    <th class="bigH"  style=" background-color: #b5ccd4; border-right: 1px dashed #ffffff">وصف الصنف</th>
                    <th class="bigH"  style=" background-color: #b5ccd4; border-right: 1px dashed #ffffff">اجمالي السعر</th>
                    <th class="bigH"  style=" background-color: #b5ccd4; border-right: 1px dashed #ffffff">السعر</th>
                    <th class="bigH"  style=" background-color: #b5ccd4; border-right: 1px dashed #ffffff">العدد\الكمية</th>
                    <th class="bigH"  colspan="2" style=" background-color: #b5ccd4; border-right: 1px dashed #ffffff">اسم الصنف</th>
                    <th class="bigH"  style=" background-color: #b5ccd4; border-left: 1px dashed #ffffff">#</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($contents as $item)
                        <tr>
                            <td class="midH" style=" border: 1px solid black" >{{strtr($item['summary'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td  class="midH" style=" border: 1px solid black" >{{strtr($item['totalprice'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td  class="midH" style=" border: 1px solid black" >{{strtr($item['price'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td  class="midH" style=" border: 1px solid black" >{{strtr($item['quantity'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td  class="midH" colspan="2" style=" border: 1px solid black" >{{strtr($item['name'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td  class="midH" style=" border: 1px solid black" >{{strtr($item['ind'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                        </tr>
                    @endforeach
                <tr>
                    <td  class="midH" style=" border: none; font-weight: bolder; font-size: 15px;font-weight: 300; font-style: normal;" colspan="7"></td>
                </tr>
                <tr>
                    <td  class="midH" style=" border: none; font-weight: bolder; font-size: 15px;font-weight: 300; font-style: normal;" colspan="7">{{strtr($total, array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                </tr>
                <tr>
                    <td  class="midH" style=" border: none; font-weight: bolder; font-size: 15px;font-weight: 300; font-style: normal;" colspan="7"></td>
                </tr>
                <tr>
                    <td  class="midH" style=" border: none; font-weight: bolder; font-size: 15px;font-weight: 300; font-style: normal;" colspan="7"></td>
                </tr>
                <tr>
                    <td  class="midH" style=" border: none; font-weight: bolder; font-size: 18px;font-weight: 300; font-style: normal;" colspan="3">رئيس مجلس الادارة</td>
                    <td  class="midH" style=" border: none; font-weight: bolder; font-size: 15px;font-weight: 300; font-style: normal;" colspan="2">امين الصندوق</td>
                    <td  class="midH" style=" border: none; font-weight: bolder; font-size: 15px;font-weight: 300; font-style: normal;" colspan="2">مدير النادي</td>
                </tr>
                
                <tr>
                    <td class="midH"  style=" border: none; font-weight: bolder; font-size: 12px;font-weight: 50; font-style: normal;" colspan="3"><img width="15px" src="{{ asset('front/img/check-mark.jpg') }}" alt="">  </td>
                    <td  class="midH" style=" border: none; font-weight: bolder; font-size: 12px;font-weight: 50; font-style: normal;" colspan="2"><img width="15px" src="{{ asset('front/img/check-mark.jpg') }}" alt="">  </td>
                    <td  class="midH" style=" border: none; font-weight: bolder; font-size: 12px;font-weight: 50; font-style: normal;" colspan="2"><img width="15px" src="{{ asset('front/img/check-mark.jpg') }}" alt="">  </td>
                </tr>
                <tr>
                    <td  class="midH" style=" border: none; font-weight: bolder; font-size: 12px;font-weight: 50; font-style: normal;" colspan="3">تصدق</td>
                    <td  class="midH" style=" border: none; font-weight: bolder; font-size: 12px;font-weight: 50; font-style: normal;" colspan="2">تمت الموافقة</td>
                    <td class="midH"  style=" border: none; font-weight: bolder; font-size: 12px;font-weight: 50; font-style: normal;" colspan="2">تمت الموافقة</td>
                </tr>
                </tbody>
            </table>
            <p>{{strtr($printing_date, array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</p>
        </div>
    </div>
</div>
</body>




