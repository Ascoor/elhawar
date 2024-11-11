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
            <li class="active">@lang('app.edit')</li>
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
            <div class="panel-heading"> @lang('modules.employees.updateTitle')
                [ {{ $userDetail->name }} ]
                @php($class = ($userDetail->status == 'active') ? 'label-custom' : 'label-danger')
                <span class="label {{$class}}">{{ucfirst($userDetail->status)}}</span>
            </div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    {!! Form::open(['id'=>'updateEmployee','class'=>'ajax-form','method'=>'PUT']) !!}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="required">@lang('modules.employees.employeeId')</label>
                                    <a class="mytooltip" href="javascript:void(0)">
                                        <i class="fa fa-info-circle"></i><span class="tooltip-content5"><span class="tooltip-text3"><span
                                                        class="tooltip-inner2">@lang('modules.employees.employeeIdInfo')</span></span></span></a>
                                    <input type="text" name="employee_id" id="employee_id" class="form-control"
                                           value="{{ $employeeDetail->employee_id }}" autocomplete="nope">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="required">@lang('modules.employees.employeeName')</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ $userDetail->name }}" autocomplete="nope">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="required">@lang('modules.employees.employeeEmail')</label>
                                    <input type="email" name="email" id="email" class="form-control" value="{{ $userDetail->email }}" autocomplete="nope">
                                    <span class="help-block">Employee will login using this email.</span>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="required">@lang('modules.employees.employeePassword')</label>
                                    <input type="password" style="display: none">
                                    <input type="password" name="password" id="password" class="form-control" autocomplete="nope">
                                    <span class="help-block"> @lang('modules.employees.updatePasswordNote')</span>
                                </div>
                            </div>
                            <!--/span-->
                        </div>

                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label"><i
                                                    class="fa fa-slack"></i> @lang('modules.employees.slackUsername')
                                        </label>
                                    <div class="input-group"><span class="input-group-addon">@</span>
                                        <input type="text" id="slack_username" name="slack_username" class="form-control" autocomplete="nope" value="{{ $employeeDetail->slack_username ?? '' }}">
                                    </div>
                                </div>
                            </div>
                            <!--/span-->

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="required">@lang('modules.employees.joiningDate')</label>
                                    <input type="text" name="joining_date" id="joining_date" @if($employeeDetail) value="{{ $employeeDetail->joining_date->format($global->date_format) }}"
                                        @endif class="form-control">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>@lang('modules.employees.lastDate')</label>
                                    <input type="text" autocomplete="off" name="last_date" id="end_date" @if($employeeDetail) value="@if($employeeDetail->last_date) {{ $employeeDetail->last_date->format($global->date_format) }} @endif"
                                        @endif class="form-control">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>@lang('modules.employees.gender')</label>
                                    <select name="gender" id="gender" class="form-control">
                                            <option @if($userDetail->gender == 'male') selected
                                                    @endif value="male">@lang('app.male')</option>
                                            <option @if($userDetail->gender == 'female') selected
                                                    @endif value="female">@lang('app.female')</option>
                                            <option @if($userDetail->gender == 'others') selected
                                                    @endif value="others">@lang('app.others')</option>
                                        </select>
                                </div>
                            </div>

                        </div>
                        <!--/row-->

                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('modules.employees.religion')</label>
                                    <select name="religion" id="religion" class="form-control">
                                        <option {{ $employeeDetail->religion == 'muslim' ?'selected' : '' }} value="muslim">@lang('app.muslim')</option>
                                        <option {{ $employeeDetail->religion == 'christian' ?'selected' : '' }} value="christian">@lang('app.christian')</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('modules.employees.social_situation')</label>
                                    <select name="social_situation" id="social_situation" class="form-control">
                                        <option {{ $employeeDetail->social_situation == 'single' ?'selected' : '' }} value="single">@lang('app.single')</option>
                                        <option {{ $employeeDetail->social_situation == 'married' ?'selected' : '' }} value="married">@lang('app.married')</option>
                                        <option {{ $employeeDetail->social_situation == 'engaged' ?'selected' : '' }} value="engaged">@lang('app.engaged')</option>
                                        <option {{ $employeeDetail->social_situation == 'divorced' ?'selected' : '' }} value="divorced">@lang('app.divorced')</option>
                                        <option {{ $employeeDetail->social_situation == 'widower' ?'selected' : '' }} value="widower">@lang('app.widower')</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('modules.employees.recruitment_data')</label>
                                    <select name="recruitment_data" id="recruitment_data" class="form-control">
                                        <option value="">----</option>
                                        <option {{ $employeeDetail->recruitment_data == 'Led_service' ?'selected' : '' }} value="Led_service">@lang('app.Led_service')</option>
                                        <option {{ $employeeDetail->recruitment_data == 'exempt' ?'selected' : '' }} value="exempt">@lang('app.exempt')</option>
                                        <option {{ $employeeDetail->recruitment_data == 'finally_exempt' ?'selected' : '' }} value="finally_exempt">@lang('app.finally_exempt')</option>
                                        <option {{ $employeeDetail->recruitment_data == 'temporary_exempt' ?'selected' : '' }} value="temporary_exempt">@lang('app.temporary_exempt')</option>
                                        <option {{ $employeeDetail->recruitment_data == 'not_required' ?'selected' : '' }} value="not_required">@lang('app.not_required')</option>
                                        <option {{ $employeeDetail->recruitment_data == 'demand' ?'selected' : '' }} value="demand">@lang('app.demand')</option>
                                        <option {{ $employeeDetail->recruitment_data == 'not_his_turn_yet' ?'selected' : '' }} value="not_his_turn_yet">@lang('app.not_his_turn_yet')</option>
                                    </select>
                                </div>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="required">@lang('modules.employees.national_id')</label>
                                    <input type="number" name="national_id" id="national_id" value="{{ $employeeDetail->national_id ?? '' }}" class="form-control" >
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="required">@lang('modules.employees.issuance_location')</label>
                                    <input type="text" name="issuance_location" id="issuance_location" value="{{ $employeeDetail->issuance_location ?? '' }}" class="form-control" >
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="required">@lang('modules.employees.issuance_data')</label>
                                    <input type="date" name="issuance_data" id="issuance_data" value="{{ $employeeDetail->issuance_data ?? '' }}" class="form-control" >
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="required">@lang('modules.employees.expiration_date')</label>
                                    <input type="date" name="expiration_date" id="expiration_date" class="form-control" value="{{ $employeeDetail->expiration_date ?? '' }}" >
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required">@lang('modules.employees.qualification')</label>
                                    <input type="text" name="qualification" value="{{ $employeeDetail->qualification ?? '' }}" id="qualification" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required">@lang('modules.employees.banckAccount')</label>
                                    <input type="text" name="banck_account" id="banck_account" class="form-control" value="{{ $employeeDetail->banck_account ?? '0' }}">
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required">@lang('modules.employees.qualification_data')</label>
                                    <textarea type="text" name="qualification_data" id="qualification_data" class="form-control">{{ $employeeDetail->qualification_data ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group {{ $errors->has('document') ? 'has-error' : '' }}">
                                    <label for="document">@lang('modules.employees.document')</label>
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
                                    <textarea name="address" id="address" rows="3" class="form-control">{{ $employeeDetail->address ?? '' }}</textarea>
                                </div>
                            </div>

                        </div>
                        <!--/span-->
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="form-group">
                                    <label>@lang('app.skills')</label>
                                    <input name='tags' placeholder='@lang('app.skills')' value='{{implode(' , ', $userDetail->skills()) }}'>
                                </div>
                            </div>
                        </div>

                        <!--/row-->
                        <div class="row">
                            <div class="col-md-6 ">
                                <div class="form-group">
                                    <label class="required">@lang('app.designation') <a href="javascript:;" id="designation-setting" ><i class="ti-settings text-info"></i></a></label>
                                    <select name="designation" id="designation" class="form-control">
                                        @forelse($designations as $designation)
                                            <option @if(isset($employeeDetail->designation_id) && $employeeDetail->designation_id == $designation->id) selected @endif value="{{ $designation->id }}">{{ $designation->name }}</option>
                                        @empty
                                            <option value="">@lang('messages.noRecordFound')</option>
                                        @endforelse()
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 ">
                                <div class="form-group">
                                    <label class="required">@lang('app.department') <a href="javascript:;" id="department-setting" ><i class="ti-settings text-info"></i></a></label>
                                    <select name="department" id="department" class="form-control">
                                        <option value="">--</option>
                                        @foreach($teams as $team)
                                            <option @if(isset($employeeDetail->department_id) && $employeeDetail->department_id == $team->id) selected @endif value="{{ $team->id }}">{{ $team->team_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required">@lang('modules.employees.insuranceStatus') </label>
                                    <select name="insuranceStatus" id="insuranceStatus" class="form-control" onchange="callInsuranceNumberDate()">
                                        <option value="">--</option>
                                        <option @if(isset($employeeDetail->insuranceStatus) && $employeeDetail->insuranceStatus == 1) selected @endif value="1">@lang('modules.employees.insured')</option>
                                        <option @if(isset($employeeDetail->insuranceStatus) && $employeeDetail->insuranceStatus == 2) selected @endif value="2">@lang('modules.employees.uninsured')</option>
                                        <option @if(isset($employeeDetail->insuranceStatus) && $employeeDetail->insuranceStatus == 3) selected @endif value="3">@lang('modules.employees.retired')</option>
                                        <option @if(isset($employeeDetail->insuranceStatus) && $employeeDetail->insuranceStatus == 4) selected @endif value="4">@lang('modules.employees.otherGovernmentalInstitutions')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3" id="divInsuranceNumber" @if(isset($employeeDetail->insuranceStatus) && $employeeDetail->insuranceStatus == 1)style="display: block"@else style="display: none" @endif>
                                <div class="form-group" >
                                    <label class="control-label">@lang('modules.employees.insuranceNumber')</label>
                                    <input type="text" name='insuranceNumber' id='insuranceNumber' placeholder='@lang('modules.employees.insuranceNumber')' class="form-control" @if(isset($employeeDetail->insuranceNumber)) value='{{$employeeDetail->insuranceNumber}}' @else value='' @endif >
                                </div>
                            </div>
                            <div class="col-md-3" id="divInsuranceStartDate" @if(isset($employeeDetail->insuranceStatus) && $employeeDetail->insuranceStatus == 1)style="display: block"@else style="display: none" @endif>
                                <div class="form-group">
                                    <label>@lang('modules.employees.insuranceStartDate')</label>
                                    <input type="date" name='insuranceStartDate' id='insuranceStartDate' class="form-control" @if(isset($employeeDetail->insuranceStartDate)) value='{{$employeeDetail->insuranceStartDate}}' @else value='' @endif >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required">@lang('modules.employees.delegation') </label>
                                    <select name="delegation" id="delegation" class="form-control" onchange="callDelegationInstitution()">
                                        <option value="">--</option>
                                        <option @if(isset($employeeDetail->delegation) && $employeeDetail->delegation == 1) selected @endif value="1">@lang('modules.employees.delegated')</option>
                                        <option @if(isset($employeeDetail->delegation) && $employeeDetail->delegation == 2) selected @endif value="2">@lang('modules.employees.undelegated')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6" id="divDelegationInstitution"  @if(isset($employeeDetail->delegation) && $employeeDetail->delegation == 2) style="display: none" @endif >
                                <div class="form-group">
                                    <label>@lang('modules.employees.delegationInstitution')</label>
                                    <input name='delegationInstitution' id='delegationInstitution' placeholder='@lang('modules.employees.delegationInstitution')' class="form-control" @if(isset($employeeDetail->delegationInstitution)) value='{{$employeeDetail->delegationInstitution}}' @else value='' @endif>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!--/span-->

                            <div class="col-md-3">
                                <label>@lang('app.mobile')</label>
                                <div class="form-group">
                                    <select class="select2 phone_country_code form-control" name="phone_code">
                                        <option value="">--</option>
                                        @foreach ($countries as $item)
                                            <option
                                            @if ($item->id == $userDetail->country_id)
                                                selected
                                            @endif
                                            value="{{ $item->id }}">+{{ $item->phonecode.' ('.$item->iso.')' }}</option>
                                        @endforeach
                                    </select>
                                    <input type="tel" name="mobile" id="mobile" class="mobile" autocomplete="nope" value="{{ $userDetail->mobile }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label>@lang('app.phone')</label>
                                <div class="form-group">
                                    <select class="select2 phone_country_code form-control" name="select_land_phone_code">
                                        <option value="2" @if($select_land_phone_code == "2") selected @endif >القاهرة</option>
                                        <option value="3" @if($select_land_phone_code == "3") selected @endif >الإسكندرية</option>
                                        <option value="40" @if($select_land_phone_code == "40") selected @endif >طنطا</option>
                                        <option value="45" @if($select_land_phone_code == "45") selected @endif >دمنهور</option>
                                        <option value="46" @if($select_land_phone_code == "46") selected @endif >مطروح</option>
                                        <option value="47" @if($select_land_phone_code == "47") selected @endif >كفرالشيخ</option>
                                        <option value="48" @if($select_land_phone_code == "48") selected @endif >شبين الكوم</option>
                                        <option value="50"  @if($select_land_phone_code == "50") selected @endif >المنصورة</option>
                                        <option value="55" @if($select_land_phone_code == "55") selected @endif >الزقازيق</option>
                                        <option value="57" @if($select_land_phone_code == "57") selected @endif >دمياط</option>
                                        <option value="62" @if($select_land_phone_code == "62") selected @endif >السويس</option>
                                        <option value="64" @if($select_land_phone_code == "64") selected @endif >الإسماعيلية</option>
                                        <option value="65" @if($select_land_phone_code == "65") selected @endif >الغردقة</option>
                                        <option value="66" @if($select_land_phone_code == "66") selected @endif >بورسعيد</option>
                                        <option value="68" @if($select_land_phone_code == "68") selected @endif >العريش</option>
                                        <option value="69" @if($select_land_phone_code == "69") selected @endif >الطور</option>
                                        <option value="82" @if($select_land_phone_code == "82") selected @endif >بني سيوف</option>
                                        <option value="84" @if($select_land_phone_code == "84") selected @endif >الفيوم</option>
                                    </select>
                                    <input type="tel" name="land_phone_code" id="land_phone_code" class="mobile" autocomplete="nope" value="{{$land_phone_code}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>@lang('modules.employees.hourlyRate')</label>
                                    <input type="text" name="hourly_rate" id="hourly_rate" class="form-control" value="{{ $employeeDetail->hourly_rate ?? '' }}">
                                </div>
                            </div>
                            <!--/span-->

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>@lang('app.status')</label>
                                    <select name="status" id="status" class="form-control">
                                            <option @if($userDetail->status == 'active') selected
                                                    @endif value="active">@lang('app.active')</option>
                                            <option @if($userDetail->status == 'deactive') selected
                                                    @endif value="deactive">@lang('app.deactive')</option>
                                        </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('app.login')</label>
                                    <select name="login" id="login" class="form-control">
                                        <option @if($userDetail->login == 'enable') selected @endif value="enable">@lang('app.enable')</option>
                                        <option @if($userDetail->login == 'disable') selected @endif value="disable">@lang('app.disable')</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
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
                            <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="address">@lang('modules.accountSettings.changeLanguage')</label>
                                            <select name="locale" id="locale" class="form-control select2">
                                            <option @if($global->locale == "en") selected @endif value="en">English
                                                    </option>
                                                @foreach($languageSettings as $language)
                                                    <option value="{{ $language->language_code }}" @if($userDetail->locale == $language->language_code) selected @endif >{{ $language->language_name }}</option>
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
                                            <img src="{{ $userDetail->image_url }}" alt="" />
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                                        <div>
                                            <span class="btn btn-info btn-file">
                                    <span class="fileinput-new"> @lang('app.selectImage') </span>
                                            <span class="fileinput-exists"> @lang('app.change') </span>
                                            <input type="file" name="image" id="image"> </span>
                                            <a href="javascript:;" class="btn btn-danger fileinput-exists" data-dismiss="fileinput"> @lang('app.remove') </a>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <!--/span-->

                        <div class="row">
                            @if(isset($fields)) @foreach($fields as $field)
                            <div class="col-md-6">
                                <label>{{ ucfirst($field->label) }}</label>
                                <div class="form-group">
                                    @if( $field->type == 'text')
                                    <input type="text" name="custom_fields_data[{{$field->name.'_'.$field->id}}]" class="form-control" placeholder="{{$field->label}}"
                                        value="{{$employeeDetail->custom_fields_data['field_'.$field->id] ?? ''}}">                                    @elseif($field->type == 'password')
                                    <input type="password" name="custom_fields_data[{{$field->name.'_'.$field->id}}]" class="form-control" placeholder="{{$field->label}}"
                                        value="{{$employeeDetail->custom_fields_data['field_'.$field->id] ?? ''}}">                                    @elseif($field->type == 'number')
                                    <input type="number" name="custom_fields_data[{{$field->name.'_'.$field->id}}]" class="form-control" placeholder="{{$field->label}}"
                                        value="{{$employeeDetail->custom_fields_data['field_'.$field->id] ?? ''}}">                                    @elseif($field->type == 'textarea')
                                    <textarea name="custom_fields_data[{{$field->name.'_'.$field->id}}]" class="form-control" id="{{$field->name}}" cols="3">{{$employeeDetail->custom_fields_data['field_'.$field->id] ?? ''}}</textarea>                                    @elseif($field->type == 'radio')
                                    <div class="radio-list">
                                        @foreach($field->values as $key=>$value)
                                        <label class="radio-inline @if($key == 0) p-0 @endif">
                                                                <div class="radio radio-info">
                                                                    <input type="radio"
                                                                           name="custom_fields_data[{{$field->name.'_'.$field->id}}]"
                                                                           id="optionsRadios{{$key.$field->id}}"
                                                                           value="{{$value}}"
                                                                           @if(isset($employeeDetail) && $employeeDetail->custom_fields_data['field_'.$field->id] == $value) checked
                                                                           @elseif($key==0) checked @endif>>
                                                                    <label for="optionsRadios{{$key.$field->id}}">{{$value}}</label>
                                    </div>
                                    </label>
                                    @endforeach
                                </div>
                                @elseif($field->type == 'select') {!! Form::select('custom_fields_data['.$field->name.'_'.$field->id.']', $field->values,
                                isset($employeeDetail)?$employeeDetail->custom_fields_data['field_'.$field->id]:'',['class'
                                => 'form-control gender']) !!} 
                                
                                @elseif($field->type == 'checkbox')
                                <div class="mt-checkbox-inline custom-checkbox checkbox-{{$field->id}}">
                                    <input type="hidden" name="custom_fields_data[{{$field->name.'_'.$field->id}}]" 
                                    id="{{$field->name.'_'.$field->id}}" value="{{$employeeDetail->custom_fields_data['field_'.$field->id]}}">
                                    @foreach($field->values as $key => $value)
                                        <label class="mt-checkbox mt-checkbox-outline">
                                            <input name="{{$field->name.'_'.$field->id}}[]" class="custom_fields_data[{{$field->name.'_'.$field->id}}]"
                                                   type="checkbox" value="{{$value}}" onchange="checkboxChange('checkbox-{{$field->id}}', '{{$field->name.'_'.$field->id}}')"
                                                   @if($employeeDetail->custom_fields_data['field_'.$field->id] != '' && in_array($value ,explode(', ', $employeeDetail->custom_fields_data['field_'.$field->id]))) checked @endif > {{$value}}
                                            <span></span>
                                        </label>
                                    @endforeach
                                </div>
                                @elseif($field->type == 'date')
                                <input type="text" class="form-control date-picker" size="16" name="custom_fields_data[{{$field->name.'_'.$field->id}}]"
                                    value="{{ ($employeeDetail->custom_fields_data['field_'.$field->id] != '') ? \Carbon\Carbon::parse($employeeDetail->custom_fields_data['field_'.$field->id])->format($global->date_format) : \Carbon\Carbon::now()->format($global->date_format)}}">                                @endif
                                <div class="form-control-focus"></div>
                                <span class="help-block"></span>

                            </div>
                        </div>
                        @endforeach @endif

                    </div>



                </div>
                <div class="form-actions">
                    <button type="submit" id="save-form" class="btn btn-success"><i
                                        class="fa fa-check"></i> @lang('app.update')</button>
                    <a href="{{ route('admin.employees.index') }}" class="btn btn-default">@lang('app.back')</a>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
</div>
<!-- .row -->

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
    $("#joining_date, .date-picker,  #end_date").datepicker({
            todayHighlight: true,
            autoclose: true,
            weekStart:'{{ $global->week_start }}',
            format: '{{ $global->date_picker_format }}',
        });

        $('#save-form').click(function () {
            $.easyAjax({
                url: '{{route('admin.employees.update', [$userDetail->id])}}',
                container: '#updateEmployee',
                type: "POST",
                redirect: true,
                file: (document.getElementById("image").files.length == 0) ? false : true,
                data: $('#updateEmployee').serialize()
            })
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
        clickable: true,
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
        init: function () {
            @if(isset($employeeDetail) && $employeeDetail->document)
            var files = {!! json_encode($employeeDetail->document) !!}
            for (var i in files)
            {
                var file = files[i]

                if (file['mime_type'].includes('image')) {
                    this.options.addedfile.call(this, file)
                    this.options.thumbnail.call(this, file, file.preview)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="document[]" value="' + file.file_name + '">')
                    var newNode = document.createElement('a');
                    newNode.className = 'btn btn-primary btn-xs downloadbtn';
                    newNode.href = file.url;
                    newNode.style = "margin: 15px;";
                    newNode.target = "_blank";
                    newNode.innerHTML = '<i class="fa fa-download"></i> Download';
                    file.previewTemplate.appendChild(newNode);

                } else if(file['mime_type'].includes('.document'))
                {
                    this.options.addedfile.call(this, file)
                    this.options.thumbnail.call(this, file, '{{url('plugins/dropzone/img/word.jpg')}}')
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="document[]" value="' + file.file_name + '">')
                    var newNode = document.createElement('a');
                    newNode.className = 'btn btn-primary btn-xs downloadbtn';
                    newNode.href = file.url;
                    newNode.target = "_blank";
                    newNode.style = "margin: 15px;";
                    newNode.innerHTML = '<i class="fa fa-download"></i> Download';
                    file.previewTemplate.appendChild(newNode);

                } else if(file['mime_type'].includes('pdf'))
                {
                    this.options.addedfile.call(this, file)
                    this.options.thumbnail.call(this, file, '{{url('plugins/dropzone/img/pdf.png')}}')
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="document[]" value="' + file.file_name + '">')
                    var newNode = document.createElement('a');
                    newNode.className = 'btn btn-primary btn-xs downloadbtn';
                    newNode.href = file.url;
                    newNode.target = "_blank";
                    newNode.style = "margin: 15px;";
                    newNode.innerHTML = '<i class="fa fa-download"></i> Download';
                    file.previewTemplate.appendChild(newNode);

                }else if(file['mime_type'].includes('sheet'))
                {
                    this.options.addedfile.call(this, file)
                    this.options.thumbnail.call(this, file, '{{url('plugins/dropzone/img/xls.png')}}')
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="document[]" value="' + file.file_name + '">')
                    var newNode = document.createElement('a');
                    newNode.className = 'btn btn-primary btn-xs downloadbtn';
                    newNode.href = file.url;
                    newNode.target = "_blank";
                    newNode.style = "margin: 15px;";
                    newNode.innerHTML = '<i class="fa fa-download"></i> Download';
                    file.previewTemplate.appendChild(newNode);

                }



            }
            @endif
                this.on("addedfile", function (data) {
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
            this.on("complete",function(file){
                var newNode = document.createElement('a');
                newNode.className = 'btn btn-primary btn-xs downloadbtn';
                newNode.href = file.url;
                newNode.target = "_blank";
                newNode.innerHTML = '<i class="fa fa-download"></i> Download';
                file.previewTemplate.appendChild(newNode);

            });


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
        }
    }
</script>

 @endpush
