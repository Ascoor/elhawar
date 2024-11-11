<link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title"><i class="icon-pencil"></i> @lang('app.edit') @lang('app.menu.leaves')</h4>
</div>
<div class="modal-body">
    {!! Form::open(['id'=>'createLeave','class'=>'ajax-form','method'=>'GET']) !!}
    <div class="form-body">

{{--        <div class="row">--}}

{{--            <div class="col-md-12 ">--}}
{{--                <div class="form-group">--}}
{{--                    <label class="control-label">@lang('modules.members.penalty_type')</label>--}}
{{--                    <select class="select2 form-control" data-placeholder="@lang('modules.members.penalty_type')" id="penalty_type">--}}
{{--                        <option value="">--</option>--}}
{{--                        <option value="@lang('modules.members.suspend_membership')">@lang('modules.members.suspend_membership')</option>--}}
{{--                        <option value="@lang('modules.members.financial_penalty')">@lang('modules.members.financial_penalty')</option>--}}

{{--                    </select>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--        </div>--}}
        <div class="row">
            <div class="col-xs-6">
                <div class="radio radio-info">
                    <input id="suspend_membership" name="penalty_type" value="@lang('modules.members.suspend_membership')"
                           type="radio" {{$penalty->penalty_name == __('modules.members.suspend_membership') ? 'checked' : ''}} >
                    <label for="suspend_membership">@lang('modules.members.suspend_membership')</label>
                </div>
            </div>
            <div class="col-xs-6">
                <div class="radio radio-info">
                    <input id="financial_penalty" name="penalty_type" value="@lang('modules.members.financial_penalty')"
                           type="radio" {{$penalty->penalty_name == __('modules.members.financial_penalty') ? 'checked' : ''}}>
                    <label for="financial_penalty">@lang('modules.members.financial_penalty')</label>
                </div>
            </div>
        </div>
        <div class="row" id="f_member_fields" style=" display:{{$penalty->penalty_name == __('modules.members.suspend_membership') ? 'none' : ''}}  " >
            <div class="col-xs-6 col-md-3">
                <div class="form-group">
                    <label>@lang('modules.members.amount')</label>
                    <input type="text" id="amount" name="amount" class="form-control"   value="{{$penalty->amount ? $penalty->amount : ''}}">
                </div>
            </div>
            <div class="col-md-3 ">
                <div class="form-group salutation">
                    <label for="">@lang('app.currency')

                    </label>
                    <select name="currency" id="currency" data-placeholder="@lang('app.currency')" class="form-control select2 " >
                        <option id="empty" value="">@lang('--')</option>
                        @foreach($currencies as $currency)
                            <option value="{{ $currency->currency_code }}" {{$penalty->currency== $currency->currency_code ? 'selected' : ''}}>{{ ucwords($currency->currency_code) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <!--/row-->


        <div class="row">
            <div class="col-xs-12">
                <label>@lang('app.details')</label>
                <div class="form-group">
                    <textarea name="details" id="details" class="form-control" cols="30" rows="5">{!! $penalty->details !!}</textarea>
                </div>
            </div>

            <div class="col-xs-12">
                <label>@lang('app.status')</label>
                <div class="form-group">
                    <select class="form-control" data-style="form-control" name="status" id="status" >
                        <option
                                @if($penalty->status == 'approved') selected @endif
                        value="approved">Approved</option>
                        <option
                                @if($penalty->status == 'pending') selected @endif
                        value="pending">Pending</option>
                        <option
                                @if($penalty->status == 'rejected') selected @endif
                        value="rejected">Rejected</option>
                    </select>
                </div>
            </div>

        </div>


    </div>
    {!! Form::close() !!}

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-white waves-effect" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-success save-leave waves-effect waves-light">@lang('app.update')</button>
</div>

<script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script>

    $("#createLeave .select2").select2({
        formatNoMatches: function () {
            return "{{ __('messages.noRecordFound') }}";
        }
    });





    $('.save-leave').click(function () {
        $.easyAjax({
            url: '{{route('admin.members.update-penalty', $penalty->id)}}',
            container: '#createLeave',
            type: "GET",
            redirect: true,
            data: $('#createLeave').serialize()
        })
    });

    $('#suspend_membership').change(function () {
        if($(this).is(':checked')){

            $('#f_member_fields').hide();
            $('#amount').prop("value" , "");
            $('#currency').prop("value" , "");
            $('#empty').prop('selected', true);

        }
        // else{
        //     $('#f_member_fields').prop("name" , "session_id");
        // }
    })
    $('#financial_penalty').change(function () {
        if($(this).is(':checked')){
            $('#f_member_fields').show();
            // $('#user_id').prop("name" , "user_id");
        }
    })
</script>