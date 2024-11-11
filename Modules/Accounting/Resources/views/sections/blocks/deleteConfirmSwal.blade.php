<!-- Swal -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(id)
{
//   Swal.fire({
//   title: '{{__('accounting::modules.accounting.deleteWarningTitle')}}',
//   text: '{{__('accounting::modules.accounting.deleteWarningText')}}',
//   icon: 'warning',
//   showDenyButton: true,
//   confirmButtonText: '{{__('accounting::modules.accounting.yes')}}',
//   denyButtonText: '{{__('accounting::modules.accounting.no')}}',
//             }).then((result) => {
//             if (result.isConfirmed) {
//                 window.location.replace("@yield('destroyRoute','#')/"+id);
//             }else{
//                 return false;
//             }
//         });


//rola
    swal({
  title: '{{__('accounting::modules.accounting.deleteWarningTitle')}}',
  text: '{{__('accounting::modules.accounting.deleteWarningText')}}',
  icon: 'warning',
//   showDenyButton: true,
  showCancelButton: true, //rola  to show the cancel button 

  confirmButtonText: '{{__('accounting::modules.accounting.yes')}}',
  cancelButtonText: '{{__('accounting::modules.accounting.no')}}',
            }).then((result) => {
            if (result.isConfirmed) {
                window.location.replace("@yield('destroyRoute','#')/"+id);
            }else{
                return false;
            }
        });

}
</script>
