@push('footer-script')
<!-- Select 2 -->


{{-- rola added css --}}
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}

{{-- locally --}}
{{-- rel="stylesheet" --}}
{{-- <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet"> --}}




{{-- net --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" /> 




<!-- Swal -->
{{-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
<!-- others -->
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<script>
    var debitRows=1;
    var creditorRows=1;
</script>
<script>
         $(function() {
            $( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true, changeYear: true @if (App::isLocale('ar')) , isRTL : true @endif});
         });
      </script>

<script>

    $(document).ready(function() {

        initSelectors();
        initDatepickers();
    });


function initSelectors()
{
    $( '.DSelCode' ).select2({
        @if (App::isLocale('ar'))

        dir: "rtl",

        @endif

        ajax: {
          url: "{{route('admin.accounting.dailyrecords.ajax',[$viewData['type'],'selCode'])}}",
          type: "post",
          dataType: 'json',
          data: function (params) {
            return {
              _token: '{{csrf_token()}}',
              search: params.term, // search term
              type:@if($viewData['type']=='revenue') 'ACC,CREDIBTOR' @else 'EXPEN,CREDIBTOR' @endif

            };
          },
          processResults: function (response) {
            return {
              results: response
            };
          },
          cache: true
        },
        placeholder:"{{__('accounting::modules.accounting.code')}}/{{__('accounting::modules.accounting.name')}}"
      });

      $( '.CSelCode' ).select2({
        @if (App::isLocale('ar'))

        dir: "rtl",

        @endif

        ajax: {
          url: "{{route('admin.accounting.dailyrecords.ajax',[$viewData['type'],'selCode'])}}",
          type: "post",
          dataType: 'json',
          data: function (params) {
            return {
              _token: '{{csrf_token()}}',
              search: params.term, // search term
              type:@if($viewData['type']=='revenue') 'REVEN,CREDIBTOR' @else 'ACC,CREDIBTOR' @endif
            };
          },
          processResults: function (response) {
            return {
              results: response
            };
          },
          cache: true
        },
        placeholder:"{{__('accounting::modules.accounting.code')}}/{{__('accounting::modules.accounting.name')}}"
      });



    }

///
function reIndex(type)
{
    if (type=='D')
          {
            cols=document.querySelectorAll('.DRIndex');

          }
          else if(type=='C')
          {
            cols=  document.querySelectorAll('.CRIndex');

          }  

          for(i=1;i<=cols.length;i++)
          {
              cols[i-1].innerText=i;
          }
  
}
///
function updateEntriesCounter(type)
{
    if (type=='D')
          {
                debitRows= document.querySelectorAll('#debitRows > tr').length;
          }
          else if(type=='C')
          {
                creditorRows=document.querySelectorAll('#creditorRows > tr').length;
          }  
          reIndex(type);
}
////
function delRow(id)
{
    var currentRowsCount= (id[0]=='D')? debitRows  : creditorRows  ;
  
    if ( currentRowsCount > 1)
    {
        document.querySelector('#'+id).remove();
        
        updateEntriesCounter(id[0]);
        upTotals();
    }
    else
    {
        Swal.fire({
            icon: 'error',
            title: '{{__("accounting::modules.accounting.sorry")}}',
            text: '{{__("accounting::modules.accounting.cannotDelRow")}}',
            confirmButtonText: '{{__("accounting::modules.accounting.ok")}}',
            })
    }
}
////
function upTotals()
{
    var totaldebt=0;
    var totalcredit=0;
    var total=0;

    document.querySelectorAll("input[name='debitAmounts[]']").forEach(i=>totaldebt+=parseFloat((i.value=="")?0:i.value));
    document.querySelectorAll("input[name='creditorAmounts[]']").forEach(i=>totalcredit+=parseFloat((i.value=="")?0:i.value));
    document.querySelectorAll("input[name='oldDebitAmounts[]']").forEach(i=>totaldebt+=parseFloat((i.value=="")?0:i.value));
    document.querySelectorAll("input[name='oldCreditorAmounts[]']").forEach(i=>totalcredit+=parseFloat((i.value=="")?0:i.value));

    total= totaldebt-totalcredit;

    document.querySelector('#totalCredit').value=parseFloat(totalcredit);
    document.querySelector('#totalDebt').value=parseFloat(totaldebt);
    document.querySelector('#total').value=parseFloat(total);

}
/////
function updateEntry(input)
{
    upTotals();
}
//
function addRow(type)
{
    var currentRowsCount= (type =='D')? debitRows  : creditorRows  ;
    var targetTBody=(type=='D')? '#debitRows' : '#creditorRows';
    var typeAmounts=(type =='D')? 'debitAmounts[]'  : 'creditorAmounts[]'  ;
	  var typeCodes=(type =='D')? 'debitCodes[]'  : 'creditorCodes[]'  ;
    var typeDates=(type=='D')?'debitDates[]':'creditorDates[]';
	  var tfstatment=(type=='D')?'{{__("accounting::modules.accounting.fromStatment")}}':'{{__("accounting::modules.accounting.toStatment")}}';


    document.querySelector(targetTBody).insertAdjacentHTML('beforeend',' <tr id="'+(type)+'R'+(currentRowsCount+1)+'"><td class="'+(type)+'RIndex"></td><td> <input class="form-control" onkeyup="updateEntry(this)" type="number" step="0.01" name="'+(typeAmounts)+'" value="0" required/> </td><td> '+(tfstatment)+' : <select class="'+(type)+'SelCode form-select" style="width:90%" id="'+(type)+'C1" name="'+(typeCodes)+'" {{__('accounting::modules.accounting.rtl')}} required> <option value="" disabled></option> </select> </td><td> <input type="hidden" name="'+typeDates+'" value="-1" class="payment-date"/> <i class="btn btn-sm btn-danger fa fa-trash" onClick="delRow(this.parentElement.parentElement.id)" aria-hidden="true"></i> </td></tr>');

    initSelectors();
    initDatepickers();
    updateEntriesCounter(type);

}

function initDatepickers()
{
    $( function() {
    $( ".payment-date" ).datepicker({

      showOn: "button",
      dateFormat: 'yy-mm-dd',
      changeMonth: true,
      changeYear: true 
    });

    document.querySelectorAll('.ui-datepicker-trigger').forEach(i=>{
    i.classList.add('btn','btn-sm','btn-warning');
    i.innerHTML='<i class="fa fa-calendar"></i>';
  })

  } );
}



</script>
@endpush
