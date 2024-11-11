
{{-- rola added style  --}}
<style>

    #tableid {
  /*  background-color: red !important */
      /* border-collapse: collapse;
      width: 100%; */
  /* width: 100% !important; 
  table-layout: fixed;
  width: 100%;   */
  /* max-width: 50vh !important; */

  border-collapse: collapse; 
  table-layout: fixed;
    } 
    
    th, td {
      /* text-align: left;
      padding: 8px; */
      /* background-color: black !important */
      word-wrap: break-word !important; 
    white-space: nowrap !important;
    /* text-align: right;  */
    padding:1.5rem !important;
    }
    
    tr:nth-child(even) {background-color: #f2f2f2c0;}
</style>

    

     
{{-- <style>
/* table { 
    /* table-layout:fixed !important; * /
    /* width: 100% !important; * /
    width: 100vw !important;
    
  /* height: 100vh!important; * /
}

td { 
    /* overflow: hidden !important; 
    text-overflow: ellipsis !important; * /
    word-wrap: break-word !important; 
    white-space: nowrap !important;
}

/* @media only screen and (max-width: 480px) {
    /* horizontal scrollbar for tables if mobile screen * /
    table{
        overflow-x: auto;
        display: block;
    }
} * /
</style>  --}}


<body>
<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <table id="tableid" class="styled-table" style="width: 100%; text-align: center; border-collapse: none; table-layout: fixed;">
                <thead>
                <tr>
                    <th colspan="4" rowspan="5" style="text-align: left;"> <br><a><img  width="900%" src="{{ $global->logo_url }}" alt="home"/></a></th>
                    <th colspan="3" rowspan="5" style="font-weight: bolder; font-size: 15px">{{$arabicTitle}}</th>
                    <th colspan="3">مديرية الشباب والرياضة</th>
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
                    {{-- rola --}}
                    <th style=" background-color: #b5ccd4; border-right: 1px dashed #ffffff">إجمالي  مدة الخصم</th>

                    <th style=" background-color: #b5ccd4; border-right: 1px dashed #ffffff">الحضور</th>
                    <th style=" background-color: #b5ccd4; border-right: 1px dashed #ffffff">اذن\تصريح</th>
                    <th style=" background-color: #b5ccd4; border-right: 1px dashed #ffffff">الاجازات</th>
                    <th style=" background-color: #b5ccd4; border-right: 1px dashed #ffffff">الراحات</th>
                    <th style=" background-color: #b5ccd4; border-right: 1px dashed #ffffff">تاخير</th>
                    <th style=" background-color: #b5ccd4; border-right: 1px dashed #ffffff">غياب الشهر الحالي</th>
                    <th style=" background-color: #b5ccd4; border-right: 1px dashed #ffffff">غياب الشهر السابق</th>
                    <th  style=" background-color: #b5ccd4; border-right: 1px dashed #ffffff">@lang('app.name')</th>
                    <th style=" background-color: #b5ccd4; border-left: 1px dashed #ffffff">#</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($contents as $item)
                        <tr>
                            {{-- rola --}}
                            <td style=" border: 1px solid black" >{{strtr($item['penalityDuration'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            
                            <td style=" border: 1px solid black" >{{strtr($item['presence'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td style=" border: 1px solid black" >{{strtr($item['permission'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td style=" border: 1px solid black" >{{strtr($item['leaveCount'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td style=" border: 1px solid black" >{{strtr($item['holidays'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td style=" border: 1px solid black" >{{strtr($item['late'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td style=" border: 1px solid black" >{{strtr($item['thisMonthAbsence'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td style=" border: 1px solid black" >{{strtr($item['previousMonthAbsence'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            
                            {{-- rola added text-align: right; --}}
                            <td  style=" border: 1px solid black  text-align: right; " >{{strtr($item['name'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            <td style=" border: 1px solid black  text-align: right; " >{{strtr($item['ind'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            {{-- <td>&nbsp;</td> gave an error --}}
                        </tr>
                    @endforeach
                <tr>
                    <td style=" border: none; font-weight: bolder; font-size: 15px;font-weight: 300; font-style: normal;" colspan="4">مدير شئون العاملين</td>
                    <td style=" border: none; font-weight: bolder; font-size: 13px;font-weight: 300; font-style: normal;" colspan="3">ملفات</td>
                    <td style=" border: none; font-weight: bolder; font-size: 13px;font-weight: 300; font-style: normal;" colspan="3">مسئول البصمه</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
{{-- <script>
    $("#tableid").width($(window).width());
    $("#tableid").style.width = window.innerWidth;
$("#tableid").style.height = window.innerHeight;
</script> --}}
</body>





