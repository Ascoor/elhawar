<style>
    #members .select2-container{
        width: 537px !important;
    }
</style>
<div >
    <h3 class="box-title ">@lang('app.select') @lang('modules.members.user')</h3>
    <hr>
    {{--                            radio user select     --}}
    <div class="row">
        <div class="col-xs-6 col-md-3">
            <div class="radio radio-info">
                <input id="clients_butt" name="user" value=""
                       type="radio" >
                <label for="clients_butt">@lang('app.clients')</label>
            </div>
        </div>
        <div class="col-xs-6 col-md-3">
            <div class="radio radio-info">
                <input id="members_butt" name="user" value=""
                       type="radio"checked="checked">
                <label for="members_butt">@lang('app.menu.members')</label>
            </div>
        </div>
    </div>
    {{--                     /    radio user select     --}}
    <div class="row">
        <div class="col-md-12" id="clients" style="display: none" >
                <div class="form-group">
                    <label class="control-label" id="companyClientName">@lang('app.client_name') </label>
                    <div class="row">
                        <div id="client_company_div">
                            <div class="input-icon">
                                <input type="text" readonly class="form-control" name="" id="company_name" value="">
                            </div>
                        </div>
                    </div>
                </div>
        </div>

        <div class="col-md-6"  id="members">
            <div class="form-group" >
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div>
                                <label >@lang('app.member_id') </label>
                            </div>
                            <select id="selectMember"  name="" class="select2 form-control" >
                            </select>
                        </div>


                    </div>
                    @if($displayCategory === 'true')
                        <div class="col-md-6">
                            <div class="form-group">
                            <label>@lang('app.category')</label>
                            <select class="form-control" name="category_id" id="category_id">
                                <option value="">--</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{ ucwords($category->category_name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        </div>
                    @endif
                </div>

            </div>

        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        getCompanyName();
        // $('#members').hide();

        $('#clients_butt').change(function () {
            if($(this).is(':checked')){
                $('#clients').show();
                $('#members').hide();
                $('#suspendMembershipDiv').hide();
                $('#employee_id').prop("name" , "");
                $('#selectMember').prop("name" , "");
                $('#client_company_id').prop("name" , "user_id");
            }
            // else{
            //     $('#related_fields').hide();
            //     $('#new_session_id').prop("name" , "session_id");
            // }
        })
        $('#members_butt').change(function () {
            if($(this).is(':checked')){

                $('#members').show();
                $('#suspendMembershipDiv').show();
                $('#clients').hide();
                $('#employee_id').prop("name" , "");
                $('#client_company_id').prop("name" , "");
                $('#selectMember').prop("name" , "user_id");
            }
            // else{
            //     $('#related_fields').hide();
            //     $('#new_session_id').prop("name" , "session_id");
            // }
        })

        $("#selectMember").select2({
            templateResult: function(data) {
            }
        }).on('select2:open', function (event) {

            $('span.select2-container--open').attr('id', 'member-box');
        });

        function handler(event){
            var target = $(event.target);
            console.log(target.parents('span#member-box').length);
            if(target.parents('span#member-box').length ){

                if(event.target.value.length >= 1){
                    url = "{{ route('admin.members.search-member',':key') }}";
                    let key = event.target.value;
                    url = url.replace(':key',key);
                    console.log(url, key);

                    // $('#selectMember').select2({
                    //     url: url,
                    //     type: 'GET',
                    //     processResults: function (response) {
                    //         console.log("RESPONSE");
                    //         return {
                    //             results: response
                    //         };
                    //     }
                    // })
                    $.ajax({
                        type: 'GET',
                        url: url,
                        success: function (data) {
                            console.log('DATA: ', data);
                            // $('#selectMember').val([]);
                            $('#selectMember').select2(data, null);
                            for (option of data){
                                if ($('#selectMember').find("option[value='" + option.id + "']").length) {
                                    $('#selectMember').val(option.user_id).trigger('change');
                                } else {
                                    // Create a DOM Option and pre-select by default
                                    var newOption = new Option(option.name + ' (' + option.member_id + ')', option.user_id, true, true);
                                    // Append it to the select
                                    $('#selectMember').append(newOption).trigger('change');
                                }
                            }
                        }
                    });
                }
                else {
                    $('#selectMember').val(null).trigger('change');
                }
            }

        }
        document.addEventListener('keyup', handler, true);
        
        function getCompanyName(){
            var projectID = $('#project_id').val();
            var url = "{{ route('admin.all-invoices.get-client-company') }}";
            if(projectID != '' && projectID !== undefined )
            {
                url = "{{ route('admin.all-invoices.get-client-company',':id') }}";
                url = url.replace(':id', projectID);
            }
            $.ajax({
                type: 'GET',
                url: url,
                success: function (data) {
                    if(projectID != '')
                    {
                        $('#companyClientName').text('{{ __('app.client_name') }}');
                    } else {
                        $('#companyClientName').text('{{ __('app.client_name') }}');
                    }
                    console.log($('#show_shipping_address'))
                    $('#client_company_div').html(data.html);

                    if ($('#show_shipping_address') && $('#show_shipping_address').prop('checked') === true) {
                        checkShippingAddress();
                    }
                    $('#client_company_id').attr('name',"user_id")
                }
            });
        }

    })


</script>
