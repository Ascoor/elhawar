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
        <div class="white-box">
            <div class="panel panel-inverse">
                <div class="panel-heading">@lang('modules.accountSettings.updateTitle')</div>

                <div class="vtabs customvtab m-t-10">

                    @include('accounting::sections.accounting_setting_menu')

@if ($errors->any())
    <div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    </div><br />
@endif

@if(session()->get('success'))
<div class="alert alert-success">
  {{ session()->get('success') }}
</div><br />
@endif

<form method="post" action="{{ route('admin.accounting.budgetterms.miscStore',$viewData['type']) }}">

    @csrf


<label for="budgetTerm">{{__('accounting::modules.accounting.term')}}</label>

<div class='row'>

    <div class="form-group col-6 mb-2">
        <input class="form-control"  id="termSearch" onkeyup="searchTerms(this.value);"  name='name' maxlength="120" placeholder="{{__('accounting::modules.accounting.typeTermName')}}" required>
    </div>

    <div class="form-group col-6 mb-2">
        <select class="form-control"  id="terms" onchange='termBinding(this,document.querySelector("#termSearch"))' name='term'>
            <option value="" selected> {{__("accounting::modules.accounting.donotChooseTerm")}}</option>
        </select>
    </div>

</div>



<label for="codeSearch">{{__('accounting::modules.accounting.codes')}}</label>


<div class='row'>
    <div class="form-group col-6 mb-2">

        <input class="form-control"  id="codeSearch"  onkeyup="searchCodes(this.value);"  name='CodeSearch' placeholder="{{__('accounting::modules.accounting.typeToSearch')}}" >

    </div>

    <div class="form-group col-6 mb-2">
        <select class="form-control"  id="codes" name='codes[]'  onchange="searchCodes(document.querySelector('#codeSearch').value)" multiple required>
            <option value=""  disabled>{{__('accounting::modules.accounting.searchAndSelect')}}</option>
        </select>
    </div>
</div>
    <input type='number' value='0' name='add_to_existing' id='add_to_existing' hidden required/>
    <button type="submit" class="btn btn-primary"><i class="fa fa-edit" aria-hidden="true"></i> {{__('accounting::modules.accounting.submit')}}</button>

</form>

<div class="table-responsive">

<table id='datatable' class='table text-light text-center bg-dark rounded'>
                    <thead>
                        <tr>
                            <th>{{__('accounting::modules.accounting.code')}}</th>
                            <th>{{__('accounting::modules.accounting.name')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
</div>





</div>
</div>
</div></div></div>
</div>
@endsection

@push('footer-script')
<!-- Data table -->
<script src="{{ asset('plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script>

{{-- rola removed swal.fire cdn --}}
<!-- Swal -->
{{-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
<!-- others -->

<script>
    var exclusions=[[],[]];
</script>

<script>




$(function () {

var table = $('#datatable').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('admin.accounting.budgetterms.misc',$viewData['type']) }}",
    columns: [
        {data: 'code', name: 'code'},
        {data: 'breadcrumb', name: 'breadcrumb'},
            ]
});

});


function searchCodes(key)
{
    makeExclusions();

    if(key=='')
    {
        key='0000000000';
    }

    $.ajax({
	type: "POST",
    dataType: 'json',
	url: "{{route('admin.accounting.budgetterms.ajax',[$viewData['type'],'codeSearch'])}}",
	data:"_token={{csrf_token()}}&key="+key+"&exclude="+JSON.stringify(exclusions[1]),
	success: function(response){

        var codeSelector=document.querySelector('#codes');
        codeSelector.innerHTML='';
        exclusions[0].forEach(
            i=>codeSelector.innerHTML+='<option value="'+i[0]+'" selected>'+i[1]+'</option>'
        )
        if(response.length>0)
        {
              response.forEach(element => codeSelector.innerHTML+="<option value='"+element.id+"'>"+element.code +" - "+element.breadcrumb+"</option>");
        }
        else
        {
            codeSelector.innerHTML+='<option value="" disabled> {{__("accounting::modules.accounting.noResults")}}</option>';
        }
	},
    error: function()
    {
    
            // Swal.fire({
            // icon: 'error',
            // title: '{{__("accounting::modules.accounting.error")}}',
            // text: '{{__("accounting::modules.accounting.errorHasOccured")}}',
            // confirmButtonText: '{{__("ok")}}',
            // })
    //rola

            swal({
                title: '{{__("accounting::modules.accounting.error")}}',
            text: '{{__("accounting::modules.accounting.errorHasOccured")}}',
  icon: 'error',
  confirmButtonText: '{{__("ok")}}',

            });


            
    }
	});


}

function makeExclusions()
{
    var codesSelector=document.querySelector('#codes');

    exclusions=[[],[]];

    Array.from(codesSelector.selectedOptions).forEach(
        function(option)
        {
            exclusions[0].push([option.value,option.innerHTML]);
            exclusions[1].push(option.value);
        }
        );
}

function searchTerms(key)
{
	if (key=='')
	{
		key='NaN';
	}

    $.ajax({
    type: "POST",
    dataType: 'json',
	url: "{{route('admin.accounting.budgetterms.ajax',[$viewData['type'],'searchTerm'])}}",
	data:"_token={{csrf_token()}}&key="+key,
	success: function(response){
        var termSelector=document.querySelector('#terms');
        if(response.length>0)
        {
            var terms=response;
            termSelector.innerHTML='<option value=""  selected> {{__("accounting::modules.accounting.donotChooseTerm")}}</option>';

            terms.forEach(element => termSelector.innerHTML+="<option value='"+element.id+"'>"+element.name+"</option>");
        }
        else
        {
            if(key!='NaN')
            {
                termSelector.innerHTML='<option value="" selected> {{__("accounting::modules.accounting.donotChooseTerm")}}</option> <option value="" disabled>{{__("accounting::modules.accounting.noSearhResult")}}</option>';
            }
            else
            {
                termSelector.innerHTML='<option value="" selected> {{__("accounting::modules.accounting.donotChooseTerm")}}</option> ';
            }

        }
	},
    error: function()
    {
            // Swal.fire({
            // icon: 'error',
            // title: '{{__("accounting::modules.accounting.error")}}',
            // text: '{{__("accounting::modules.accounting.errorHasOccured")}}',
            // confirmButtonText: '{{__("ok")}}',
            // })

            // rola
            swal({
                title: '{{__("accounting::modules.accounting.error")}}',
            text: '{{__("accounting::modules.accounting.errorHasOccured")}}',
  icon: 'error',
  confirmButtonText: '{{__("ok")}}',

            });
            
    }
	});
}

function termBinding(selection,input)
{
    if(selection.value != '')
    {
        input.value=selection.selectedOptions[0].innerHTML;
        input.hidden=true;
        selection.parentElement.classList.remove('col-6');
        document.querySelector('#add_to_existing').value=1;

    }
    else
    {
        input.value='';
        input.hidden=false;
        selection.parentElement.classList.add('col-6');
        document.querySelector('#add_to_existing').value=0;
    }
}

    </script>
@endpush

