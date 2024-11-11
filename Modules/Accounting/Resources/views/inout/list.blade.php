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
    ajax: "{{ route('admin.accounting.inout.list',$type) }}"+"/"+{{$id}},
    columns: [
        {data: 'original_name', name: 'original_name'},

        {data: "id" , render : function ( data, type, row, meta ) {
                  return type === 'display'  ?
                  '<a class="btn btn-success" target="_blank" href="{{ route("admin.accounting.inout.download")}}/'+data+'"><i class="fa fa-download"></i></div> ':'';
                 }},

            ]
});

});
   


    
</script>
    

@endpush    
