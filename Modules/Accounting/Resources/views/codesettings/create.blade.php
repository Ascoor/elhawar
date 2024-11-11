@extends('layouts.app')
@section('page-title')


    <div class="row bg-title">
        <!-- .page title -->
        {{-- <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12" style="width: fit-content">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> Accounting Settings: Code Settings / Revenue Codes / Add Code</h4>
        </div> --}}

        {{-- rolaaaa --}}
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12" style="width: fit-content">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ $pageTitle }}</h4>
        </div>
        <!-- /.page title -->
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
<!-- Select 2-->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />

<style>
.list-group,.list-group-item
{
    border:none!important;
}

</style>
@endpush

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-inverse">
            <div class="panel-heading">@lang('modules.accountSettings.updateTitle')</div>

            <div class="vtabs customvtab m-t-10">

                @include('accounting::sections.accounting_setting_menu')
        <div class="white-box">

@if ($errors->any())
    <div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    </div><br />
@endif


<form method="post"  action="{{ route('admin.accounting.codesettings.store',$viewData['type']) }}" {{__('accounting::modules.accounting.rtl')}}>
    @csrf

    <label for="code">{{__('accounting::modules.accounting.searchOrCreate')}}</label>

    <ul class='list-group'>
        <li class='list-group-item' >
            <div class='row'>
            <p class="levelTitle">{{__('accounting::modules.accounting.levels.l1')}}</p>
                <div class='col-lg-2'>
                    <button
                            type='button'
                            class='btn btn-primary m-1 '
                            id='addChild' onclick='addChildCode()'>
                            <i class="fa fa-plus-square" aria-hidden="true"></i>
                    </button>
                </div>

                <div class='col-lg-5'>
                    <select class="form-control"
                            id="parentCode"
                            onchange="updateMainParent();"
                            name='parentCode'>
                        <option selected value>
                            {{__("accounting::modules.accounting.createNew")}}
                        </option>
                    </select>
                </div>

                <div class='col-lg-5'>
                    <input class="form-control"
                        maxlength="45" id="parentCodeSearch"
                        onkeyup="searchCodes(this.value);"
                        onchange="searchCodes(this.value);"
                        name='parentCodeSearch'
                        placeholder="{{__('accounting::modules.accounting.typeToSearchParentCodes')}}" />
                </div>


            </div>

            <ul id='children' class='list-group'  {{__('accounting::modules.accounting.rtl')}}>
            </ul>
        </li>
    </ul>


    <button type="submit" class="btn btn-primary mb-2" style="direction: ltr!important;" id='formSubmit' disabled><i class="fa fa-plus-circle" aria-hidden="true"></i> {{__('accounting::modules.accounting.submit')}}</button>

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
{{-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
<!-- others -->
<script>
    var rootLevel=0;
    var levels=4;
    const levelNames=['{{__("accounting::modules.accounting.levels.l1")}}','{{__("accounting::modules.accounting.levels.l2")}}','{{__("accounting::modules.accounting.levels.l3")}}','{{__("accounting::modules.accounting.levels.l4")}}','{{__("accounting::modules.accounting.levels.l5")}}'];
</script>

<script>
    function searchCodes(key)
    {
        var formSubmit=document.querySelector('#formSubmit');
    
        $.ajax({
        type: "POST",
        dataType: 'json',
        url: "{{route('admin.accounting.codesettings.search',$viewData['type'])}}",
        data:"_token={{csrf_token()}}&key="+key,
        success: function(response){
            var codeSelector=document.querySelector('#parentCode');
            var codesResultsNumber = 0;
            if(response['data'] != null){
                codesResultsNumber = response['data'].length;
                }
            if(codesResultsNumber>0)
            {
                formSubmit.disabled=false;
                var codes=response.data;
                codeSelector.innerHTML='<option selected value> {{__("accounting::modules.accounting.createNew")}}</option>';
                codes.forEach(element => codeSelector.innerHTML+="<option value='"+element.id+"'>"+element.code +" - "+element.breadcrumb+"</option>");
                formSubmit.disabled=false;
    
            }
            else
            {
                if(key!='')
                {
                    formSubmit.disabled=false;
                    codeSelector.innerHTML='<option selected value> {{__("accounting::modules.accounting.createNew")}}</option> <option value="" disabled>{{__("accounting::modules.accounting.noSearhResult")}}</option>';
                }
                else
                {
                    formSubmit.disabled=true;
                    codeSelector.innerHTML='<option selected value> {{__("accounting::modules.accounting.createNew")}}</option> ';
                }
    
            }
        },
        error: function()
        {
                swal({
                icon: 'error',
                title: '{{__("accounting::modules.accounting.error")}}',
                text: '{{__("accounting::modules.accounting.errorHasOccured")}}',
                showCancelButton: true,
                confirmButtonText: '{{__("ok")}}',
                })
        }
        });
    
    
    }
    
    function updatelevels()
    {
    
        var childrenContainer=document.querySelector('#children');
        var mainCodeSelector=document.querySelector('#parentCode');
        var mainCodeInput=document.querySelector('#parentCodeSearch');
        var addChildBtn=document.querySelector('#addChild');
        var currentChildren=document.querySelectorAll('.childCode');
        var maxChildren=4;
            rootLevel=0;
        if(mainCodeSelector.value != '')
        {
                $.ajax({
                type: "POST",
                dataType: 'json',
                url: "{{route('admin.accounting.codesettings.getCodeLevel')}}",
                data:"_token={{csrf_token()}}&selection="+mainCodeSelector.value,
                async : false,
                success: function(response){
                    maxChildren=5-parseInt(response.level)
                    rootLevel=parseInt(response.level)-1;
                },
                error: function()
                {
                        currentChildren.forEach(i=>i.remove());
                        mainCodeSelector.value='';
                        mainCodeSelector.selectedIndex=1;
                        mainCodeInput.disabled=false;
                        mainCodeInput.value='';
    
                        swal({
                        icon: 'error',
                        title: '{{__("accounting::modules.accounting.error")}}',
                        text: '{{__("accounting::modules.accounting.errorHasOccured")}}',
                        confirmButtonText: '{{__("ok")}}',
                        })
    
                }
                });
        }
    
    
            levels=(maxChildren- currentChildren.length);
            if(levels <=0)
            {
                if(currentChildren.length>maxChildren)
                {
                    for(i=maxChildren;i<currentChildren.length;i++)
                    {
                        currentChildren[i].remove();
                    }
                }
                levels=0;
                addChildBtn.disabled=true;
            }
            else
            {
                addChildBtn.disabled=false;
            }
    
            refreshLevelsTitles();
            handleAddBtn();
    }
    
    function refreshLevelsTitles()
    {
        var titles=document.querySelectorAll(".levelTitle");

        for(i=0,j=rootLevel;i<titles.length;i++,j++)
        {
            titles[i].innerText=levelNames[j];
        }
    }

    function updateMainParent()
    {
    
        var mainCodeInput=document.querySelector('#parentCodeSearch');
        var mainCodeSelector=document.querySelector('#parentCode');
        var formSubmit=document.querySelector('#formSubmit');
    
        updatelevels();
    
        if(mainCodeInput.value != '' || mainCodeSelector.value != '')
        {
            formSubmit.disabled=false;
    
            if(mainCodeSelector.value != '')
            {
                mainCodeInput.value=mainCodeSelector.selectedOptions[0].innerText;
                mainCodeInput.disabled=true;
            }
            else
            {
                mainCodeInput.value='';
                mainCodeInput.disabled=false;
            }
        }
        else
        {
            formSubmit.disabled=true;
        }
    }
    
    function addChildCode()
    {
        updatelevels();
    
        if(levels!=0)
        {
            var divID=revisedRandId();
            var childrenContainer=document.querySelector('#children');
            childrenContainer.insertAdjacentHTML('beforeend',
                '<li class="list-group-item"><div class="childCode input-group " id="'+divID+'"> <div class="row "> <p class="levelTitle"></p><div class="col-lg-2"><div class="btn btn-danger " onclick="deleteChildCode(\''+divID+'\')"><i class="fa fa-trash " aria-hidden="true"></i></div></div> <div class="col-lg-2"><button type="button" class="btn btn-primary" id="addChild" onclick="addChildCode()"><i class="fa fa-plus-square" aria-hidden="true"></i></button></div>  <div class="col-lg-8"><input class="form-control" type="text" name="childrenCodes[]" placeholder="{{__('accounting::modules.accounting.name')}}" required/></div> </div></div> <ul class="list-group" id="children" {{__('accounting::modules.accounting.rtl')}}></ul></li>');
                childrenContainer.removeAttribute('id');  
        }
        else
        {
            swal({
                        icon: 'error',
                        title: '{{__("accounting::modules.accounting.error")}}',
                        text: '{{__("accounting::modules.accounting.cannotAddNoMore")}}',
                        confirmButtonText: '{{__("ok")}}',
                        })
        }
    
        updatelevels();
        handleAddBtn();
    
    
    }
    
    function handleAddBtn()
    {
        btns=document.querySelectorAll('#addChild');

        btns.forEach(i=>i.style.visibility='hidden');
    
        btns[btns.length-1].style.visibility='visible';
    
        if(levels==0)
        {
            btns[btns.length-1].disabled=true;
        }
        else
        {
            btns[btns.length-1].disabled=false;
    
        }
    }
    
    function deleteChildCode(childID)
    {
    
        var child= document.querySelector('#'+childID);
        child.parentElement.parentElement.setAttribute('id', 'children');

        child.parentElement.remove();
        updatelevels();
        handleAddBtn();
    }
    
    function revisedRandId() {
         return Math.random().toString(36).replace(/[^a-z]+/g, '').substr(2, 10);
    }
    
        </script>
    @endpush
