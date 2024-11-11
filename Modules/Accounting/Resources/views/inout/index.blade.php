@extends('layouts.app')
@section('page-title')
<style>
.bg-title
{
    display: flex;
}
    </style>

    <div class="row bg-title"   {{__('accounting::modules.accounting.rtl')}}>
        <!-- .page title -->
        <div class="ccol-xs-12 bg-title-left"  >
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __($pageTitle) }}
                <span class="text-info b-l p-l-10 m-l-5">{{ $totalEntries }}</span> 
            </h4>

        </div>

        <!-- /.page title -->
        <!-- .breadcrumb -->

                <!-- .breadcrumb -->
                <div class="col-lg-4 col-sm-8 col-md-8 col-xs-12 text-right bg-title-right">
            <a href="{{ route('admin.accounting.inout.create',$type) }}" class="btn btn-outline btn-success btn-sm">@lang('accounting::modules.accounting.add') <i class="fa fa-plus" aria-hidden="true"></i></a>
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}">@lang('app.menu.home')</a></li>
                <li class="active">{{ __($pageTitle) }}</li>
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

@if(session()->get('success'))
<div class="alert alert-success">
  {{ session()->get('success') }}
</div><br />
@endif

@if ($errors->any())
    <div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    </div><br />
@endif



<div class="table-responsive-lg" {{__('accounting::modules.accounting.rtl')}}>
<table class="table table-bordered data-table"  {{__('accounting::modules.accounting.rtl')}}>
    <thead>
        <tr>
            <th style="text-align: center">{{__('accounting::modules.accounting.title')}}</th>
            <th style="text-align: center">{{__('accounting::modules.accounting.excerpt')}}</th>
            <th style="text-align: center">{{__('accounting::modules.accounting.filesCount')}}</th>
            <th style="text-align: center">{{__('accounting::modules.accounting.date')}}</th>
            <th class='p-2' style="text-align: center"><i class="fa fa-cogs" aria-hidden="true"></i></th>
        </tr>
    </thead>
    <tbody style="text-align: center">
    </tbody>
</table>
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
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- others -->
<script type="text/javascript">
 
 $(function () {

var table = $('.data-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('admin.accounting.inout.index',$type) }}",
    columns: [
        {data: 'title', name: 'title'},
        {data: 'excerpt', name: 'excerpt'},
        {data: 'filesCount', name: 'filesCount'},
        {data: 'date', name: 'date'},

        {data: "id" , render : function ( data, type, row, meta ) {
                  return type === 'display'  ?
                  '<div class="dropdown"> <button class="btn btn-secondary dropdown-togglebtn btn-default dropdown-toggle waves-effect waves-light" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-gears "></i> </button> <ul role="menu" class="dropdown-menu" aria-labelledby="dropdownMenuButton"> <li><a class="dropdown-item" href="{{route("admin.accounting.inout.list",$type)}}/'+data+'" target="_blank"><i class="fa fa-list"></i> {{__("accounting::modules.accounting.preview")}}</a></li><li><a class="dropdown-item " href="#" onclick="confirmDelete('+data+')"><i class="fa fa-trash"></i> {{__("accounting::modules.accounting.delete")}}</a></li></ul></div>':'';
                 }},

            ]
});

});
   

function confirmDelete(id)
    {
    //     Swal.fire({
    //   title: '{{__('accounting::modules.accounting.deleteWarningTitle')}}',
    //   text: '{{__('accounting::modules.accounting.deleteWarningText')}}',
    //   icon: 'warning',
    //   showDenyButton: true,
    //   confirmButtonText: '{{__('accounting::modules.accounting.yes')}}',
    //   denyButtonText: '{{__('accounting::modules.accounting.no')}}',
    //             }).then((result) => {
    //             if (result.isConfirmed) {
    //                 window.location.replace("{{route('admin.accounting.inout.destroy',$type)}}/"+id);
    //             }else{
    //                 return false;
    //             }
   /// })
    
   //rola
    swal({
    title: '{{__('accounting::modules.accounting.deleteWarningTitle')}}',
  text: '{{__('accounting::modules.accounting.deleteWarningText')}}',
  icon: 'warning',
  showCancelButton: true,
  confirmButtonText: '{{__('accounting::modules.accounting.yes')}}',
  cancelButtonText: '{{__('accounting::modules.accounting.no')}}',
            }, function(isConfirm){
                if (isConfirm) {
                    window.location.replace("{{route('admin.accounting.inout.destroy',$type)}}/"+id);
                }else{
                return false;
            }
            });

    
    
    }

    
</script>
    

@endpush    
