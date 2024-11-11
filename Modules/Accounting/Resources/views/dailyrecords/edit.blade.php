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
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href = "https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.2/themes/smoothness/jquery-ui.min.css" rel = "stylesheet">

    
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

@if(session()->get('success'))
<div class="alert alert-success">
  {{ session()->get('success') }}
</div><br />
@endif

<form method="post" action="{{ route('admin.accounting.dailyrecords.update',[$viewData['type'],$record->id]) }}">


    @csrf
    @method('PUT')

    <div class="row">



        @if (App::isLocale('en'))
        <div class="form-group mb-2 col-sm-6" {{__('accounting::modules.accounting.rtl')}}>
            <label for="journalEntryNo">{{__('accounting::modules.accounting.journalEntryNo')}}</label>
            <input type="text" class="form-control" id='journalEntryNo'  style="direction:ltr;text-align: center;" name="journalEntryNo" value="{{$record->journalEntryNo}}"  disabled/>
        </div>
        <div class="form-group mb-2 col-sm-6" {{__('accounting::modules.accounting.rtl')}}>
            <label for="date">{{__('accounting::modules.accounting.date')}}</label>
            <input type="text" class="form-control" id="datepicker" value="{{$record->date}}" {{__('accounting::modules.accounting.rtl')}} disabled/>
        </div>
    @else
        <div class="form-group mb-2 col-sm-6" {{__('accounting::modules.accounting.rtl')}}>
            <label for="date">{{__('accounting::modules.accounting.date')}}</label>
            <input type="text" class="form-control" id="datepicker" value="{{$record->date}}"   {{__('accounting::modules.accounting.rtl')}} disabled/>
        </div>
        <div class="form-group mb-2 col-sm-6" {{__('accounting::modules.accounting.rtl')}}>
            <label for="journalEntryNo">{{__('accounting::modules.accounting.journalEntryNo')}}</label>
            <input type="text" class="form-control" id='journalEntryNo'  style="direction:ltr;text-align: center;"  name="journalEntryNo" value="{{$record->journalEntryNo}}"  disabled/>
        </div>
    @endif

    </div>

    <style>
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
/* Firefox */
input[type=number],#totalCredit,#totalDebt,#total {
  -moz-appearance: textfield;
  font-size: 1.2em;
  width: auto;
  width: 100%;
  font-weight: bold;
}
.DRTbl
{
    text-align: center!important;
    border:1px solid #999!important;
}

.DRTbl thead tr th
{
    text-align: center!important;
    border:1px solid #999!important;
}

.DRTbl tbody tr td 
{
    text-align: center!important;
    border:1px solid #999!important;
}
</style>


