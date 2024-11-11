@extends('layouts.app')
@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12" style="width: fit-content">
            <h4 class="page-title" ><i class="{{ $pageIcon }}"></i> {{ $pageTitle }}</h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}">@lang('app.menu.home')</a></li>
                <li class="active">{{ $pageTitle }}</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection



@push('head-script')
<!-- Data table -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
@endpush


@section('content')
<div class="row">

    <div class="col-md-12">
        <div class="white-box">
            <div class="panel panel-inverse">
                <div class="panel-heading">@lang('modules.accountSettings.updateTitle')</div>

                <div class="vtabs customvtab m-t-10">

                    @include('accounting::sections.accounting_setting_menu')
@if(session()->get('success'))
<div class="alert alert-success">
  {{ session()->get('success') }}
</div><br />
@endif

<a class='btn btn-primary mb-3' href='{{route('admin.accounting.budgetterms.create',$viewData['type'])}}'><i class="fa fa-plus-circle" aria-hidden="true"></i> {{__('accounting::modules.accounting.add')}}</a>

<div class="table-responsive-lg">
<table class="table table-bordered data-table">
    <thead>
        <tr>
            <th>{{__('accounting::modules.accounting.name')}}</th>
            <th>{{__('accounting::modules.accounting.itemsCount')}}</th>
            <th class='p-2'><i class="fa fa-cogs" aria-hidden="true"></i></th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
</div>


                </div>
            </div>
        </div>

</div>
</div>
</div>


@endsection



@push('footer-script')
<!-- Data table -->
<script src="{{ asset('plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script>

<!-- Swal -->
{{-- rola removed it for swal.fire --}}
{{-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}


<!-- others -->

<script type="text/javascript">
    $(function () {
    
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.accounting.budgetterms.index',$viewData['type']) }}",
        columns: [
            {data: 'name', name: 'name'},
            {data: 'items_count', name: 'items_count' , searchable: false, sortable: false},
            {data: "id" , render : function ( data, type, row, meta ) {
                  return type === 'display'  ?
                    '<a href="{{ route("admin.accounting.budgetterms.edit",$viewData["type"])}}/'+data+'" class="btn btn-primary p-2 m-2" ><i class="far fa-edit" aria-hidden="true"></i></a><a onclick="confirmDelete('+data+')" class="btn btn-danger p-2 m-2" ><i class="fa fa-trash" aria-hidden="true"></i></a>' :
                    data;
                }, searchable: false, sortable: false},
                ]
    });
    
    });
    
    function confirmDelete(id)
    {
    //     Swal.fire({
    //   title: '{{__('accounting::modules.deleteWarningTitle')}}',
    //   text: '{{__('accounting::modules.deleteWarningText')}}',
    //   icon: 'warning',
    //   showDenyButton: true,
    //   confirmButtonText: '{{__('accounting::modules.accounting.yes')}}',
    //   denyButtonText: '{{__('accounting::modules.accounting.no')}}',
    //             }).then((result) => {
    //             if (result.isConfirmed) {
    //                 window.location.replace("{{route('admin.accounting.budgetterms.destroy',$viewData['type'])}}/"+id);
    //             }else{
    //                 return false;
    //             }
    // })
    

//rola
    swal({
    title: '{{__('accounting::modules.deleteWarningTitle')}}',
  text: '{{__('accounting::modules.deleteWarningText')}}',
  icon: 'warning',
  showCancelButton: true,
  confirmButtonText: '{{__('accounting::modules.accounting.yes')}}',
  cancelButtonText: '{{__('accounting::modules.accounting.no')}}',
        }, function(isConfirm){
                if (isConfirm) {
                    window.location.replace("{{route('admin.accounting.budgetterms.destroy',$viewData['type'])}}/"+id);
                }else{
                return false;
            }
            });
    
    }
</script>    
@endpush
