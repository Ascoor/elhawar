@extends('layouts.app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-6 col-md-6 col-sm-4 col-xs-12 bg-title-left">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __($pageTitle) }}</h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-6 col-sm-8 col-md-6 col-xs-12 bg-title-right">
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}">@lang('app.menu.home')</a></li>
                <li><a href="{{ route('admin.settings.index') }}">@lang('app.menu.settings')</a></li>
                <li class="active">{{ __($pageTitle) }}</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection

@push('head-script')
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/switchery/dist/switchery.min.css') }}">
@endpush

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">@lang('app.menu.onlinePayment')</div>

                <div class="vtabs customvtab m-t-10">

                    @include('sections.payment_setting_menu')

                    <div class="tab-content">
                        <div id="vhome3" class="tab-pane active">

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12 ">
                                            {!! Form::open(['id'=>'updateSettings','class'=>'ajax-form','method'=>'PUT']) !!}
                                            <div class="form-body">


                                                <ul class="nav nav-tabs" role="tablist">

                                                    <li class="nav-item active">
                                                        <a class="nav-link active" data-toggle="tab" href="#Fawry" role="tab" aria-selected="true">
                                                    <span class="hidden-sm-up">
                                                        <i class="fa fa-wallet"></i>
                                                    </span>
                                                            <span class="hidden-xs-down">Fawry @if($credentials->fawry_status == 'active') <i class="fa fa-check-circle activated-gateway"></i> @endif</span>
                                                        </a>
                                                    </li>
                                                </ul>

                                                <div class="tab-content tabcontent-border">
                                                    <div class="tab-pane active" id="Fawry" role="tabpanel">

                                                        <div class="col-xs-12">
                                                            <div class="form-group">
                                                                <label>@lang('modules.payments.sandbox_merchant_code')</label>
                                                                <input type="text" name="sandbox_merchant_code" id="sandbox_merchant_code"
                                                                       class="form-control" value="{{ $credentials->sandbox_merchant_code }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>@lang('modules.payments.sandbox_merchant_hash')</label>
                                                                <input type="password" name="sandbox_merchant_hash" id="sandbox_merchant_hash"
                                                                       class="form-control" value="{{ $credentials->sandbox_merchant_hash }}">
                                                                <span class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>@lang('modules.payments.sandbox_plugin_url')</label>
                                                                <input type="text" name="sandbox_plugin_url" id="sandbox_plugin_url"
                                                                       class="form-control" value="{{ $credentials->sandbox_plugin_url }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12">
                                                            <div class="form-group">
                                                                <label>@lang('modules.payments.live_merchant_code')</label>
                                                                <input type="text" name="live_merchant_code" id="live_merchant_code"
                                                                       class="form-control" value="{{ $credentials->live_merchant_code }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>@lang('modules.payments.live_merchant_hash')</label>
                                                                <input type="password" name="live_merchant_hash" id="live_merchant_hash"
                                                                       class="form-control" value="{{ $credentials->live_merchant_hash }}">
                                                                <span class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>@lang('modules.payments.live_plugin_url')</label>
                                                                <input type="text" name="live_plugin_url" id="live_plugin_url"
                                                                       class="form-control" value="{{ $credentials->live_plugin_url }}">
                                                            </div>
                                                        </div>

                                                        <div class="col-xs-12">

                                                            <div class="form-group">
                                                                <h5>@lang('modules.payments.fawry_mode')</h5>
                                                                <select class="form-control" name="fawry_mode" id="fawry_mode" data-style="form-control">
                                                                    <option value="sandbox" @if($credentials->fawry_mode == 'sandbox') selected @endif>Sandbox</option>
                                                                    <option value="live" @if($credentials->fawry_mode == 'live') selected @endif>Live</option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="mail_from_name">@lang('app.webhook')</label>
                                                                <p class="text-bold">{{ url($credentials->fawry_callback_url) }}</p>
                                                                <p class="text-info">(@lang('messages.addPaypalWebhookUrl'))</p>
                                                            </div>
                                                        </div>
                                                        <!--/span-->

                                                        <div class="col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label" >@lang('modules.payments.fawry_status')</label>
                                                                <div class="switchery-demo">
                                                                    <input type="checkbox" name="fawry_status" @if($credentials->fawry_status == 'active') checked @endif class="js-switch " data-color="#00c292" data-secondary-color="#f96262"  />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/row-->
                                            </div>
                                            <div class="form-actions m-t-20">
                                                <button type="submit" id="save-form-2" class="btn btn-success"><i class="fa fa-check"></i>
                                                    @lang('app.save')
                                                </button>

                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
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


    {{--Ajax Modal--}}
    <div class="modal fade bs-modal-md in" id="leadStatusModal" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-md" id="modal-data-application">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <span class="caption-subject font-red-sunglo bold uppercase" id="modelHeading"></span>
                </div>
                <div class="modal-body">
                    Loading...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn blue">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{--Ajax Modal Ends--}}

@endsection

@push('footer-script')
    <script src="{{ asset('plugins/bower_components/switchery/dist/switchery.min.js') }}"></script>
    <script>
        // Switchery
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        $('.js-switch').each(function() {
            new Switchery($(this)[0], $(this).data());

        });
        $('#save-form-2').click(function () {
            $.easyAjax({
                url: '{{ route('admin.payment-gateway-credential.update', [$credentials->id])}}',
                container: '#updateSettings',
                type: "POST",
                redirect: true,
                data: $('#updateSettings').serialize()
            })
        });
    </script>
@endpush

