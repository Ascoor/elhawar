@extends('layouts.app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 bg-title-left">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __('app.menu.players') }}</h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12 bg-title-right">
            <ol class="breadcrumb">

            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection

@push('head-script')
{{--    <link rel="stylesheet" href="{{ asset('public/plugins/metronics/wizard-4.css') }}">--}}

<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/summernote/dist/summernote.css') }}">
<style>
 .salutation .form-control {
     padding: 2px 2px;
   }
  .select-category button{
    background-color: white !important;
    font-size: 13px;
    color: #565656;
    border: 1px solid #e4e7ea !important;
   }
   .select-category button:hover{
    color: #565656;
    opacity: 1;
   }

   .bootstrap-select .dropdown-toggle:focus{
    outline: none !important;
   }
</style>

@endpush

@section('content')

    <div class="row">
        <div class="col-xs-12">

            <div class="panel panel-inverse">
                <div class="panel-heading"> @lang('app.menu.create_player')</div>
                    <div class="panel-wrapper collapse in" aria-expanded="true">
                        <div class="panel-body">
                            {!! Form::open(['id'=>'createClient','class'=>'ajax-form','method'=>'POST']) !!}
                                <input type="hidden" name="player" value="1">
                                <div class="form-body">
                                    <h3 class="box-title ">@lang('modules.members.playerDetails')</h3>
                                    <hr>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {{-- <label for="family_id" class="required">@lang('app.family_id')</label> --}}
                                            <label for="player_id" class="required">@lang('app.menu.player_id')</label>
                                            <input type="text" id="player_id" name="player_id" class="form-control" {{$player_id
                                                ? 'readonly' : '' }} value="{{$player_id ?? ''}}" >
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {{-- <label for="family_id" class="required">@lang('app.family_id')</label> --}}
                                            <label for="family_id" class="">@lang('app.menu.union_id') </label>
                                            <input type="text" id="union_id" name="union_id" class="form-control"  >
                                            
                                        </div>
                                    </div>
                                    <div class="row">
                                        
                                        <div class="col-md-1 ">
                                            <div class="form-group salutation" style="margin-top: 23px">
                                                <select name="salutation" id="salutation" class="form-control">
                                                    <option value="">--</option>
                                                    <option @if(isset($firstName) && $firstName == 'mr' ) selected @endif  value="mr">@lang('app.mr')</option>
                                                    <option @if(isset($firstName) && $firstName == 'mrs' ) selected @endif value="mrs">@lang('app.mrs')</option>
                                                    <option @if(isset($firstName) && $firstName == 'miss' ) selected @endif value="miss">@lang('app.miss')</option>
                                                    <option @if(isset($firstName) && $firstName == 'dr' ) selected @endif value="dr">@lang('app.dr')</option>
                                                    <option @if(isset($firstName) && $firstName == 'sir' ) selected @endif value="sir">@lang('app.sir')</option>
                                                    <option @if(isset($firstName) && $firstName == 'madam' ) selected @endif value="madam">@lang('app.madam')</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 ">
                                            <div class="form-group">
                                                {{-- <label class="required">@lang('modules.members.memberName')</label> --}}
                                                <label class="required"> @lang('app.menu.player_name')</label>
                                                <input type="text" name="name" id="name"  value=""   class="form-control"  autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="national_id" class="required">@lang('app.national_id')</label>
                                                <input type="text" id="national_id" name="national_id" class="form-control"   value="">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class=""> @lang('app.menu.sports')</label>

                                                {{-- <input type="text" id="atu_sport" name="atu_sport" class="form-control"   value=""> --}}
                                                <select class="select2 form-control client-category" data-placeholder="@lang('modules.club.team')"  id="team_id" name="sports_id">
                                                    <option>@lang('app.choose')</option>
                                                    @forelse($sports as $team)
                                                    <option value="{{ $team->id }}" >{{ ucwords($team->name) }}</option>

                                                    @empty
                                                        <option value="">@lang('modules.club.team')</option>
                                                    @endforelse

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class=""> @lang('app.menu.team')</label>

                                                {{-- <input type="text" id="atu_sport" name="atu_sport" class="form-control"   value=""> --}}
                                                <select class="select2 form-control client-category" data-placeholder="@lang('modules.club.team')"  id="team_id" name="academy_id">
                                                    <option>@lang('app.choose')</option>
                                                    @forelse($acdemy as $item)
                                                        <option value="{{ $item->id }}" >{{ ucwords($item->name) }}</option>
                                                    @empty
                                                        <option value="">@lang('modules.club.team')</option>
                                                    @endforelse

                                                </select>
                                            </div>
                                        </div>
                                    
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                {{-- <label for="">@lang('modules.club.team')</label> --}}
                                                <label for="">@lang('app.menu.team_age')</label>
                                                <select class="select2 form-control client-category" data-placeholder="@lang('modules.club.team')"  id="team_id" name="team_id">
                                                    <option>@lang('app.choose')</option>
                                                    @forelse($teams as $team)
                                                        <option value="{{ $team->id }}" >{{ ucwords($team->team_name) }}</option>
                                                        
                                                    @empty
                                                        <option value="">@lang('modules.club.team')</option>
                                                    @endforelse
                                                </select>
                                            </div>
                                        </div>

                            
                                        

                                    </div>
                                

                                    
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class=""> @lang('app.menu.Player_status')</label>
                        
                                                <select name="kind" id="kind" class="form-select form-control" aria-label="Default select example">
                                                    <option>@lang('app.choose')</option>
                                                    <option value="team">@lang('app.menu.team')</option>
                                                    <option value="single">@lang('app.menu.single')</option>
                                                </select>
                        
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="required">@lang('modules.employees.gender') </label>
                                                <select name="gender" id="gender" class="form-control">
                                                    <option value="male">@lang('app.male')</option>
                                                    <option value="female">@lang('app.female')</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="required">@lang('modules.members.BirthDate')</label>
                                                <input type="text" autocomplete="off"  name="date_of_birth" id="date_of_birth" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="required">@lang('app.menu.status_date')</label>
                                                <input type="text" autocomplete="off"  name="date_status" id="date_status" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-4 ">
                                            <div class="form-group">
                                                <label class="required">@lang('modules.members.age')</label>
                                                <input type="text" name="age" id="age" value="" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4 ">
                                            <div class="form-group">
                                                <label class="required">@lang('modules.stripeCustomerAddress.city')</label>
                                                <input type="text" name="city" id="city" value="{{ $leadDetail->city ?? '' }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="required" for="">@lang('modules.clients.country')</label>
                                                <select class="select2 form-control "  id="country_id" name="country_id">
                                                    <option selected value="{{ 63 }}">{{'Egypt'}}</option>
                                                    {{-- @foreach($countries as $country)
                                                        <option @if(isset($leadDetail->country) && $leadDetail->country == $country->nicename) selected @endif value="{{ $country->id }}">{{ $country->nicename }}</option>
                                                    @endforeach --}}
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                {{-- <label for="">@lang('modules.club.team')</label> --}}
                                                <label class="">@lang('app.menu.Player_status')</label>
                                                <select class="select2 form-control client-category" data-placeholder="@lang('modules.club.team')"  
                                                id="status_player" name="status_player">
                                                        <option>@lang('app.choose')</option>
                                                        <option value="moved">@lang('app.menu.moved_club')</option>
                                                        <option value="loan">@lang('app.menu.loan')</option>
                                                        <option value="sale">@lang('app.menu.sale')</option>


                                                </select>
                                            </div>
                                        </div>
                                    

                                    <div class="row">
                                        
                                    
                                        
                                        <div class="col-md-4 ">
                                            <div class="form-group">
                                                <label class="">@lang('app.menu.club_name')</label>
                                                <input type="text" name="club_name" id="club_name"  class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-4 ">
                                            <div class="form-group">
                                                <label class=""> @lang('app.menu.weight')</label>
                                                <input type="text" name="weight" id="weight"  class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4 ">
                                            <div class="form-group">
                                                <label class="">  @lang('app.menu.height')</label>
                                                <input type="text" name="height" id="height"  class="form-control">
                                            </div>
                                        </div>
                                        {{-- <div class="col-md-4 ">
                                            <div class="form-group">
                                                <label class="">Club name</label>
                                                <input type="text" name="club_name" id="club_name"  class="form-control">
                                            </div>
                                        </div> --}}


                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="">@lang('app.menu.levels')</label>
                                                <select class="select2 form-control client-category" data-placeholder="@lang('modules.club.team')"  
                                                id="level" name="level">
                                                        <option>@lang('app.choose')</option>
                                                        <option value="level 1">@lang('app.menu.level_1')</option>
                                                        <option value="level 2">@lang('app.menu.level_2')</option>
                                                        <option value="level 3">@lang('app.menu.level_3')</option>
                                                        <option value="level 4">@lang('app.menu.level_4')</option>
                                                        <option value="level 5">@lang('app.menu.level_5')</option>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4 ">
                                            <div class="form-group">
                                                <label class="">@lang('app.menu.belt') </label>
                                                <select class="select2 form-control client-category" data-placeholder="@lang('modules.club.team')"  
                                                id="belt" name="belt">
                                                        <option>@lang('app.choose')</option>
                                                        {{-- <option value="black_belt">@lang('app.menu.black_belt') </option> --}}
                                                        <option value="yellow_belt">@lang('app.menu.yellow_belt')</option>
                                                        <option value="orange_belt">@lang('app.menu.orange_belt')</option>
                                                        <option value="purple_belt">@lang('app.menu.purple_belt')</option>
                                                        <option value="blue_belt">@lang('app.menu.blue_belt')</option>
                                                        <option value="green_belt">@lang('app.menu.green_belt')</option>
                                                        <option value="brown_belt">@lang('app.menu.brown_belt')</option>
                                                        <option value="red_belt">@lang('app.menu.red_belt')</option>
                                                        <option value="black_belt">@lang('app.menu.black_belt')</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4 ">
                                            <div class="form-group">
                                                <label class="">@lang('app.menu.stars')</label>
                                                <select class="select2 form-control client-category" data-placeholder="@lang('modules.club.team')"  
                                                id="stars" name="stars">
                                                        <option>@lang('app.choose')</option>
                                                        <option value="Star 1">@lang('app.menu.star_1')</option>
                                                        <option value="Star 2">@lang('app.menu.star_2')</option>
                                                        <option value="Star 3">@lang('app.menu.star_3')</option>
                                                        <option value="Star 4">@lang('app.menu.star_4')</option>
                                                        <option value="Star 5">@lang('app.menu.star_5')</option>
                                                        <option value="Star 6">@lang('app.menu.star_6')</option>
                                                        <option value="Star 7">@lang('app.menu.star_7')</option>
                                                        <option value="Star 8">@lang('app.menu.star_8')</option>
                                                        <option value="Star 9">@lang('app.menu.star_9')</option>
                                                        <option value="Star 10">@lang('app.menu.star_10')</option>
                                                </select>
                                            </div>
                                        </div>

                                    
                                    
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                {{-- <label for="">@lang('modules.club.team')</label> --}}
                                                <label>@lang('app.menu.champions_award')</label>
                                                <select class="select2 form-control client-category" data-placeholder="@lang('modules.club.team')"  
                                                id="team_id" name="champions_award">
                                                        <option>@lang('app.choose')</option>
                                                        <option value="region"> @lang('app.menu.region')</option>
                                                        <option value="republic"> @lang('app.menu.republic')</option>
                                                        <option value="international"> @lang('app.menu.international')</option>

                                                </select>
                                            </div>
                                        </div>


                                    </div>

                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="form-group">
                                                    <label class="control-label required">@lang('app.address')</label>
                                                    <textarea name="address"  id="address"  rows="5"  class="form-control ">{{ $leadDetail->address ?? '' }}</textarea>
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
                                            <label class="required">@lang('app.mobile')</label>

                                            <div class="form-group">
                                                <select class="select2 phone_country_code form-control " name="phone_code">
                                                    <option selected value="{{ 63 }}">{{'+20(EG)'}}</option>
                                                    @foreach ($countries as $item)
                                                        <option @if (isset($code[0]) && $item->phonecode == $code[0])
                                                                selected
                                                                @endif value="{{ $item->id }}">+{{ $item->phonecode.' ('.$item->iso.')' }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="tel" name="mobile" id="mobile" class="mobile " autocomplete="nope" value="">
                                            </div>
                                        </div>

                                        <div class="col-md-3 ">
                                            {{-- <label class="required">@lang('app.mobile')</label> --}}
                                            <label class="required">@lang('app.menu.guardian_mobile')</label>
                                            <div class="form-group">
                                                <select class="select2 phone_country_code form-control " name="phone_code">
                                                    <option selected value="{{ 63 }}">{{'+20(EG)'}}</option>
                                                    @foreach ($countries as $item)
                                                        <option @if (isset($code[0]) && $item->phonecode == $code[0])
                                                                selected
                                                                @endif value="{{ $item->id }}">+{{ $item->phonecode.' ('.$item->iso.')' }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="tel" name="guardian_mobile" id="guardian_mobile" class="mobile " autocomplete="nope" value="">
                                            </div>
                                        </div>

                                    </div>
                                    <!--/row-->

                                    <div class="row">
                                        @if(isset($fields))
                                            @foreach($fields as $field)
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label @if($field->required == 'yes') class="required" @endif>{{ ucfirst($field->label) }}</label>
                                                        @if( $field->type == 'text')
                                                            <input type="text" name="custom_fields_data[{{$field->name.'_'.$field->id}}]" class="form-control" placeholder="{{$field->label}}" value="{{$editUser->custom_fields_data['field_'.$field->id] ?? ''}}">
                                                        @elseif($field->type == 'password')
                                                            <input type="password" name="custom_fields_data[{{$field->name.'_'.$field->id}}]" class="form-control" placeholder="{{$field->label}}" value="{{$editUser->custom_fields_data['field_'.$field->id] ?? ''}}">
                                                        @elseif($field->type == 'number')
                                                            <input type="number" name="custom_fields_data[{{$field->name.'_'.$field->id}}]" class="form-control" placeholder="{{$field->label}}" value="{{$editUser->custom_fields_data['field_'.$field->id] ?? ''}}">

                                                        @elseif($field->type == 'textarea')
                                                            <textarea name="custom_fields_data[{{$field->name.'_'.$field->id}}]" class="form-control" id="{{$field->name}}" cols="3">{{$editUser->custom_fields_data['field_'.$field->id] ?? ''}}</textarea>

                                                        @elseif($field->type == 'radio')
                                                            <div class="radio-list">
                                                                @foreach($field->values as $key=>$value)
                                                                    <label class="radio-inline @if($key == 0) p-0 @endif">
                                                                        <div class="radio radio-info">
                                                                            <input type="radio" name="custom_fields_data[{{$field->name.'_'.$field->id}}]" id="optionsRadios{{$key.$field->id}}" value="{{$value}}" @if(isset($clientDetail) && $clientDetail->custom_fields_data['field_'.$field->id] == $value) checked @elseif($key==0) checked @endif>>
                                                                            <label for="optionsRadios{{$key.$field->id}}">{{$value}}</label>
                                                                        </div>
                                                                    </label>
                                                                @endforeach
                                                            </div>
                                                        @elseif($field->type == 'select')
                                                            {!! Form::select('custom_fields_data['.$field->name.'_'.$field->id.']',
                                                                    $field->values,
                                                                    isset($editUser)?$editUser->custom_fields_data['field_'.$field->id]:'',['class' => 'form-control gender'])
                                                            !!}

                                                        @elseif($field->type == 'checkbox')
                                                        <div class="mt-checkbox-inline custom-checkbox checkbox-{{$field->id}}">
                                                            <input type="hidden" name="custom_fields_data[{{$field->name.'_'.$field->id}}]"
                                                            id="{{$field->name.'_'.$field->id}}" value=" ">
                                                            @foreach($field->values as $key => $value)
                                                                <label class="mt-checkbox mt-checkbox-outline">
                                                                    <input name="{{$field->name.'_'.$field->id}}[]"
                                                                        type="checkbox" onchange="checkboxChange('checkbox-{{$field->id}}', '{{$field->name.'_'.$field->id}}')" value="{{$value}}"> {{$value}}
                                                                    <span></span>
                                                                </label>
                                                            @endforeach
                                                        </div>
                                                        @elseif($field->type == 'date')
                                                            <input type="text" class="form-control form-control-inline date-picker" size="16" name="custom_fields_data[{{$field->name.'_'.$field->id}}]"
                                                                    value="{{ isset($editUser->dob)?Carbon\Carbon::parse($editUser->dob)->format('Y-m-d'):Carbon\Carbon::now()->format($global->date_format)}}">
                                                        @endif
                                                        <div class="form-control-focus"> </div>
                                                        <span class="help-block"></span>

                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif

                                    </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>@lang('modules.profile.profilePicture')</label>
                                                <div class="form-group">
                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                            <img src="https://via.placeholder.com/200x150.png?text={{ str_replace(' ', '+', __('modules.profile.uploadPicture')) }}"   alt=""/>
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
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <label>@lang('app.note')</label>
                                            <div class="form-group">
                                                <textarea name="note" id="note" class="form-control summernote" rows="5"></textarea>
                                            </div>
                                        </div>
                                    </div>

                            
                                </div>
                                <div class="form-actions">
                                    <button type="submit" id="save-form"  class="btn btn-success"> <i class="fa fa-check"></i> @lang('app.save')</button>

                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
         </div>
    </div>    <!-- .row -->
{{--    Ajax Modal--}}
    <div class="modal fade bs-modal-md in" id="clientCategoryModal" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-md" id="modal-data-application">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <span class="caption-subject font-red-sunglo bold uppercase" id="modelHeading"></span>
                </div>
                <div class="modal-body">
                    @lang('app.loading')
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
{{--    Ajax Modal Ends--}}
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

    $("#date_of_birth, #end_date, .date-picker").datepicker({
        todayHighlight: true,
        autoclose: true,
        weekStart:'{{ $global->week_start }}',
        format: '{{ $global->date_picker_format }}',
    });

    $("#date_status, #end_date, .date-picker").datepicker({
        todayHighlight: true,
        autoclose: true,
        weekStart:'{{ $global->week_start }}',
        format: '{{ $global->date_picker_format }}',
    });

    $(".select2").select2({
        formatNoMatches: function () {
            return "{{ __('messages.noRecordFound') }}";
        }
    });
    $(".date-picker").datepicker({
        todayHighlight: true,
        autoclose: true,
        weekStart:'{{ $global->week_start }}',
        format: '{{ $global->date_picker_format }}',
    });

    $('#save-form').click(function () {
        $.easyAjax({
            url: '{{route('admin.players.store')}}',
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
    $('#addClientSubCategory').click(function () {
        var url = '{{ route('admin.clientSubCategory.create')}}';
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
</script>
@endpush

