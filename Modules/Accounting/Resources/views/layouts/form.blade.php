@extends('layouts.app')
{{$addTopButton=false}}
@include('accounting::sections.pageTitle')
@section('content')
@include('accounting::sections.blocks.messages')
<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-inverse" {{__('accounting::modules.accounting.rtl')}} >
            <div class="panel-heading">@yield('form-panel-heading')</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body" {{__('accounting::modules.accounting.rtl')}}>
                    {!! Form::open(['method'=>'POST']) !!}
                    <div class="form-body" {{__('accounting::modules.accounting.rtl')}}>
                        <div class="row">
                            @yield('form-inputs')
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" id="save-form" class="btn btn-success"> <i class="fa fa-check"></i> @lang('app.save')</button>
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


