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
            <li><a href="{{ route('admin.members.index') }}">{{ __($pageTitle) }}</a></li>
            <li class="active">@lang('app.addNew')</li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
    {{-- rola --}}
    {{-- added the launages setting" --}}
    @include('admin.dashboard-header.header_others');
</div>
@endsection

@push('head-script')
{{--
<link rel="stylesheet" href="{{ asset('public/plugins/metronics/wizard-4.css') }}">--}}

<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/summernote/dist/summernote.css') }}">
<style>
    .salutation .form-control {
        padding: 2px 2px;
    }

    .select-category button {
        background-color: white !important;
        font-size: 13px;
        color: #565656;
        border: 1px solid #e4e7ea !important;
    }

    .select-category button:hover {
        color: #565656;
        opacity: 1;
    }

    .bootstrap-select .dropdown-toggle:focus {
        outline: none !important;
    }
</style>

@endpush

@section('content')

<div class="row">
    <div class="col-xs-12">

        <div class="panel panel-inverse">
            <div class="panel-heading"> @lang('modules.members.createMember')</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    {!! Form::open(['id'=>'createClient','class'=>'ajax-form','method'=>'POST']) !!}
                    {{-- <form method="POST" action="{{route('admin.members.store')}}" autocomplete="off" id="kt_form">
                        --}}
                        @if(isset($leadDetail->id))
                        <input type="hidden" name="lead" value="{{ $leadDetail->id }}">
                        @endif
                        <div class="form-body">
                            <h3 class="box-title ">@lang('modules.members.memberDetails')</h3>
                            <hr>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="family_id" class="required">@lang('app.family_id')</label>
                                    <input type="text" id="family_id" name="family_id" class="form-control" {{$family_id
                                        ? 'readonly' : '' }} value="{{$family_id ?? ''}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="member_id" class="required">@lang('app.member_id')</label>
                                        <input type="text" id="member_id" name="member_id" class="form-control"
                                            {{$member_id ? 'readonly' : '' }} value="{{$member_id ?? ''}}">
                                    </div>
                                </div>
                                {{-- row 4 colom 3 --}}
                                <div class="col-md-1 ">
                                    <div class="form-group salutation" style="margin-top: 23px">
                                        <select name="salutation" id="salutation" class="form-control">
                                            <option value="">--</option>
                                            <option @if(isset($firstName) && $firstName=='mr' ) selected @endif
                                                value=@lang('app.mr')>@lang('app.mr')</option>
                                            <option @if(isset($firstName) && $firstName=='mrs' ) selected @endif
                                                value=@lang('app.mrs')>@lang('app.mrs')</option>
                                            <option @if(isset($firstName) && $firstName=='miss' ) selected @endif
                                                value=@lang('app.miss')>@lang('app.miss')</option>
                                            <option @if(isset($firstName) && $firstName=='dr' ) selected @endif
                                                value=@lang('app.dr')>@lang('app.dr')</option>
                                            <option @if(isset($firstName) && $firstName=='sir' ) selected @endif
                                                value=@lang('app.sir')>@lang('app.sir')</option>
                                            <option @if(isset($firstName) && $firstName=='madam' ) selected @endif
                                                value=@lang('app.madam')>@lang('app.madam')</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- name="name" id="name" --}}
                                <div class="col-md-2 ">
                                    <div class="form-group">
                                        <label for="name" class="required">@lang('modules.members.memberName')</label>
                                        <input type="text" name="name" id="name" value="" class="form-control"
                                            autocomplete="off">
                                        {{-- name="member_name" id="member_name" --}}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="national_id" class="required">@lang('app.national_id')</label>
                                        <input type="text" id="national_id" name="national_id" class="form-control">
                                    </div>
                                </div>


                            </div>

                            {{-- Member Email* --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="required">@lang('modules.members.memberEmail')</label>
                                        <input type="text" name="email" id="email" value="" class="form-control">
                                        <span class="help-block">@lang('modules.members.emailNote')</span>
                                    </div>
                                </div>
                                <!--/span-->
                                {{-- passowrd input --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="required">@lang('modules.members.memberPassword')</label>
                                        <input type="password" style="display: none">
                                        <input type="password" autocomplete="new-password" name="password" id="password"
                                            class="form-control">
                                        <span class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                        <span class="help-block"> @lang('modules.members.passwordNote') </span>

                                        <div class="checkbox checkbox-info">
                                            <input id="random_password" name="random_password" value="true"
                                                type="checkbox">
                                            <label
                                                for="random_password">@lang('modules.client.generateRandomPassword')</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="required" for="">@lang('modules.members.memberCategory')
                                            @if($member_id)
                                            <a href="javascript:;" id="addClientCategory" class="text-info"><i
                                                    class="ti-settings text-info "></i> </a>
                                            @endif
                                        </label>
                                        <select class="select2 form-control client-category"
                                            data-placeholder="@lang('modules.members.memberCategory')" id="category_id"
                                            name="category_id">
                                            @forelse($categories as $category)
                                            <option value="{{ $category->id }}">
                                                @lang('app.'.$category->category_name)
                                            </option>
                                            @empty
                                            <option value="">@lang('messages.noCategoryAdded')</option>
                                            @endforelse

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="required" for="">@lang('modules.members.relations')
                                            @if($member_id)
                                            <a href="javascript:;" id="relations" class="text-info"><i
                                                    class="ti-settings text-info "></i> </a>
                                            @endif
                                        </label>
                                        <select class="select2 form-control client-category"
                                            data-placeholder="@lang('modules.members.relations')" id="relation_id"
                                            name="relation_id">
                                            @forelse($relations as $relation)
                                            <option value="{{ $relation->id }}">
                                                @lang('app.member_relations.'.$relation->relation_name)
                                            </option>
                                            @empty
                                            <option value="">@lang('messages.noCategoryAdded')</option>
                                            @endforelse

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">@lang('modules.members.status')
                                            <a href="javascript:;" id="status" class="text-info"><i
                                                    class="ti-settings text-info required"></i> </a>
                                        </label>
                                        <select class="select2 form-control client-category"
                                            data-placeholder="@lang('modules.members.status')" id="status_id"
                                            name="status_id">
                                            @forelse($status as $state)
                                            <option value="{{ $state->id }}">
                                                @lang('app.member_status.'.$state->status_name)
                                            </option>
                                            @empty
                                            <option value="">@lang('messages.noCategoryAdded')</option>
                                            @endforelse

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="required" for="">@lang('modules.members.nationality')</label>
                                        <select class="select2 form-control " id="nationality_id" name="nationality_id">
                                            {{-- @foreach($countries as $country)--}}
                                            {{-- <option @if(isset($leadDetail->country) && $leadDetail->country ==
                                                $country->nicename) selected @endif value="{{ $country->id }}">{{
                                                $country->nicename }}</option>--}}
                                            <option @if(isset($leadDetail->country) && $leadDetail->country ==
                                                $country->nicename) selected @endif value="{{ 63
                                                }}">@lang('app.egyptian')</option>
                                            {{-- @endforeach--}}
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-3 ">
                                    <div class="form-group">
                                        <label class="required">@lang('modules.members.age')</label>
                                        <input type="text" name="age" id="age" value="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3 ">
                                    <div class="form-group">
                                        <label class="required">@lang('modules.members.profession')</label>
                                        <input type="text" name="profession" id="profession" value=""
                                            class="form-control ">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="required">@lang('modules.members.religion')</label>
                                        <select name="religion" id="religion" class="form-control">
                                            <option value="muslim">@lang('app.member_religion.muslim')</option>
                                            <option value="christian">@lang('app.member_religion.christian')</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="required">@lang('modules.employees.gender')</label>
                                        <select name="gender" id="gender" class="form-control">
                                            <option value="male">@lang('app.male')</option>
                                            <option value="female">@lang('app.female')</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="required">@lang('modules.members.BirthDate')</label>
                                            <input type="text" autocomplete="off" name="date_of_birth"
                                                id="date_of_birth" class="form-control"
                                                placeholder="{{ __('modules.members.BirthDate') }}">
                                        </div>
                                        {{-- rola added place holder --}}
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="required">@lang('modules.members.SubscriptionDate')</label>
                                            <input type="text" autocomplete="off" name="date_of_subscription"
                                                id="date_of_subscription" class="form-control"
                                                placeholder="{{ __('modules.members.SubscriptionDate') }}">
                                            {{-- rola added place holder --}}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="required">@lang('modules.members.LastPaymentDate')</label>
                                            <input type="text" autocomplete="off" name="date_of_last_payment"
                                                id="date_of_last_payment" class="form-control"
                                                placeholder="{{ __('modules.members.LastPaymentDate') }}">
                                        </div>
                                        {{-- rola added place holder --}}

                                    </div>
                                    {{-- CITY --}}
                                    <div class="col-md-3 ">
                                        <div class="form-group">
                                            <label class="required">@lang('modules.stripeCustomerAddress.city')</label>
                                            <input type="text" name="city" id="city"
                                                value="{{ $leadDetail->city ?? '' }}" class="form-control">
                                        </div>
                                    </div>
                                    {{-- STATE --}}
                                    <div class="col-md-3 ">
                                        <div class="form-group">
                                            <label class="required">@lang('modules.stripeCustomerAddress.state')</label>
                                            <input type="text" name="state" id="state"
                                                value="{{ $leadDetail->state ?? '' }}" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="required" for="">@lang('modules.clients.country')</label>
                                            <select class="select2 form-control " id="country_id" name="country_id">
                                                <option selected value="{{ 63 }}"> @lang('app.egypt')</option>
                                                @foreach($countries as $country)
                                                <option value="{{ $country->id }}">
                                                    @if($country->nicename=='Egypt') @lang('app.egypt')
                                                    @else
                                                    {{ $country->nicename }}
                                                    @endif
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    {{-- POSTAL CODE --}}
                                    <div class="col-md-3 ">
                                        <div class="form-group">
                                            <label>@lang('modules.stripeCustomerAddress.postalCode')</label>
                                            <input type="text" name="postal_code" id="postalCode"
                                                value="{{ $leadDetail->postal_code ?? '' }}" class="form-control">
                                        </div>
                                    </div>
                                    {{-- Excluded Categories --}}
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="required" for="">@lang('app.excluded_categories')</label>
                                            <select class="select2 form-control " id="excluded_categories_id"
                                                name="excluded_categories_id">
                                                @foreach($excluded_categories as $excluded_category)
                                                <option value="{{ $excluded_category->id }}">
                                                    @lang('app.'.$excluded_category->name)
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    {{-- last paid fiscal year --}}
                                    <div class="col-md-3 ">
                                        <div class="form-group">
                                            <label>@lang('modules.stripeCustomerAddress.last_paid_fiscal_year')</label>
                                            <input type="text" name="last_paid_fiscal_year" id="last_paid_fiscal_year"
                                                autocomplete="off"
                                                value="{{ $leadDetail->last_paid_fiscal_year ?? '' }}"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3 ">
                                        <div class="form-group">
                                            <label>@lang('modules.stripeCustomerAddress.date_of_the_board_of_directors')</label>
                                            <input type="text" name="date_of_the_board_of_directors"
                                                id="date_of_the_board_of_directors" autocomplete="off"
                                                value="{{ $leadDetail->date_of_the_board_of_directors ?? '' }}"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3 ">
                                        <div class="form-group">
                                            <label>@lang('modules.stripeCustomerAddress.decision_number')</label>
                                            <input type="text" name="decision_number" id="string"
                                                value="{{ $leadDetail->string ?? '' }}" class="form-control">
                                        </div>
                                    </div>

                                    {{-- Mohamed & Rola --}}
                                    {{-- mem_GraduationDesc --}}
                                    <div class="col-md-3 ">
                                        <div class="form-group">
                                            <label>
                                                @lang('modules.members.mem_GraduationDesc')
                                            </label>
                                            <input type="text" name="mem_GraduationDesc" id="mem_GraduationDesc"
                                                value="{{ $leadDetail->mem_GraduationDesc ?? '' }}"
                                                class="form-control">
                                        </div>
                                    </div>

                                    {{-- mem_HomePhone --}}
                                    <div class="col-md-3 ">
                                        <div class="form-group">
                                            <label>
                                                @lang('modules.members.mem_HomePhone')
                                            </label>
                                            <input type="tel" name="mem_HomePhone" id="mem_HomePhone"
                                                value="{{ $leadDetail->mem_HomePhone ?? '' }}" class="form-control">
                                        </div>
                                    </div>



                                    {{-- mem_WorkPhone --}}
                                    <div class="col-md-3 ">
                                        <div class="form-group">
                                            <label>
                                                @lang('modules.members.mem_WorkPhone')
                                            </label>
                                            <input type="tel" name="mem_WorkPhone" id="mem_WorkPhone"
                                                value="{{ $leadDetail->mem_WorkPhone ?? '' }}" class="form-control">
                                        </div>
                                    </div>

                                    {{-- memCard_MemberName memcard_membername--}}
                                    <div class="col-md-3 ">
                                        <div class="form-group">
                                            <label>
                                                @lang('modules.members.memCard_MemberName')
                                            </label>
                                            <input type="text" name="memCard_MemberName" id="memCard_MemberName"
                                                value="{{ $leadDetail->memCard_MemberName ?? '' }}"
                                                class="form-control">
                                        </div>
                                    </div>



                                </div>





                                {{-- <div class="row"> address*--}}

                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label required">@lang('app.address')</label>
                                                <textarea name="address" id="address" rows="5"
                                                    class="form-control ">{{ $leadDetail->address ?? '' }}</textarea>
                                            </div>
                                        </div>
                                        <!--/span-->

                                    </div>
                                    <!--/row-->

                                    <h3 class="box-title m-t-20">@lang('modules.members.communicationDetails')</h3>
                                    <hr>
                                    <!--/row-->
                                    <div class="row">
                                        <div class="col-md-3 ">
                                            <label class="required">@lang('app.mobile') <span class="required"
                                                    style="color:red;">*</span> </label>

                                            <div class="form-group">
                                                <select class="select2 phone_country_code form-control "
                                                    name="phone_code">
                                                    <option selected value="{{ 63 }}">{{'+20(EG)'}}</option>
                                                    @foreach ($countries as $item)
                                                    <option @if (isset($code[0]) && $item->phonecode == $code[0])
                                                        selected
                                                        @endif value="{{ $item->id }}">+{{ $item->phonecode.'
                                                        ('.$item->iso.')' }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="tel" name="mobile" id="mobile" class="mobile "
                                                    autocomplete="nope" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">

                                                <label>@lang('app.twitter')</label>
                                                <input type="text" name="twitter" id="twitter" class="form-control">
                                            </div>
                                        </div>
                                        <!--/span-->

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                {{-- >@lang('app.mobile') --}}
                                                <label>@lang('app.face_book')</label>
                                                <input type="text" name="facebook" id="facebook" class="form-control">
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <!--/row-->

                                    {{-- ===this row mosh zaher fil screen based on what idk====== --}}
                                    {{-- ==============uncomment <h1>ROLAAAA</h1> --}}
                                    <div class="row">
                                        @if(isset($fields))
                                        @foreach($fields as $field)
                                        <div class="col-md-6">
                                            {{-- <h1>ROLAAAA</h1> --}}
                                            <div class="form-group">
                                                <label @if($field->required == 'yes') class="required" @endif>{{
                                                    ucfirst($field->label) }}</label>
                                                @if( $field->type == 'text')
                                                <input type="text"
                                                    name="custom_fields_data[{{$field->name.'_'.$field->id}}]"
                                                    class="form-control" placeholder="{{$field->label}}"
                                                    value="{{$editUser->custom_fields_data['field_'.$field->id] ?? ''}}">
                                                @elseif($field->type == 'password')
                                                <input type="password"
                                                    name="custom_fields_data[{{$field->name.'_'.$field->id}}]"
                                                    class="form-control" placeholder="{{$field->label}}"
                                                    value="{{$editUser->custom_fields_data['field_'.$field->id] ?? ''}}">
                                                @elseif($field->type == 'number')
                                                <input type="number"
                                                    name="custom_fields_data[{{$field->name.'_'.$field->id}}]"
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
                                                                @if(isset($clientDetail) &&
                                                                $clientDetail->custom_fields_data['field_'.$field->id]
                                                            == $value) checked @elseif($key==0) checked @endif>>
                                                            <label
                                                                for="optionsRadios{{$key.$field->id}}">{{$value}}</label>
                                                        </div>
                                                    </label>
                                                    @endforeach
                                                </div>
                                                @elseif($field->type == 'select')
                                                {!! Form::select('custom_fields_data['.$field->name.'_'.$field->id.']',
                                                $field->values,
                                                isset($editUser)?$editUser->custom_fields_data['field_'.$field->id]:'',['class'
                                                => 'form-control gender'])
                                                !!}

                                                @elseif($field->type == 'checkbox')
                                                <div class="mt-checkbox-inline custom-checkbox checkbox-{{$field->id}}">
                                                    <input type="hidden"
                                                        name="custom_fields_data[{{$field->name.'_'.$field->id}}]"
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
                                                <input type="text" class="form-control form-control-inline date-picker"
                                                    size="16" name="custom_fields_data[{{$field->name.'_'.$field->id}}]"
                                                    value="{{ isset($editUser->dob)?Carbon\Carbon::parse($editUser->dob)->format('Y-m-d'):Carbon\Carbon::now()->format($global->date_format)}}">
                                                @endif
                                                <div class="form-control-focus"> </div>
                                                <span class="help-block"></span>

                                            </div>
                                        </div>
                                        @endforeach
                                        @endif

                                    </div>



                                    {{-- ========IMAGE* ROW CONTAINER============= --}}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>@lang('modules.profile.profilePicture')</label>
                                            <div class="form-group">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail"
                                                        style="width: 200px; height: 150px;">
                                                        <img src="https://via.placeholder.com/200x150.png?text={{ str_replace(' ', '+', __('modules.profile.uploadPicture')) }}"
                                                            alt="" />
                                                    </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail"
                                                        style="max-width: 200px; max-height: 150px;"></div>
                                                    <div>
                                                        <span class="btn btn-info btn-file">
                                                            <span class="fileinput-new"> @lang('app.selectImage')
                                                            </span>
                                                            <span class="fileinput-exists"> @lang('app.change') </span>
                                                            <input type="file" id="image" name="image"> </span>
                                                        <a href="javascript:;" class="btn btn-danger fileinput-exists"
                                                            data-dismiss="fileinput"> @lang('app.remove') </a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                    {{-- ====================first note Note1 n1 Note 1===================== --}}
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <label>@lang('app.note')</label>
                                            <div class="form-group">
                                                <textarea name="note" id="note" class="form-control "
                                                    rows="5"></textarea>
                                            </div>
                                        </div>
                                        {{-- ====================second note Note2 n2 Note 1===================== --}}

                                        <div class="col-xs-6">
                                            <label>@lang('app.note_2')</label>
                                            <div class="form-group">
                                                <textarea name="note_2" id="note_2" class="form-control "
                                                    rows="5"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- //second note by shorouk--}}
                                    <div class="row">

                                    </div>
                                    {{-- ==================== note Note3 ===================== --}}

                                    <div class="row">
                                        <div class="col-xs-6">
                                            <label>@lang('app.note_3')</label>
                                            <div class="form-group">
                                                <textarea name="note_3" id="note_3" class="form-control"
                                                    rows="5"></textarea>
                                            </div>
                                        </div>
                                        {{-- ==================== note Note4 ===================== --}}

                                        <div class="col-xs-6">
                                            <label>@lang('app.note_4')</label>
                                            <div class="form-group">
                                                <textarea name="note_4" id="note_4" class="form-control "
                                                    rows="5"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- ==================== note Note5 ===================== --}}

                                    <div class="row">
                                        <div class="col-xs-12">
                                            <label>@lang('app.remarks')</label>
                                            <div class="form-group">
                                                <textarea name="remarks" id="remarks" class="form-control summernote"
                                                    rows="5"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom: 20px;">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div style="margin-bottom: 10px;">
                                                    <label
                                                        class="control-label">@lang('modules.client.sendCredentials')</label>
                                                    <a class="mytooltip" href="javascript:void(0)"> <i
                                                            class="fa fa-info-circle"></i><span
                                                            class="tooltip-content5"><span class="tooltip-text3"><span
                                                                    class="tooltip-inner2">@lang('modules.client.sendCredentialsMessage')</span></span></span></a>
                                                </div>
                                                <div class="radio radio-inline col-md-4">
                                                    <input type="radio" name="sendMail" id="sendMail1" value="yes">
                                                    <label for="sendMail1" class="">
                                                        @lang('app.yes') </label>
                                                </div>
                                                <div class="radio radio-inline col-md-4">
                                                    <input type="radio" name="sendMail" id="sendMail2" checked
                                                        value="no">
                                                    <label for="sendMail2" class="">
                                                        @lang('app.no') </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="m-b-10">
                                                    <label
                                                        class="control-label">@lang('modules.emailSettings.emailNotifications')</label>
                                                </div>
                                                <div class="radio radio-inline">
                                                    <input type="radio" checked name="email_notifications"
                                                        id="email_notifications1" value="1">
                                                    <label for="email_notifications1" class="">
                                                        @lang('app.enable') </label>

                                                </div>
                                                <div class="radio radio-inline ">
                                                    <input type="radio" name="email_notifications"
                                                        id="email_notifications2" value="0">
                                                    <label for="email_notifications2" class="">
                                                        @lang('app.disable') </label>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label
                                                    for="address">@lang('modules.accountSettings.changeLanguage')</label>
                                                <select name="locale" id="locale" class="form-control select2">
                                                    <option @if($global->locale == "en") selected @endif
                                                        value="en">English
                                                    </option>
                                                    @foreach($languageSettings as $language)
                                                    <option value="{{ $language->language_code }}">{{
                                                        $language->language_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <button type="submit" id="save-form" class="btn btn-success"> <i
                                            class="fa fa-check"></i> @lang('app.save')</button>

                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                </div>
            </div>
        </div> <!-- .row -->
        {{-- Ajax Modal--}}
        <div class="modal fade bs-modal-md in" id="clientCategoryModal" role="dialog" aria-labelledby="myModalLabel"
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
        {{-- Ajax Modal Ends--}}
        @endsection

        @push('footer-script')
        <script src="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
        <script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
        <script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
        <script src="{{ asset('plugins/bower_components/summernote/dist/summernote.min.js') }}"></script>

        <script>
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

    $("#date_of_birth, #end_date, #date_of_subscription, #date_of_last_payment, .date-picker ,#last_paid_fiscal_year,#date_of_the_board_of_directors").datepicker({
        todayHighlight: true,
        autoclose: true,
        weekStart:'{{ $global->week_start }}',
        format: '{{ $global->date_picker_format }}',

         //rola 
        // so datepicker cant  pick date in the future
        // hideIfNoPrevNext: true,
        //  maxDate function is used to disable future dates.
        // maxDate: $.datepicker("getDate"), gave error
        maxDate:new Date(),

        // if i set the language to araibc or english
        language: '{{ $global->locale }}',
    });

    $(".select2").select2({
        formatNoMatches: function () {
            return "{{  ('messages.noRecordFound') }}";
        }
    });
    $(".date-picker").datepicker({
        todayHighlight: true,
        autoclose: true,
        weekStart:'{{ $global->week_start }}',
        format: '{{ $global->date_picker_format }}',

        //rola 
        // so datepicker cant  pick date in the future
        maxDate: new Date(),
        // if i set the language to araibc or english
        language: '{{ $global->locale }}',
    });

    $('#save-form').click(function () {
        $.easyAjax({
            url: '{{route('admin.members.store')}}',
            container: '#createClient',
            type: "POST",
            redirect: true,
            file: (document.getElementById("image").files.length == 0) ? false : true,
            data: $('#createClient').serialize()
        })
    });

    $('.summernote').summernote({
        height: 200,                 // set editor height
        minHeight: null,             // set minimum height of editor
        maxHeight: null,             // set maximum height of editor
        focus: false,
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough']],
            ['fontsize', ['fontsize']],
            ['para', ['ul', 'ol', 'paragraph']],
            ["view", ["fullscreen"]]
        ]
    });
    $('#addClientCategory').click(function () {
        var url = '{{ route('admin.memberCategory.create')}}';
        $('#modelHeading').html('...');
        $.ajaxModal('#clientCategoryModal', url);
    })

    $('#relations').click(function () {
        var url = '{{ route('admin.memberRelation.create')}}';
        $('#modelHeading').html('...');
        $.ajaxModal('#clientCategoryModal', url);
    })
    $('#status').click(function () {
        var url = '{{ route('admin.memberStatus.create')}}';
        $('#modelHeading').html('...');
        $.ajaxModal('#clientCategoryModal', url);
    })

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
    $(document).ready(function(){
  $('#password').live("paste",function(e) {
      e.preventDefault();
  });
}); 
        </script>
        @endpush