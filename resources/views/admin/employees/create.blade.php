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
            <li><a href="{{ route('admin.employees.index') }}">{{ __($pageTitle) }}</a></li>
            <li class="active">@lang('app.addNew')</li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>
@endsection

@push('head-script')
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/tagify-master/dist/tagify.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
@endpush

@section('content')

<div class="row">
    <div class="col-xs-12">

        <div class="panel panel-inverse">
            <div class="panel-heading"> @lang('modules.employees.createTitle')</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    {!! Form::open(['id'=>'createEmployee','class'=>'ajax-form','method'=>'POST']) !!}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="required">@lang('modules.employees.employeeId')</label>
                                    <a class="mytooltip" href="javascript:void(0)">
                                        <i class="fa fa-info-circle"></i><span class="tooltip-content5"><span
                                                class="tooltip-text3"><span
                                                    class="tooltip-inner2">@lang('modules.employees.employeeIdInfo')</span></span></span></a>
                                    <input type="text" name="employee_id" id="employee_id" class="form-control"
                                     value="{{ $employee_id }}" readonly>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="required">@lang('modules.employees.employeeName')</label>
                                    <input type="text" name="name" id="name" class="form-control" autocomplete="nope">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="required">@lang('modules.employees.employeeEmail')</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        autocomplete="off">
                                    <span class="help-block">@lang('modules.employees.emailNote')</span>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="required">@lang('modules.employees.employeePassword')</label>
                                    <input type="password" style="display: none">
                                    <input type="password" name="password" id="password" class="form-control"
                                    autocomplete="new-password">
                                    {{-- rola  autocomplete="new-password"--}}
                                    <span class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                    <span class="help-block"> @lang('modules.employees.passwordNote') </span>
                                    <div class="checkbox checkbox-info">
                                        <input id="random_password" name="random_password" value="true" type="checkbox">
                                        <label
                                            for="random_password">@lang('modules.client.generateRandomPassword')</label>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->

                            <!--/span-->
                        </div>

                        <!--/row-->

                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label"><i class="fa fa-slack"></i>
                                        @lang('modules.employees.slackUsername')</label>
                                    <div class="input-group"> <span class="input-group-addon">@</span>
                                        <input autocomplete="off" type="text" id="slack_username" name="slack_username"
                                            class="form-control">
                                            {{-- Rola autocomplete="off" --}}
                                    </div>
                                </div>
                            </div>
                            <!--/span-->

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="required">@lang('modules.employees.joiningDate')</label>
                                    <input type="text" autocomplete="off" name="joining_date" id="joining_date"
                                        class="form-control">
                                </div>
                            </div>
                            <!--/span-->

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>@lang('modules.employees.lastDate')</label>
                                    <input type="text" autocomplete="off" name="last_date" id="end_date"
                                        class="form-control">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>@lang('modules.employees.gender')</label>
                                    <select name="gender" id="gender" class="form-control">
                                        <option value="male">@lang('app.male')</option>
                                        <option value="female">@lang('app.female')</option>
                                        <option value="others">@lang('app.others')</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <!--/row-->

                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    {{-- {{ __($pageTitle) }} --}}
                                    {{-- ROLA ADDED UPPER CASE --}}
                                    {{-- @lang('modules.employees.religion') --}}
                                    <label>{{ ucfirst(__('modules.employees.religion')) }}</label>
                                    <select name="religion" id="religion" class="form-control">
                                        <option value="muslim">@lang('app.muslim')</option>
                                        <option value="christian">@lang('app.christian')</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('modules.employees.social_situation')</label>
                                    <select name="social_situation" id="social_situation" class="form-control">
                                        <option value="single">@lang('app.single')</option>
                                        <option value="married">@lang('app.married')</option>
                                        <option value="engaged">@lang('app.engaged')</option>
                                        <option value="divorced">@lang('app.divorced')</option>
                                        <option value="widower">@lang('app.widower')</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    {{-- ROLA ADDED UPPER CASE --}}
                                    <label> {{ ucwords(__('modules.employees.recruitment_data')) }}</label>
                                    <select name="recruitment_data" id="recruitment_data" class="form-control">
                                        <option value="Led_service">@lang('app.Led_service')</option>
                                        <option value="exempt">@lang('app.exempt')</option>
                                        <option value="finally_exempt">@lang('app.finally_exempt')</option>
                                        <option value="temporary_exempt">@lang('app.temporary_exempt')</option>
                                        <option value="not_required">@lang('app.not_required')</option>
                                        <option value="demand">@lang('app.demand')</option>
                                        <option value="not_his_turn_yet">@lang('app.not_his_turn_yet')</option>
                                    </select>
                                </div>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-md-3">

                                {{-- ROLA ADDED UPPER CASE --}}
                                <div class="form-group">
                                    <label class="required">{{ ucwords(__('modules.employees.national_id')) }}</label>
                                    <input type="number" name="national_id" id="national_id" class="form-control">
                                </div>
                            </div>

                            {{-- ROLA ADDED UPPER CASE --}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="required">{{
                                        ucwords(__('modules.employees.issuance_location'))}}</label>
                                    <input type="text" name="issuance_location" id="issuance_location"
                                        class="form-control">
                                </div>
                            </div>
                            {{-- ROLA ADDED UPPER CASE --}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="required">{{ ucwords(__('modules.employees.issuance_data'))}}</label>
                                    <input type="date" name="issuance_data" id="issuance_data" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="required">@lang('modules.employees.expiration_date')</label>
                                    <input type="date" name="expiration_date" id="expiration_date" class="form-control">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            {{-- ROLA ADDED UPPER CASE --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required">{{ ucwords(__('modules.employees.qualification')) }}</label>
                                    <input type="text" name="qualification" id="qualification" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{-- ROLA REMOVED class="required" --}}
                                    {{-- <label class="required">@lang('modules.employees.banckAccount --}}
                                        <label>@lang('modules.employees.banckAccount')</label>
                                        <input type="text" name="banck_account" id="banck_account" class="form-control"
                                            value="0">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                {{-- ROLA ADDED UPPER CASE --}}

                                <div class="form-group">
                                    {{-- ROLA REMOVED class="required" --}}
                                    {{-- <label class="required"> {{ ucwords(__('modules.employees.qualification_data'))
                                        }}</label> --}}
                                    <label> {{ ucwords(__('modules.employees.qualification_data')) }}</label>
                                    <textarea type="text" name="qualification_data" id="qualification_data"
                                        class="form-control">
                                            </textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">

                                {{-- ROLA ADDED UPPER CASE --}}

                                <div class="form-group {{ $errors->has('document') ? 'has-error' : '' }}">
                                    <label for="document">{{ ucwords(__('modules.employees.document')) }}</label>
                                    <div class="needsclick dropzone" id="images-dropzone">
                                    </div>
                                    @if($errors->has('document'))
                                    <span class="help-block" role="alert">{{ $errors->first('document') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>




                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="control-label">@lang('app.address')</label>
                                    <textarea name="address" id="address" rows="5" class="form-control"></textarea>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>@lang('app.skills')</label>
                                    <input name='tags' placeholder='@lang(' app.skills')' value=''>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            {{-- designation Designation_id --}}




                            <div class="col-md-6 ">
                                <div class="form-group">
                                    <label class="required">@lang('app.designation') <a href="javascript:;"
                                            id="designation-setting"><i class="ti-settings text-info"></i></a></label>
                                    <select name="designation" id="designation" class="form-control">
                                        @forelse($designations as $designation)
                                        <option value="{{ $designation->id }}">{{$designation->name}}</option>
                                        @empty
                                        <option value="">@lang('messages.noRecordFound')</option>
                                        @endforelse()
                                    </select>
                                </div>
                            </div>






                            <div class="col-md-6 ">
                                <div class="form-group">
                                    <label class="required">@lang('app.department') <a href="javascript:;"
                                            id="department-setting"><i class="ti-settings text-info"></i></a></label>
                                    <select name="department" id="department" class="form-control">
                                        @foreach($teams as $team)
                                        <option value="{{ $team->id }}">{{ $team->team_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required">@lang('modules.employees.insuranceStatus') </label>
                                    <select name="insuranceStatus" id="insuranceStatus" class="form-control"
                                        onchange="callInsuranceNumberDate()">
                                        <option value="2">@lang('modules.employees.uninsured')</option>
                                        <option value="1">@lang('modules.employees.insured')</option>
                                        <option value="3">@lang('modules.employees.retired')</option>
                                        <option value="4">@lang('modules.employees.otherGovernmentalInstitutions')
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3" id="divInsuranceNumber" style="display: none">
                                <div class="form-group">
                                    <label class="control-label">@lang('modules.employees.insuranceNumber')</label>
                                    <input type="text" name='insuranceNumber' id='insuranceNumber' placeholder='@lang('
                                        modules.employees.insuranceNumber')' class="form-control" value=''>
                                </div>
                            </div>
                            <div class="col-md-3" id="divInsuranceStartDate" style="display: none">
                                <div class="form-group">
                                    <label>@lang('modules.employees.insuranceStartDate')</label>
                                    <input type="date" name='insuranceStartDate' id='insuranceStartDate'
                                        class="form-control" value=''>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required">@lang('modules.employees.delegation') </label>
                                    <select name="delegation" id="delegation" class="form-control"
                                        onchange="callDelegationInstitution()">
                                        <option value="2">@lang('modules.employees.undelegated')</option>
                                        <option value="1">@lang('modules.employees.delegated')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6" id="divDelegationInstitution" style="display: none">
                                <div class="form-group">
                                    <label>@lang('modules.employees.delegationInstitution')</label>
                                    <input name='delegationInstitution' id='delegationInstitution' placeholder='@lang('
                                        modules.employees.delegationInstitution')' class="form-control" value=''>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label>@lang('app.mobile')</label>
                                <div class="form-group">
                                    <select class="select2 phone_country_code form-control" name="phone_code">
                                        @foreach ($countries as $item)
                                        <option @if($item->id == 63) selected @endif value="{{ $item->id }}">+{{
                                            $item->phonecode.' ('.$item->iso.')' }}</option>
                                        @endforeach
                                    </select>
                                    <input type="tel" name="mobile" id="mobile" class="mobile" autocomplete="nope">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label>@lang('app.phone')</label>
                                <div class="form-group">
                                    <select class="select2 phone_country_code form-control"
                                        name="select_land_phone_code">
                                        <option value="2">القاهرة</option>
                                        <option value="3">الإسكندرية</option>
                                        <option value="40">طنطا</option>
                                        <option value="45">دمنهور</option>
                                        <option value="46">مطروح</option>
                                        <option value="47">كفرالشيخ</option>
                                        <option value="48">شبين الكوم</option>
                                        <option value="50" selected>المنصورة</option>
                                        <option value="55">الزقازيق</option>
                                        <option value="57">دمياط</option>
                                        <option value="62">السويس</option>
                                        <option value="64">الإسماعيلية</option>
                                        <option value="65">الغردقة</option>
                                        <option value="66">بورسعيد</option>
                                        <option value="68">العريش</option>
                                        <option value="69">الطور</option>
                                        <option value="82">بني سيوف</option>
                                        <option value="84">الفيوم</option>
                                    </select>
                                    <input type="tel" name="land_phone_code" id="land_phone_code" class="mobile"
                                        autocomplete="nope">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>@lang('modules.employees.hourlyRate') ({{ $global->currency->currency_code
                                        }})</label>
                                    <input type="text" name="hourly_rate" id="hourly_rate" class="form-control">
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>@lang('app.login')</label>
                                    <select name="login" id="login" class="form-control">
                                        <option value="enable">@lang('app.enable')</option>
                                        <option value="disable">@lang('app.disable')</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="m-b-10">
                                        <label
                                            class="control-label">@lang('modules.emailSettings.emailNotifications')</label>
                                    </div>
                                    <div class="radio radio-inline">
                                        <input type="radio" checked name="email_notifications" id="email_notifications1"
                                            value="1">
                                        <label for="email_notifications1" class="">
                                            @lang('app.enable') </label>

                                    </div>
                                    <div class="radio radio-inline ">
                                        <input type="radio" name="email_notifications" id="email_notifications2"
                                            value="0">
                                        <label for="email_notifications2" class="">
                                            @lang('app.disable') </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="address">@lang('modules.accountSettings.changeLanguage')</label>
                                    <select name="locale" id="locale" class="form-control select2">
                                        <option @if($global->locale == "en") selected @endif value="en">English
                                        </option>
                                        @foreach($languageSettings as $language)
                                        <option value="{{ $language->language_code }}">{{ $language->language_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label>@lang('modules.profile.profilePicture')</label>
                                <div class="form-group">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                            <img src="https://via.placeholder.com/200x150.png?text={{ str_replace(' ', '+', __('modules.profile.uploadPicture')) }}"
                                                alt="" />
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail"
                                            style="max-width: 200px; max-height: 150px;"></div>
                                        <div>
                                            <span class="btn btn-info btn-file">
                                                <span class="fileinput-new"> @lang('app.selectImage') </span>
                                                <span class="fileinput-exists"> @lang('app.change') </span>
                                                <input type="file" id="image" name="image"> </span>
                                            <a href="javascript:;" class="btn btn-danger fileinput-exists"
                                                data-dismiss="fileinput"> @lang('app.remove') </a>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <!--/span-->

                        <div class="row">
                            @if(isset($fields))
                            @foreach($fields as $field)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label @if($field->required == 'yes') class="required" @endif>{{
                                        ucfirst($field->label) }}</label>
                                    @if( $field->type == 'text')
                                    <input type="text" name="custom_fields_data[{{$field->name.'_'.$field->id}}]"
                                        class="form-control" placeholder="{{$field->label}}"
                                        value="{{$editUser->custom_fields_data['field_'.$field->id] ?? ''}}">
                                    @elseif($field->type == 'password')
                                    <input type="password" name="custom_fields_data[{{$field->name.'_'.$field->id}}]"
                                        class="form-control" placeholder="{{$field->label}}"
                                        value="{{$editUser->custom_fields_data['field_'.$field->id] ?? ''}}">
                                    @elseif($field->type == 'number')
                                    <input type="number" name="custom_fields_data[{{$field->name.'_'.$field->id}}]"
                                        class="form-control" placeholder="{{$field->label}}"
                                        value="{{$editUser->custom_fields_data['field_'.$field->id] ?? ''}}">

                                    @elseif($field->type == 'textarea')
                                    <textarea name="custom_fields_data[{{$field->name.'_'.$field->id}}]"
                                        class="form-control" id="{{$field->name}}"
                                        cols="3">{{$editUser->custom_fields_data['field_'.$field->id] ?? ''}}</textarea>

                                    @elseif($field->type == 'radio')
                                    <div class="radio-list">
                                        @foreach($field->values as $key=>$value)
                                        <label class="radio-inline @if($key == 0) p-0 @endif">
                                            <div class="radio radio-info">
                                                <input type="radio"
                                                    name="custom_fields_data[{{$field->name.'_'.$field->id}}]"
                                                    id="optionsRadios{{$key.$field->id}}" value="{{$value}}"
                                                    @if(isset($editUser) &&
                                                    $editUser->custom_fields_data['field_'.$field->id] == $value)
                                                checked @elseif($key==0) checked @endif>>
                                                <label for="optionsRadios{{$key.$field->id}}">{{$value}}</label>
                                            </div>
                                        </label>
                                        @endforeach
                                    </div>
                                    @elseif($field->type == 'select')
                                    {!! Form::select('custom_fields_data['.$field->name.'_'.$field->id.']',
                                    $field->values,
                                    isset($editUser)?$editUser->custom_fields_data['field_'.$field->id]:'',['class' =>
                                    'form-control gender'])
                                    !!}

                                    @elseif($field->type == 'checkbox')
                                    <div class="mt-checkbox-inline custom-checkbox checkbox-{{$field->id}}">
                                        <input type="hidden" name="custom_fields_data[{{$field->name.'_'.$field->id}}]"
                                            id="{{$field->name.'_'.$field->id}}" value=" ">
                                        @foreach($field->values as $key => $value)
                                        <label class="mt-checkbox mt-checkbox-outline">
                                            <input name="{{$field->name.'_'.$field->id}}[]" type="checkbox"
                                                onchange="checkboxChange('checkbox-{{$field->id}}', '{{$field->name.'_'.$field->id}}')"
                                                value="{{$value}}"> {{$value}}
                                            <span></span>
                                        </label>
                                        @endforeach
                                    </div>
                                    @elseif($field->type == 'date')
                                    <input type="text" class="form-control date-picker" size="16"
                                        name="custom_fields_data[{{$field->name.'_'.$field->id}}]"
                                        value="{{ isset($editUser->dob)?Carbon\Carbon::parse($editUser->dob)->format('Y-m-d'):Carbon\Carbon::now()->format($global->date_format)}}">
                                    @endif
                                    <div class="form-control-focus"> </div>
                                    <span class="help-block"></span>

                                </div>
                            </div>
                            @endforeach
                            @endif

                        </div>


                    </div>
                    <div class="form-actions">
                        <button type="submit" id="save-form" class="btn btn-success"> <i class="fa fa-check"></i>
                            @lang('app.save')</button>

                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div> <!-- .row -->
{{--Ajax Modal--}}
<div class="modal fade bs-modal-md in" id="departmentModel" role="dialog" aria-labelledby="myModalLabel"
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
<script src="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('plugins/tagify-master/dist/tagify.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script data-name="basic">
    function checkboxChange(parentClass, id){
        var checkedData = '';
        $('.'+parentClass).find("input[type= 'checkbox']:checked").each(function () {
            if(checkedData !== ''){
                checkedData = checkedData+', '+$(this).val();
            }
            else{
                checkedData = $(this).val();
            }
        });
        $('#'+id).val(checkedData);
    }

    (function(){
        $("#department").select2({
            formatNoMatches: function () {
                return "{{ __('messages.noRecordFound') }}";
            }
        });
        $("#designation").select2({
            formatNoMatches: function () {
                return "{{ __('messages.noRecordFound') }}";
            }
        });
        $(".select2").select2({
            formatNoMatches: function () {
                return "{{ __('messages.noRecordFound') }}";
            }
        });
        var input = document.querySelector('input[name=tags]'),
            // init Tagify script on the above inputs
            tagify = new Tagify(input, {
                whitelist : {!! json_encode($skills) !!},
                //  blacklist : [".NET", "PHP"] // <-- passed as an attribute in this demo
            });

// Chainable event listeners
        tagify.on('add', onAddTag)
            .on('remove', onRemoveTag)
            .on('input', onInput)
            .on('invalid', onInvalidTag)
            .on('click', onTagClick);

// tag added callback
        function onAddTag(e){
            tagify.off('add', onAddTag) // exmaple of removing a custom Tagify event
        }

// tag remvoed callback
        function onRemoveTag(e){
        }

// on character(s) added/removed (user is typing/deleting)
        function onInput(e){
        }

// invalid tag added callback
        function onInvalidTag(e){
        }

// invalid tag added callback
        function onTagClick(e){
        }

    })()
</script>

<script>
    $("#joining_date, #end_date, .date-picker").datepicker({
        todayHighlight: true,
        autoclose: true,
        weekStart:'{{ $global->week_start }}',
        format: '{{ $global->date_picker_format }}',
    });

    $('#save-form').click(function () {
        $.easyAjax({
            url: '{{route('admin.employees.store')}}',
            container: '#createEmployee',
            type: "POST",
            redirect: true,
            file: (document.getElementById("image").files.length == 0) ? false : true,
            data: $('#createEmployee').serialize()
        })
    });

    $('#random_password').change(function () {
        var randPassword = $(this).is(":checked");

        if(randPassword){
            $('#password').val('{{ str_random(8) }}');
            $('#password').attr('readonly', 'readonly');
        }
        else{
            $('#password').val('');
            $('#password').removeAttr('readonly');
        }
    });

    $('#department-setting').on('click', function (event) {
        event.preventDefault();
        var url = '{{ route('admin.teams.quick-create')}}';
        $('#modelHeading').html("@lang('messages.manageDepartment')");
        $.ajaxModal('#departmentModel', url);
    });

    $('#designation-setting').on('click', function (event) {
        event.preventDefault();
        var url = '{{ route('admin.designations.quick-create')}}';
        $('#modelHeading').html("@lang('messages.manageDepartment')");
        $.ajaxModal('#departmentModel', url);
    });

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>

<script>
    function callDelegationInstitution(){
                    var delegation = document.getElementById('delegation').value;
                    var divDelegationInstitution = document.getElementById('divDelegationInstitution');

                    if(delegation === "1"){
                        divDelegationInstitution.style.display = "block";
                    }else{
                        divDelegationInstitution.style.display="none";
                    }
                }
                function callInsuranceNumberDate(){
                    var insuranceStatus = document.getElementById('insuranceStatus').value;
                    var divInsuranceNumber = document.getElementById('divInsuranceNumber');
                    var divInsuranceStartDate = document.getElementById('divInsuranceStartDate');

                    if(insuranceStatus === "1"){
                        divInsuranceNumber.style.display = "block";
                        divInsuranceStartDate.style.display = "block";
                    }else{
                        divInsuranceNumber.style.display="none";
                        divInsuranceStartDate.style.display="none";
                    }
                }

                var uploadedImagesMap = {}
                Dropzone.options.imagesDropzone = {
                    url: '{{ route('admin.employees.storeMedia') }}',
                    maxFilesize: 2, // MB
                    acceptedFiles: '.jpeg,.jpg,.png,.gif,.pdf,.doc,.docx,.xlsx,.xls',
                    addRemoveLinks: true,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    params: {
                        size: 40,
                    },
                    success: function (file, response) {
                        $('form').append('<input type="hidden" name="document[]" value="' + response.name + '">')
                        uploadedImagesMap[file.name] = response.name
                    },
                    removedfile: function (file) {
                        console.log(file)
                        file.previewElement.remove()
                        var name = ''
                        if (typeof file.file_name !== 'undefined') {
                            name = file.file_name
                        } else {
                            name = uploadedImagesMap[file.name]
                        }
                        $('form').find('input[name="document[]"][value="' + name + '"]').remove()
                    },
                    error: function (file, response) {
                        if ($.type(response) === 'string') {
                            var message = response //dropzone sends it's own error messages in string
                        } else {
                            var message = response.errors.file
                        }
                        file.previewElement.classList.add('dz-error')
                        _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                        _results = []
                        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                            node = _ref[_i]
                            _results.push(node.textContent = message)
                        }

                        return _results
                    },
                    init: function () {
                        this.on("addedfile", function (data) {
                            console.log(data);

                            var ext = data.name.split('.').pop();

                            if (ext == "pdf") {
                                $(data.previewElement).find(".dz-image img").attr("src", "{{url('plugins/dropzone/img/pdf.png')}}");
                            } else if (ext.indexOf("doc") != -1) {
                                $(data.previewElement).find(".dz-image img").attr("src", "{{url('plugins/dropzone/img/word.jpg')}}");
                            } else if (ext.indexOf("xls") != -1) {
                                $(data.previewElement).find(".dz-image img").attr("src", "{{url('plugins/dropzone/img/xls.png')}}");
                            } else if (ext.indexOf("xlsx") != -1) {
                                $(data.previewElement).find(".dz-image img").attr("src", "{{url('plugins/dropzone/img/xls.png')}}");
                            }
                        });

                    },

                }

</script>

@endpush