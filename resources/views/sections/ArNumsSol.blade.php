<!-- Arabic Numbers Workaround -->
<style>
    @font-face{
        font-family:ArabicNumbers;
        @if(App::isLocale('ar'))
        src:url('{{asset("/fonts/cairo-all-ar-nums.woff2")}}');
        @else
        src:url('{{asset("/fonts/cairo.woff2")}}');
        @endif
        /*unicode-range: U+0030-0039,U+0660-0669;*//*Only NumericRanges*/

    }

    *:not([class*=" fa"], [class^=fa],[class^=fa-],[class*=" fa-"], [class*=" icon"], [class^=icon],[class*=" icon-"], [class^=icon-],[class*=" ti-"], [class^=ti-]){
        font-family:ArabicNumbers!important;
    }

</style>
<!-- /Arabic Numbers Workaround -->