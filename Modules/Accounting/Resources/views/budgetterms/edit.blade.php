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

                    <form method="post"
                        action="{{ route('admin.accounting.budgetterms.update',[$viewData['type'],$viewData['term']['id']]) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-2">
                            <label for="name">{{__('accounting::modules.accounting.name')}}</label>
                            <input type="text" class="form-control" name="name" maxlength="120"
                                placeholder="{{__('accounting::modules.accounting.enterName')}}"
                                value="{{$viewData['term']['name']}}" required />
                        </div>



                        <label for="codeSearch">{{__('accounting::modules.accounting.codes')}}</label>


                        <div class='row'>
                            <div class="form-group col-6 mb-2">
                                <input class="form-control" id="codeSearch" onkeyup="searchCodes(this.value);"
                                    name='CodeSearch'
                                    placeholder="{{__('accounting::modules.accounting.typeToSearch')}}">

                            </div>

                            <div class="form-group col-6 mb-2">
                                <select class="form-control" id="codes" name='codes[]'
                                    onchange="searchCodes(document.querySelector('#codeSearch').value)" multiple>
                                    <option value="" disabled>{{__('accounting::modules.accounting.searchAndSelect')}}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary"><i class="fa fa-edit" aria-hidden="true"></i>
                            {{__('accounting::modules.accounting.submit')}}</button>
                        <br><br><br>
                    </form>

                    <div class="table-responsive">

                        <table id='datatable' class='table text-light text-center bg-dark rounded'>
                            <thead class="text-center">
                                <tr class="text-center">
                                    <th>{{__('accounting::modules.accounting.code')}}</th>
                                    <th>{{__('accounting::modules.accounting.name')}}</th>
                                    <th><i class="fa fa-cogs" aria-hidden="true"></i></th>

                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach ($viewData['items'] as $item)
                                <tr>
                                    <td>{{$item->code['code']}}</td>
                                    <td>{{$item->code['breadcrumb']}}</td>
                                    <td><a href="{{route('admin.accounting.budgetterms.destroyItem',[$viewData['type'],$viewData['term']['id'],$item['id']])}}"
                                            onclick="confirm('{{__('accounting::modules.accounting.confirmDelete')}}')"
                                            class='btn btn-danger p-2'><i class="fa fa-trash"
                                                aria-hidden="true"></i></a></td>
                                </tr>
                                @endforeach
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
<!-- others -->

<script>
    var exclusions=[[],[]];
</script>

<script>
    $('#datatable').DataTable(
                          {
                            "columnDefs": [
                                { "orderable": false, "targets": 2 }
                            ],
                            "order": [[ 0, "asc" ]]
                          }
                      );

</script>


<script>
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


</script>
@endpush