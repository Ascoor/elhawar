@extends('layouts.app')
@section('page-title')
    <div class="row bg-title" >
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12" style="width: fit-content">
            <h4 class="page-title" {{__('accounting::modules.accounting.rtl')}} ><i class="{{ $pageIcon }}"></i> {{ $pageTitle }}</h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12" >
            <ol class="breadcrumb" {{__('accounting::modules.accounting.rtl')}}>
                <li><a href="{{ route('admin.dashboard') }}" {{__('accounting::modules.accounting.rtl')}}>@lang('app.menu.home')</a></li>
                <li class="active" {{__('accounting::modules.accounting.rtl')}}>{{ $pageTitle }}</li>
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
            <th style="text-align: center">{{__('accounting::modules.accounting.code')}}</th>
            <th style="text-align: center">{{__('accounting::modules.accounting.name')}}</th>
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
    ajax: "{{ route('admin.accounting.credibtors.index') }}",
    columns: [
        {data: 'code', name: 'code'},
        {data: 'breadcrumb', name: 'breadcrumb', sortable:false, searchable:false},
        {data: "id" , render : function ( data, type, row, meta ) {
                  return type === 'display'  ?
                  '<div class="dropdown"> <button class="btn btn-secondary dropdown-togglebtn btn-default dropdown-toggle waves-effect waves-light" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-gears "></i> </button> <ul role="menu" class="dropdown-menu" aria-labelledby="dropdownMenuButton"> <li><a class="dropdown-item" href="{{route("admin.accounting.credibtors.credibtorsheet")}}/'+data+'">{{__("accounting::modules.accounting.credebtorsheet")}}</a></li><li><a class="dropdown-item" href="{{route("admin.accounting.credibtors.generaledgersheet")}}/'+data+'">{{__("accounting::modules.accounting.generaledgersheet")}}</a></li></ul></div>':'';
                 }, sortable:false, searchable:false},

            ]
});

});
   
    
</script>
    

@endpush    
