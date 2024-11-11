@push('head-script')


    <link href = "https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.2/themes/smoothness/jquery-ui.min.css" rel = "stylesheet">

    
    

@endpush

@push('footer-script')

<!-- others -->

<!--Included in the main footer<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>-->

<script type="text/javascript">

         $(function() {
            $( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true, changeYear: true});
         });
    
    
    @if (App::isLocale('ar'))
        jQuery(function($){
        	$.datepicker.regional.ar={closeText:"إغلاق",prevText:"&#x3C;السابق",nextText:"التالي&#x3E;",currentText:"اليوم",monthNames:["يناير","فبراير","مارس","أبريل","مايو","يونيو","يوليو","أغسطس","سبتمبر","أكتوبر","نوفمبر","ديسمبر"],monthNamesShort:["1","2","3","4","5","6","7","8","9","10","11","12"],dayNames:["الأحد","الاثنين","الثلاثاء","الأربعاء","الخميس","الجمعة","السبت"],dayNamesShort:["أحد","اثنين","ثلاثاء","أربعاء","خميس","جمعة","سبت"],dayNamesMin:["ح","ن","ث","ر","خ","ج","س"],weekHeader:"أسبوع",dateFormat:"yy-mm-dd",firstDay:6,isRTL:!0,showMonthAfterYear:!1,yearSuffix:""};
        	$.datepicker.setDefaults($.datepicker.regional['ar']);
        });
    @endif
</script>

@endpush    
