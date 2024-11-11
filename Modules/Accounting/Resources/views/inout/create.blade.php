@extends('layouts.app')
@section('page-title')

    <div class="row bg-title" style="display: flex">
        <!-- .page title -->
        <div class="col-xs-12 bg-title-left" {{__('accounting::modules.accounting.rtl')}}>
            <h4 class="page-title" ><i class="{{ $pageIcon }}"></i> {{ __($pageTitle) }}</h4>

        </div>

    </div>

@endsection

@push('head-script')
<style>
    .dashed-border
    {
        border: 1px dashed gray;
        padding: 2%;
        border-radius: 10px;
    }
</style>
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




    <form method="post"   class="dashed-border" enctype="multipart/form-data" {{__('accounting::modules.accounting.rtl')}}>
        @csrf
    
        <div class="form-group mb-2" {{__('accounting::modules.accounting.rtl')}}>
            <label for="title"><i class='fa fa-edit'></i> {{__('accounting::modules.accounting.title')}}</label>
            <input type="text" class="form-control"   name="title" value="{{old('title')}}" placeholder="{{__('accounting::modules.accounting.title')}}"  required/>
        </div>

        <div class="form-group mb-2" {{__('accounting::modules.accounting.rtl')}}>
            <label for="description"><i class='fa fa-info-circle'></i> {{__('accounting::modules.accounting.briefDescription')}}</label>
            <textarea type="description" class="form-control" name="description" resizable="none" placeholder="{{__('accounting::modules.accounting.briefDescription')}}" >{{old('description')}} </textarea>
        </div>

        <div class="form-group mb-2" {{__('accounting::modules.accounting.rtl')}}>
            <label for="files"><i class='fa fa-file'></i> {{__('accounting::modules.accounting.files')}}</label>
            <div class="row" {{__('accounting::modules.accounting.rtl')}}>
                <div id="addMoreBox1" class="clearfix" style="display: flex">
                    <div class="col-md-10" style="margin-left: 5px;">
                        <div class="form-group" id="occasionBox">
                            <input class="form-control" type="file" name="files[]"  required>
                        </div>
                    </div>
                    <div class="col-md-1">
                        
                    </div>
                </div>
                <div id="insertBefore"></div>
                <div class="clearfix">

                </div>
                <button type="button" id="plusButton" class="btn btn-sm btn-info" style="margin-bottom: 20px">
                    {{__('accounting::modules.accounting.addMore')}} <i class="fa fa-plus"></i>
                </button>
                <div class="alert alert-info" {{__('accounting::modules.accounting.rtl')}} ><i class="fa fa-info-circle"></i> {{__('accounting::modules.accounting.allowedExtensions')}} : {{$mimes}} /  {{__('accounting::modules.accounting.maxSizeAllowed')}} : {{$maxSize}} {{__('accounting::modules.accounting.megaBytes')}} </div>
            </div>
        </div>



        <button type="submit" class="btn btn-primary mb-5"> {{__('accounting::modules.accounting.submit')}}</button>

    </form>
    
    

</div>
</div>
</div>
    </div>
    </div>

@endsection

@push('footer-script')
<script>
  
var $insertBefore = $('#insertBefore');
var $i = 0;

// Add More Inputs
$('#plusButton').click(function(){
    $i = $i+1;
    var indexs = $i+1;
    $(' <div id="addMoreBox'+indexs+'" class="clearfix" style="display:flex"> ' +
        '<div class="col-md-10 "style="margin-left:5px;"><div class="form-group"><input class="form-control " name="files[]" type="file" required/></div></div>' +
        '<div class="col-md-1"><button type="button" onclick="removeBox('+indexs+')" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button></div>' +
        '</div>').insertBefore($insertBefore);
});
// Remove fields
function removeBox(index){
    $('#addMoreBox'+index).remove();
}

</script>


@endpush    
