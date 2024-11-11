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
                <div class="panel-heading"> @lang('app.menu.create_employee_assessment')</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        {!! Form::open(['id'=>'createAssessment','class'=>'ajax-form','method'=>'POST']) !!}
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6" id="assessment_name">
                                    <div class="form-group">
                                        <label class="required">@lang('app.menu.assessment') @lang('app.name')</label>
                                        <input type="text" name="ass_name"  class="form-control" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="required">@lang('app.select') @lang('app.employee') </label>
                                        <select name="user_id" id="user_id" class="form-control">
                                            <option value="">--</option>
                                            @foreach($employees as $employee)
                                                <option value="{{ $employee->id }}">{{ ucwords($employee->name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
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
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>@lang('app.menu.assessment')</label>
                                                    <input type="number" name="assessment_value[]" class="form-control" autocomplete="nope" value="{{(int)($setting->ass_val)}}"
                                                           max="{{(int)($setting->ass_val)}}"
                                                           onchange="findTotal()"
                                                           onkeyup="if(this.value >{{(int)($setting->ass_val)}}) this.value = {{(int)($setting->ass_val)}};">
                                                    <input type="hidden" name="assessment_value_hidden[]"  class="form-control total" autocomplete="nope" value="{{$setting->ass_val}}">
                                                </div>
                                            </div>
                                            <div class="col-md-4" style="text-align: center">
                                                <div class="form-group">
                                                    <label>@lang('app.menu.final_degree')</label><br>
                                                    <label>{{(int)($setting->ass_val)}}</label>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="">@lang('app.total') @lang('app.menu.assessment')</label><br>
                                        <label for="" id="total_ass">--</label>
                                    </div>
                                    <div class="col-md-4" style="text-align: center">
                                        <label for="">@lang('app.total') @lang('app.menu.final_degree')</label><br>
                                        <label for="" id="total">--</label>
                                    </div>
                                    <div class="col-md-4" style="text-align: center">
                                        <label for="">@lang('app.menu.total_assessment_percentage')</label><br>
                                        <label for="" id="perc">100%</label>
                                        <input type="hidden" id="perc_input" name="perc_input" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="price_description">@lang('app.menu.direct_manager_opinion')</label>
                                <textarea class="form-control" id="direct_manager_opinion" rows="5"
                                          name="direct_manager_opinion"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="price_description">@lang('app.menu.club_manager_opinion')</label>
                                <textarea class="form-control" id="club_manager_opinion" rows="5"
                                          name="club_manager_opinion" disabled></textarea>
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

        function findTotal(){
            var arr = document.getElementsByName('assessment_value_hidden[]');
            var tot=0;
            for(var i=0;i<arr.length;i++){
                if(parseInt(arr[i].value))
                    tot += parseInt(arr[i].value);
            }
            document.getElementById('total').innerHTML = tot;
            var arrass = document.getElementsByName('assessment_value[]');
            var totass=0;
            for(var i=0;i<arrass.length;i++){
                if(parseInt(arrass[i].value))
                    totass += parseInt(arrass[i].value);
            }
            document.getElementById('total_ass').innerHTML = totass;
            document.getElementById('perc').innerHTML = (parseFloat(totass/tot).toFixed(2) *100)+'%';
            document.getElementById('perc_input').value = parseInt(parseFloat(totass/tot)*100);
        }

        $('#save-form').click(function () {
            $.easyAjax({
                url: '{{route('admin.employees.assessments.store')}}',
                container: '#createAssessment',
                type: "POST",
                redirect: true,
                data: $('#createAssessment').serialize()
            })
        });
    </script>
@endpush

