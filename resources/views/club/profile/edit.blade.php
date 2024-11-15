@extends('layouts.club_member-app')

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
                <div class="panel-heading"> @lang("modules.profile.updateTitle")</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        {!! Form::open(['id'=>'updateProfile','class'=>'ajax-form','method'=>'PUT']) !!}
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <label>@lang("modules.profile.yourName")</label>
                                        <input type="text" name="name" id="name"
                                               class="form-control" value="{{ $userDetail->name }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang("modules.profile.yourEmail")</label>
                                        <input type="email" name="email" id="email"
                                               class="form-control"  value="{{ $userDetail->email }}">
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang("modules.profile.yourPassword")</label>
                                        <input type="password" name="password" id="password" class="form-control">
                                        <span class="help-block"> @lang("modules.profile.passwordNote")</span>
                                    </div>
                                </div>
                                <!--/span-->

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang("modules.profile.yourMobileNumber")</label>
                                        <input type="tel" name="mobile" id="mobile" class="form-control"
                                               value="{{ $userDetail->mobile }}">
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->


                            <!--/row-->
                            <!--row gst number-->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="m-b-10">
                                            <label class="control-label">@lang('modules.emailSettings.emailNotifications')</label>
                                        </div>
                                        <div class="radio radio-inline">
                                            <input type="radio" 
                                            @if ($userDetail->email_notifications)
                                                checked
                                            @endif
                                            name="email_notifications" id="email_notifications1" value="1">
                                            <label for="email_notifications1" class="">
                                                @lang('app.enable') </label>

                                        </div>
                                        <div class="radio radio-inline ">
                                            <input type="radio" name="email_notifications"
                                            @if (!$userDetail->email_notifications)
                                                checked
                                            @endif

                                                   id="email_notifications2" value="0">
                                            <label for="email_notifications2" class="">
                                                @lang('app.disable') </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">@lang("modules.client.address")</label>
                                        <textarea name="address" id="address" rows="5"
                                                  class="form-control">@if(!empty($membertDetail)){{ $membertDetail->address }}@endif</textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label>@lang("modules.profile.profilePicture")</label>
                                    <div class="form-group">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                @if(is_null($userDetail->image))
                                                    <img src="https://via.placeholder.com/200x150.png?text={{ str_replace(' ', '+', __('modules.profile.uploadPicture')) }}"
                                                         alt=""/>
                                                @else
                                                    <img src="{{ asset_url('avatar/'.$userDetail->image) }}" alt=""/>
                                                @endif
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail"
                                                 style="max-width: 200px; max-height: 150px;"></div>
                                            <div>
                                <span class="btn btn-info btn-file">
                                    <span class="fileinput-new"> @lang("app.selectImage") </span>
                                    <span class="fileinput-exists"> @lang("app.change") </span>
                                    <input type="file" name="image" id="image"> </span>
                                                <a href="javascript:;" class="btn btn-danger fileinput-exists"
                                                   data-dismiss="fileinput"> @lang("app.remove") </a>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <!--/span-->


                        </div>
                        <div class="form-actions">
                            <button type="submit" id="save-form" class="btn btn-success"><i class="fa fa-check"></i>
                                @lang("app.update")
                            </button>
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
    $('#save-form').click(function () {
        $.easyAjax({
            url: '{{route('club.profile.update', [$userDetail->id])}}',
            container: '#updateProfile',
            type: "POST",
            redirect: true,
            file: (document.getElementById("image").files.length == 0) ? false : true,
            data: $('#updateProfile').serialize()
        })
    });
</script>
@endpush

