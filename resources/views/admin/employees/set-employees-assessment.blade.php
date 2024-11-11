@extends('layouts.app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 bg-title-left">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __($pageTitle) }}</h4>
        </div>
    </div>
@endsection


@section('content')

    <div class="row">
        <div class="col-xs-12">

            <div class="panel panel-inverse">
                <div class="panel-heading"> @lang('app.menu.employees_assessment_setting')</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        {!! Form::open(['id'=>'updateSettings','class'=>'ajax-form','method'=>'POST']) !!}
                            <div class="form-body">
                                <div id="tank">
                                    @foreach($settings as $key=>$setting)
                                        @if($setting->ass_val&&$setting->ass_val>0)
                                        <div class="row item-row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>@lang('app.menu.assessment-name-no')</label>
                                                    <input type="text" name="assessment_name[]"  class="form-control" autocomplete="nope" value="{{$setting->name}}">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>@lang('app.menu.assessment-value-no')</label>
                                                    <input type="number" name="assessment_value[]" class="form-control" autocomplete="nope" value="{{(int)($setting->ass_val)}}">
                                                </div>
                                            </div>
                                            <div class="col-md-4" @if($key>=1) style="display: none" @endif >
                                                <br>
                                                <button type="button" class="btn btn-info" id="add-item"><i class="fa fa-plus"></i>
                                                    @lang('modules.invoices.addItem')
                                                </button>
                                            </div>
                                            <div class="col-md-4" @if($key<1) style="display: none" @else style="display: block" @endif >
                                                <br>
                                                <button type="button" class="btn remove-item btn-danger" id="add-item"><i class="fa fa-remove"></i>
                                                    @lang('app.remove')
                                                </button>
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" id="save-form" class="btn btn-success"> <i class="fa fa-check"></i> @lang('app.save')</button>

                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>    <!-- .row -->

@endsection

@push('footer-script')
    <script>
        $('#add-item').click(function () {
            var el = document.getElementsByName('assessment_name[]');
            var i=el.length+1;
            var item = '<div class="row item-row">'
                            +'<div class="col-md-4">'
                                +'<div class="form-group">'
                                    +'<label>@lang('app.menu.assessment-name-no')</label>'
                                    +'<input type="text" name="assessment_name[]"  class="form-control" autocomplete="nope" value="{{$setting->name}}">'
                                +'</div>'
                            +'</div>'
                            +'<div class="col-md-2">'
                                +'<div class="form-group">'
                                    +'<label>@lang("app.menu.assessment-value-no")</label>'
                                    +'<input type="number" name="assessment_value[]" class="form-control" autocomplete="nope" value="{{(int)($setting->ass_val)}}">'
                                +'</div>'
                            +'</div>'
                            +'<div class="col-md-4" @if($key<1) style="display: none" @else style="display: block" @endif >'
                                +'<br>'
                                +'<button type="button" class="btn remove-item btn-danger" id="add-item"><i class="fa fa-remove"></i>@lang('app.remove')</button>'
                            +'</div>'
                        +'</div>'
            $(item).hide().appendTo("#tank").fadeIn(500);
        });
        $('#updateSettings').on('click','.remove-item', function () {
            $(this).closest('.item-row').fadeOut(300, function() {
                $(this).remove();
                calculateTotal();
            });
        });
        $('#save-form').click(function () {
            $.easyAjax({
                url: '{{route('admin.employees.store-employee-settings')}}',
                container: '#updateSettings',
                type: "POST",
                redirect: true,
                data: $('#updateSettings').serialize()
            })
        });
    </script>
@endpush

