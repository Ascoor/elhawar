@extends('layouts.app')
{{$addTopButton=false}}
@include('accounting::sections.pageTitle')
@section('content')
@include('accounting::sections.blocks.messages')
<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-inverse" {{__('accounting::modules.accounting.rtl')}} >
            <div class="panel-heading">{{__('accounting::modules.accounting.dateRange')}}</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    {!! Form::open(['method'=>'POST']) !!}
                    <div class="form-body">
                        <div class="row">
                            <div class="form-group mb-2" {{__('accounting::modules.accounting.rtl')}}>
                                <label for="date"><i class='fa fa-calendar'></i> {{__('accounting::modules.accounting.startDate')}}</label>
                                <input type="text" class="form-control datepicker"   name="startDate" value="{{old('startDate')}}" placeholder="{{__('accounting::modules.accounting.startDate')}}"  required/>
                            </div>
                            <div class="form-group mb-2" {{__('accounting::modules.accounting.rtl')}}>
                                <label for="date"><i class='fa fa-calendar'></i> {{__('accounting::modules.accounting.endDate')}}</label>
                                <input type="text" class="form-control datepicker"  name="endDate" value="{{old('endDate')}}" placeholder="{{__('accounting::modules.accounting.endDate')}}"  required/>
                            </div>    

                            @if(isset($printChkBox) && ($printChkBox))
                            <div class="form-group mb-2" {{__('accounting::modules.accounting.rtl')}}>
                                <label for="print" class='form-check-label'><i class='fa fa-print'></i> {{__('accounting::modules.accounting.print')}}</label>
                                <input class="form-check-input " type="checkbox" id='print' name='print'>
                            </div>    
                            @endisset

                            @yield('extra-inputs')            
                        </div>
                    </div>
                    <div class="form-actions" style=" display: flex;flex-direction: row-reverse;">
                        <button type="submit" id="save-form" class="btn btn-success"> <i class="fa fa-check"></i> @lang('app.submit')</button>
                    </div>
                    <br><br>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>    
<!-- .row -->
@endsection



@section('content')

@include('accounting::sections.blocks.jqueryDP')

