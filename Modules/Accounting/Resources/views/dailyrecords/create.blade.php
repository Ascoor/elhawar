@extends('layouts.app')
@section('page-title')
<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12" style="width: fit-content">
        <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ $pageTitle }}</h4>
    </div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}">@lang('app.menu.home')</a></li>
            <li class="active">{{ $pageTitle }}</li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>
@endsection

@push('head-script')
<!-- Data table -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">

<!-- Select 2-->
{{--
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}

{{-- rola added select2 css --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />

{{--
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
    integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}


<link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.2/themes/smoothness/jquery-ui.min.css"
    rel="stylesheet">

{{--
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> --}}

@endpush

@section('content')

<div class="row">

    <div class="col-md-12">
        <div class="white-box">


            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div><br />
            @endif



            <style>
                /* Chrome, Safari, Edge, Opera */
                input::-webkit-outer-spin-button,
                input::-webkit-inner-spin-button {
                    -webkit-appearance: none;
                    margin: 0;
                }

                /* Firefox */
                input[type=number],
                #totalCredit,
                #totalDebt,
                #total {
                    -moz-appearance: textfield;
                    font-size: 1.2em;
                    width: auto;
                    width: 100%;
                    font-weight: bold;
                }


                .DRTbl {
                    text-align: center !important;
                    border: 1px solid #999 !important;
                }

                .DRTbl thead tr th {
                    text-align: center !important;
                    border: 1px solid #999 !important;
                }

                .DRTbl tbody tr td {
                    text-align: center !important;
                    border: 1px solid #999 !important;
                }
            </style>

            <form method="post" action="{{ route('admin.accounting.dailyrecords.store',$viewData['type']) }}">
                @csrf
                <div class="form-group mb-2" {{__('accounting::modules.accounting.rtl')}}>
                    <label for="date">{{__('accounting::modules.accounting.date')}}</label>
                    <input type="text" class="form-control" id="datepicker" autocomplete="none" name="date"
                        value="{{old('date')??date('Y-m-d')}}"
                        placeholder="{{__('accounting::modules.accounting.date')}}" max="{{date('Y-m-d')}}" required />
                </div>

                <div class='table-responsive'>

                    <table class='table'>
                        <tbody>


                            <tr>

                                <td colspan="5">

                                    <table class='table table-bordered DRTbl'
                                        {{__('accounting::modules.accounting.rtl')}}>
                                        <thead>
                                            <tr>
                                                <th style="width: 5%" class='text-center'>
                                                    #
                                                </th>
                                                <th style="width: 20%" class='text-center'>
                                                    {{__('accounting::modules.accounting.amount')}}
                                                </th>
                                                <th style="width: 70%" class='text-center'>
                                                    {{__('accounting::modules.accounting.statement')}}
                                                </th>
                                                <th style="width: 5%" class='text-center'>
                                                    <i class="btn btn-sm btn-success fa fa-plus-circle"
                                                        onclick='addRow("D")' aria-hidden="true"></i>
                                                </th>

                                            </tr>
                                        </thead>
                                        <tbody id='debitRows'>
                                            <tr id='DR1'>
                                                <td class='DRIndex'>
                                                    1
                                                </td>
                                                <td>
                                                    <input class='form-control' onkeyup="updateEntry(this)"
                                                        type='number' step="0.01" name='debitAmounts[]' value='0'
                                                        required />
                                                </td>
                                                <td>
                                                    {{__('accounting::modules.accounting.fromStatment')}} :
                                                    <select class='DSelCode form-select ' style='width:90%' id='DC1'
                                                        name='debitCodes[]' {{__('accounting::modules.accounting.rtl')}}
                                                        required>
                                                        <option value='' disabled>
                                                            {{__('accounting::modules.accounting.code')}}</option>
                                                    </select>
                                                </td>
                                                {{-- <td>
                                                    <select class='DSelCode form-select ' style='width:90%' id='DC1'
                                                        required>
                                                        <option value='1'>okkk1</option>
                                                        <option value='2'>okkk2</option>
                                                        <option value='3'>okkk3</option>
                                                    </select>
                                                </td> --}}
                                                <td>
                                                    <input type="hidden" name='debitDates[]' value='-1'
                                                        class="payment-date">
                                                    <i class="btn btn-sm btn-danger fa fa-trash"
                                                        onClick="delRow(this.parentElement.parentElement.id)"
                                                        aria-hidden="true" style="margin:2px"></i>
                                                </td>
                                            </tr>
                                        </tbody>

                                    </table>

                                </td>
                            </tr>

                            <tr>
                                @if (App::isLocale('en'))
                                <td colspan="2" style="width:15%">
                                </td>
                                @endif


                                <td colspan="3" style="width:70%">
                                    <table class='table table-bordered DRTbl'
                                        {{__('accounting::modules.accounting.rtl')}}>
                                        <thead class='text-center'>
                                            <tr>
                                                <th style="width: 5%" class='text-center'>
                                                    #
                                                </th>
                                                <th style="width: 22%" class='text-center'>
                                                    {{__('accounting::modules.accounting.amount')}}
                                                </th>
                                                <th style="width: 68%" class='text-center'>
                                                    {{__('accounting::modules.accounting.statement')}}
                                                </th>
                                                <th style="width: 5%" class='text-center'>
                                                    <i class="btn btn-sm btn-success fa fa-plus-circle"
                                                        onclick='addRow("C")' aria-hidden="true"></i>
                                                </th>

                                            </tr>
                                        </thead>
                                        <tbody id='creditorRows'>
                                            <tr id='CR1'>
                                                <td class='CRIndex'>
                                                    1
                                                </td>
                                                <td>
                                                    <input class='form-control' onkeyup="updateEntry(this)" step="0.01"
                                                        type='number' name='creditorAmounts[]' value='0' required />
                                                </td>
                                                <td>
                                                    {{__('accounting::modules.accounting.toStatment')}} :
                                                    <select class='CSelCode form-select ' style='width:90%' id='CC1'
                                                        name='creditorCodes[]' required>
                                                        <option value='' disabled>
                                                            {{__('accounting::modules.accounting.code')}}</option>
                                                    </select>
                                                </td>
                                                {{-- <td>

                                                    <select class='CSelCode form-select ' style='width:90%' id='CC1'
                                                        required>
                                                        <option value='ok'>no1</option>
                                                        <option value='ok'>no2</option>
                                                        <option value='ok'>no3</option>
                                                    </select>
                                                </td> --}}
                                                <td>
                                                    <input type="hidden" name='creditorDates[]' value='-1'
                                                        class="payment-date">
                                                    <i class="btn btn-sm btn-danger fa fa-trash"
                                                        onClick="delRow(this.parentElement.parentElement.id)"
                                                        aria-hidden="true" style="margin:2px"></i>
                                                </td>

                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                @if (App::isLocale('ar'))
                                <td colspan="2" style="width:15%">
                                </td>
                                @endif




                            </tr>


                        </tbody>
                        <tfoot>


                            <tr {{__('accounting::modules.accounting.rtl')}}>
                                <td colspan="5">
                                    <div class="form-group mb-2">
                                        <label>{{__('accounting::modules.accounting.description')}}</label>
                                        <textarea class="form-control" name="description" style="resize: none"
                                            rows="4">{{old('description')}}</textarea>
                                    </div>
                                </td>
                            </tr>

                            <tr {{__('accounting::modules.accounting.rtl')}}>
                                <td colspan="5">
                                    <table style="width:100%">
                                        <tbody>
                                            <tr>
                                                <td style="padding:5px;width:10%">
                                                    {{__('accounting::modules.accounting.totalDebit')}} </td>
                                                <td><input id='totalDebt' class='form-control' value='0' disabled></td>
                                                <td style="padding:5px;width:10%">
                                                    {{__('accounting::modules.accounting.totalCreditor')}} </td>
                                                <td><input id='totalCredit' class='form-control' value='0' disabled>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>

                            <tr {{__('accounting::modules.accounting.rtl')}}>
                                @if (App::isLocale('en'))
                                <td colspan="1">{{__('accounting::modules.accounting.total')}}</td>
                                <td colspan="4"><input id='total' class='form-control' value='0' disabled></td>
                                @else
                                <td colspan="4"><input id='total' class='form-control' value='0' disabled></td>
                                <td colspan="1">{{__('accounting::modules.accounting.total')}}</td>
                                @endif

                            </tr>
                        </tfoot>

                    </table>



                </div>

                {{-- rola --}}
                <div style="display: flex">


                    <button type="submit" class="btn btn-primary mb-5"><i class="fa fa-plus-circle"
                            aria-hidden="true"></i> {{__('accounting::modules.accounting.submit')}}</button>

                    <div class='m-l-5'>
                        <input type='hidden' name='created_rec_employee_id' value='{{ Auth::user()->id }}' />
                        <div> <small id="helpId"
                                class="form-text text-muted">@lang('accounting::modules.accounting.Created_record_by_id'):
                                <span style="color:black"> {{ Auth::user()->id }}</span> </small></div>
                        <div> <small id="helpId"
                                class="form-text text-muted">@lang('accounting::modules.accounting.Created_record_by_employee'):
                                <span style="color:black"> {{ Auth::user()->name }}</span> </small></div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
@include('accounting::dailyrecords.cufootscripts')