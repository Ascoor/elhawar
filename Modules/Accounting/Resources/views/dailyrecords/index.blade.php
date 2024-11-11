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
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
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


            <div class='text-center h-3'><i class="fa fa-print" aria-hidden="true"></i>
                {{__('accounting::modules.accounting.generateperiodicreport')}}</div>

            <form action="{{route('admin.accounting.dailyrecords.periodicreport',$viewData['type'])}}" method="post">
                @csrf
                <div class="row">

                    <div class="form-group col-sm-6">
                        <label for="startDate">{{__('accounting::modules.accounting.startDate')}}</label>
                        <input type="date" class='form-control' name='startDate' required>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="endDate">{{__('accounting::modules.accounting.endDate')}}</label>
                        <input type="date" class='form-control' name='endDate' required>
                    </div>
                    <button type="submit" style="margin-bottom: 10px" class="btn btn-primary"><i class="fa fa-print"
                            aria-hidden="true"></i> {{__('accounting::modules.accounting.generate')}}</button>
                </div>
            </form>

            <a class='btn btn-primary ' style="margin-bottom: 10px;" href='{{route('
                admin.accounting.dailyrecords.create',$viewData['type'])}}'><i class="fa fa-plus-circle"
                    aria-hidden="true"></i> {{__('accounting::modules.accounting.add')}}</a>
            <div class="table-responsive-lg">
                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>{{__('accounting::modules.accounting.date')}}</th>
                            <th>{{__('accounting::modules.accounting.journalEntryNo')}}</th>
                            <th>{{__('accounting::modules.accounting.description')}}</th>
                            <th>@if ($viewData['type'] =='revenue') {{__('accounting::modules.accounting.totalDebit')}}
                                @else {{__('accounting::modules.accounting.totalCreditor')}} @endIF</th>
                            <th>@if ($viewData['type'] =='revenue')
                                {{__('accounting::modules.accounting.totalCreditor')}} @else
                                {{__('accounting::modules.accounting.totalDebit')}} @endIF</th>
                            <th>{{__('accounting::modules.accounting.total')}}</th>
                            <th>{{ __('accounting::modules.accounting.Created_record_by_employee') }}</th> 
                            {{-- //rola --}}
                            <th class='p-2'><i class="fa fa-cogs" aria-hidden="true"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="row">

                <div class="col-md-12">
                    <div class="white-box">


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
            {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
            {{--
            <link href="{{ asset('plugins/bower_components/sweetalert/sweetalert.css') }}" rel="stylesheet">

            <link rel="stylesheet"
                href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
            <link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
            <link rel="stylesheet" href="{{ asset('plugins/bower_components/multiselect/css/multi-select.css') }}"> --}}

            <!-- others -->



            <script type="text/javascript">
                $(function () {

var table = $('.data-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('admin.accounting.dailyrecords.index',$viewData['type']) }}",
    columns: [
        {data: 'date', name: 'date'},
        {data: 'journalEntryNo', name: 'journalEntryNo',sortable:false,searchable:false},
        {data: 'excerpt', name: 'excerpt',sortable:false,searchable:false},
        {data: 'dept', name: 'dept',sortable:false,searchable:false},
        {data: 'credit', name: 'credit',sortable:false,searchable:false},
        {data: 'total', name: 'total',sortable:false,searchable:false},
        {data: 'recordCreatedBy',name:'recordCreatedBy' }, //rola
        {data: "id" , render : function ( data, type, row, meta ) {
              return type === 'display'  ?
              '<a href="{{route('admin.accounting.dailyrecords.print')}}/'+data+'" class="btn btn-primary p-2 m-1" ><i class="fa fa-print" aria-hidden="true"></i></a><a href="{{route('admin.accounting.dailyrecords.preview')}}/'+data+'" class="btn btn-primary p-2 m-1"  target="_blank"><i class="fa fa-eye " aria-hidden="true"></i></a><a href="{{route('admin.accounting.dailyrecords.edit',$viewData["type"])}}/'+data+'" class="btn btn-primary p-2 m-1" ><i class="fa fa-edit" aria-hidden="true"></i></a><a onclick="confirmDelete('+data+')" class=" btn btn-danger p-2 m-1" ><i class="fa fa-trash" aria-hidden="true"></i></a>' :
                data;
            },sortable:false,searchable:false},
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
//                 window.location.replace("{{route('admin.accounting.dailyrecords.destroy',$viewData['type'])}}/"+id);
//             }else{
//                 return false;
//             }
// })

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
                    window.location.replace("{{route('admin.accounting.dailyrecords.destroy',$viewData['type'])}}/"+id);
        
                }else{
                return false;
            }
            });

            


}

            </script>




            @endpush