<div class='table-responsive'>

    <table class='table'>
        <tbody>
        <tr>
            <td colspan="5">

                <table class='table table-bordered DRTbl' {{__('accounting::modules.accounting.rtl')}}>
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
                                <i class="btn btn-sm btn-success fa fa-plus-circle" onclick='addRow("D")' aria-hidden="true"></i>
                            </th>
                        </tr>
                    </thead>
                    <tbody id='debitRows'>

                        @php
                            $i=1;
                        @endphp
                        @foreach ($record->entries->where('type','=','DEBIT') as $entry)
                                <tr id='DR{{$i}}'>
                                    <td class='DRIndex'>
                                        <br>
                                        {{$i}}
                                    </td>        
                                    <td><br><input type="number" class="form-control" step="0.01"  name='oldDebitAmounts[]' onkeyup="updateEntry(this)" value="{{$entry->amount}}" required/></td>

                                    <td>
                                        <input type="hidden" name='oldDebitEntries[]' value="{{$entry->id}}">
                                        {{__('accounting::modules.accounting.fromStatment')}} :
                                        <input type='text' class='form-control'  value='{{$entry->code->code}} - {{$entry->code->breadcrumb}}' disabled> 
                                </td>
                                    <td>
                                        <input type="hidden" name='oldDebitDates[]' value='{{$entry->payment_date??$entry->dailyRecord->date}}' class="payment-date">
                                        <button class='btn btn-danger' type="button" onclick='delRow("DR{{$i}}")'><i class="fa fa-trash" aria-hidden="true"  ></i></button>
                                    </td>
                                </tr>

                            @php
                                    $i++;
                            @endphp
                        @endForeach

                        @php
                                unset($i);
                        @endphp

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
                <table class='table table-bordered DRTbl'{{__('accounting::modules.accounting.rtl')}}>
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
                                <i class="btn btn-sm btn-success fa fa-plus-circle" onclick='addRow("C")' aria-hidden="true"></i>
                            </th>
                        </tr>
                    </thead>
                    <tbody id='creditorRows'>
                        @php
                            $i=1;
                        @endphp
                        @foreach ($record->entries->where('type','=','CREDIT') as $entry)
                                <tr id='CR{{$i}}'>
                                    <td class='CRIndex'>
                                        <br>
                                        {{$i}}
                                    </td>        
                                    <td><br><input type="number" class="form-control" step="0.01" name='oldCreditorAmounts[]' onkeyup="updateEntry(this)" value="{{$entry->amount}}" required/></td>

                                    <td>
                                    
                                        <input type="hidden" name='oldCreditorEntries[]' value="{{$entry->id}}">
                                        {{__('accounting::modules.accounting.toStatment')}} :
                                        <input type='text' class='form-control'  value='{{$entry->code->code}} - {{$entry->code->breadcrumb}}' disabled> 
                                </td>
                                    <td>
                                        <input type="hidden" name='oldCreditorDates[]' value="{{$entry->payment_date??$entry->dailyRecord->date}}" class="payment-date">
                                        <button class='btn btn-danger' type="button" onclick='delRow("CR{{$i}}")'><i class="fa fa-trash" aria-hidden="true"  ></i></button></td>
                                </tr>


                            @php
                                    $i++;
                            @endphp
                        @endForeach

                        @php
                                unset($i);
                        @endphp
                        
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


            <tr {{__('accounting::modules.accounting.rtl')}}><td colspan="5">   <div class="form-group mb-2">
                <label>{{__('accounting::modules.accounting.description')}}</label>
                <textarea class="form-control" name="description"  style="resize: none"  rows="4">{{old('description')??$record->description}}</textarea>
                </div></td></tr>


                <tr {{__('accounting::modules.accounting.rtl')}}>
                    <td colspan="5">
                        <table style="width:100%">
                            <tbody>
                            <tr>
                                <td style="padding:5px;width:10%"> {{__('accounting::modules.accounting.totalDebit')}} </td>
                                <td ><input id='totalDebt' class='form-control' value='{{$record->dept}}' disabled></td>
                                <td style="padding:5px;width:10%"> {{__('accounting::modules.accounting.totalCreditor')}} </td>
                                <td><input id='totalCredit' class='form-control' value='{{$record->credit}}' disabled></td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>

                <tr {{__('accounting::modules.accounting.rtl')}}>
                    @if (App::isLocale('en'))
                        <td colspan="1">{{__('accounting::modules.accounting.total')}}</td>
                        <td colspan="4"><input id='total' class='form-control' value='{{($record->total)}}' disabled></td>
                    @else
                         <td colspan="4"><input id='total' class='form-control' value='{{($record->total)}}' disabled></td>
                        <td colspan="1">{{__('accounting::modules.accounting.total')}}</td>
                    @endif

                </tr>
        </tfoot>

    </table>



</div>




                                    
    

    <button type="submit" class="btn btn-primary mb-5"><i class="fa fa-edit" aria-hidden="true"></i> {{__('accounting::modules.accounting.submit')}}</button>

</form>

</div>
</div>
</div>
@endsection

@include('accounting::dailyrecords.cufootscripts')