@extends('layouts.app')
@section('page-title')
<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12" style="width: fit-content">
        <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{$pageTitle}}</h4>
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
@extends('layouts.app')



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

                    <form method="post" action="{{ route('admin.accounting.budgetterms.store',$viewData['type']) }}">
                        @csrf
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="name">
                                        {{__('accounting::modules.accounting.name')}}
                                    </label>
                                    <input type="text" class="form-control" name="name" maxlength="120"
                                        placeholder="{{__('accounting::modules.accounting.enterName')}}" required />
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="row">
                                    <label for="codeSearch">
                                        {{__('accounting::modules.accounting.codes')}}
                                    </label>
                                </div>
                                <div class='row'>
                                    <div class="form-group col-lg-6">
                                        <input class="form-control" id="codeSearch" onkeyup="searchCodes(this.value);"
                                            name='CodeSearch'
                                            placeholder="{{__('accounting::modules.accounting.typeToSearch')}}">

                                    </div>

                                    <div class="form-group col-lg-6">
                                        <select class="form-control" id="codes" name='codes[]' multiple required>
                                            <option value="{{ $record}}" disabled>
                                                {{__('accounting::modules.accounting.searchAndSelect')}}</option>
                                            <option value="{{ $type}}" disabled>
                                                {{__('accounting::modules.accounting.searchAndSelect')}}</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus-circle"
                                aria-hidden="true"></i> {{__('accounting::modules.accounting.submit')}}</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@endsection

@push('footer-script')

<!-- Swal -->
{{-- rola removed swal.fire cdn --}}
{{-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
<!-- others -->

<script>
    var exclusions=[[],[]];
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
                 //   type: "warning",
                 showCancelButton: true,
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