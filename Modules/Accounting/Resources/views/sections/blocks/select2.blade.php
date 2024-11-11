@push('head-script')
<!-- Select 2-->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />

{{-- rola added select2 css --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />

@endpush

@push('footer-script')
<!-- Select 2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<script>

$(document).ready(function() {
initSelectors();
});


function initSelectors()
{
$( '.select2' ).select2({
    @if (App::isLocale('ar'))

    dir: "rtl",

    @endif

    ajax: {
      url: "{{$select2URL}}",
      type: "post",
      dataType: 'json',
      data: function (params) {
        return {
          _token: '{{csrf_token()}}',
          search: params.term, // search term
            {!!$select2SentData!!}
        };
      },
      processResults: function (response) {
        return {
          results: response
        };
      },
      cache: true
    },
    //rola added placeholder
    placeholder:"{{__('accounting::modules.accounting.code')}}/{{__('accounting::modules.accounting.name')}}"

  });
}
</script>
@endpush
