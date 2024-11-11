@extends('layouts.app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 bg-title-left">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __($pageTitle) }}</h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12 bg-title-right">
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}">@lang('app.menu.home')</a></li>
                <li class="active">{{ __($pageTitle) }}</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection


@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">@lang('app.renew_membership_items_setting')</div>
                <div class="vtabs customvtab m-t-10">
                    <div class="tab-content">
                        <div id="vhome3" class="tab-pane active">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    {!! Form::open(['id'=>'editSettings','class'=>'ajax-form','method'=>'POST']) !!}
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="main_annual_fees">@lang('app.main_annual_fees')</label>
                                                <input type="text" class="form-control" id="main_annual_fees" name="main_annual_fees"
                                                       value="{{$renewSetting[0]->main_annual_fees}}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="affiliate_annual_fees">@lang('app.affiliate_annual_fees')</label>
                                                <input type="text" class="form-control" id="affiliate_annual_fees" name="affiliate_annual_fees"
                                                       value="{{$renewSetting[0]->affiliate_annual_fees}}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="administrative_expenses">@lang('app.administrative_expenses')</label>
                                                <input type="text" class="form-control" id="administrative_expenses" name="administrative_expenses"
                                                       value="{{$renewSetting[0]->administrative_expenses}}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="card_printing">@lang('app.card_printing')</label>
                                                <input type="text" class="form-control" id="card_printing" name="card_printing"
                                                       value="{{$renewSetting[0]->card_printing}}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="disabled_stamp">@lang('app.disabled_stamp')</label>
                                                <input type="text" class="form-control" id="disabled_stamp" name="disabled_stamp"
                                                       value="{{$renewSetting[0]->disabled_stamp}}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="martyr_stamp">@lang('app.martyr_stamp')</label>
                                                <input type="text" class="form-control" id="martyr_stamp" name="martyr_stamp"
                                                       value="{{$renewSetting[0]->martyr_stamp}}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="enhancing_constructions">@lang('app.enhancing_constructions')</label>
                                                <input type="text" class="form-control" id="enhancing_constructions" name="enhancing_constructions"
                                                       value="{{$renewSetting[0]->enhancing_constructions}}">
                                            </div>
                                        </div>

                                    </div>



                                    <button type="submit" id="save-form"
                                            class="btn btn-success waves-effect waves-light m-r-10">
                                        @lang('app.update')
                                    </button>

                                    {!! Form::close() !!}
                                </div>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


    </div>
    <!-- .row -->

@endsection

@push('footer-script')
    <script>

        $('#save-form').click(function () {
            $.easyAjax({
                url: '{{route('admin.members.update-renew-settings')}}',
                container: '#editSettings',
                type: "POST",
                redirect: true,
                file: true
            })
        });

    </script>

@endpush

