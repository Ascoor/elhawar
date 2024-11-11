@extends('layouts.app')
@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12" style="width: fit-content">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ $pageTitle }}</h4>
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
        <div class="panel panel-inverse">
            <div class="panel-heading">@lang('modules.accountSettings.updateTitle')</div>

            <div class="vtabs customvtab m-t-10">

                @include('accounting::sections.accounting_setting_menu')

        <div class="white-box">

@if(session()->get('success'))
<div class="alert alert-success">
  {{ session()->get('success') }}
</div><br />
@endif

<a class='btn btn-primary mb-3' href='{{route('admin.accounting.codesettings.create',$viewData['type'])}}'><i class="fa fa-plus-circle" aria-hidden="true"></i> {{__('accounting::modules.accounting.add')}}</a>
<br><br>
<div class="table-responsive-lg">
<table class="table table-bordered data-table">
    <thead>
        <tr>
            <th>{{__('accounting::modules.accounting.code')}}</th>
            <th>{{__('accounting::modules.accounting.name')}}</th>
            <th>{{__('accounting::modules.accounting.isMain')}}</th>
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

@endsection

@push('footer-script')
<!-- Data table -->
<script src="{{ asset('plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script>
<!-- Swal -->
{{-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
<!-- others -->
<script type="text/javascript">
 
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.accounting.codesettings.index',$viewData['type']) }}",
        columns: [
            {data: 'code', name: 'code'},
            {data: 'breadcrumb', name: 'breadcrumb'},
            {data: "is_main" , render : function ( data, type, row, meta ) {
                  return type === 'display'  ?
                    data === '1'?'{{__("accounting::modules.accounting.yes")}}': '{{__("accounting::modules.accounting.no")}}' :
                    data;
                }},
            {data: "id" , render : function ( data, type, row, meta ) {
                  return type === 'display'  ?
                    '<a onclick="confirmDelete('+data+')" class="btn btn-danger p-2" ><i class="fa fa-trash" aria-hidden="true"></i></a>' :
                    data;
                }},
                ]
    });
    
    
    function confirmDelete(id)
    {
        // Swal({
        //     title: '{{__('accounting::modules.accounting.deleteWarningTitle')}}',
        //     text: '{{__('accounting::modules.accounting.deleteWarningText')}}',
        //     icon: 'warning',
        //     showDenyButton: true,
        //     confirmButtonText: '{{__('accounting::modules.accounting.yes')}}',
        //     denyButtonText: '{{__('accounting::modules.accounting.no')}}',
        //                 }).then((result) => {
        //                 if (result.isConfirmed) {
        //                     window.location.replace("{{route('admin.accounting.codesettings.destroy',$viewData['type'])}}/"+id);
        //                 }else{
        //                     return false;
        //                 }
        //     })

            swal({
                title: '{{__('accounting::modules.accounting.deleteWarningTitle')}}',
                text: '{{__('accounting::modules.accounting.deleteWarningText')}}',
                icon: 'warning',
                type: "warning",
                //   showDenyButton: true, 
                showCancelButton: true,
                confirmButtonText: '{{__('accounting::modules.accounting.yes')}}',
                //    denyButtonText: '{{__('accounting::modules.accounting.no')}}',
                cancelButtonText: '{{__('accounting::modules.accounting.no')}}',
                //   closeOnConfirm: true,
                //     closeOnCancel: true

                //   
            }, function(isConfirm){
                if (isConfirm) {
                    window.location.replace("{{route('admin.accounting.codesettings.destroy',$viewData['type'])}}/"+id);
        
                }else{
                return false;
            }
            });
            
    
    }
    
    </script>
    

@endpush    
