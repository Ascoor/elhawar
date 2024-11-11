@extends('layouts.app')
@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ $pageTitle }}</h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12" style="width: fit-content">
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}">@lang('app.menu.home')</a></li>
                <li class="active">{{ $pageTitle }}</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection
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



<form method="post" action="{{ route('admin.accounting.report.generate') }}"  class='text-center' onsubmit="injectData()">

    @csrf

    <div class='row'>
        <div class="form-group mb-2 col-6">
            <label for="date">{{__('accounting::modules.accounting.startDate')}}</label>
            <input type="date" class="form-control" id="datepicker" onchange="validateDate(this.value,'start')" name="startDate" value="{{old('startDate')}}" placeholder="{{__('accounting::modules.accounting.date')}}"  />
        </div>
        <div class="form-group mb-2 col-6">
            <label for="date">{{__('accounting::modules.accounting.endDate')}}</label>
            <input type="date" class="form-control" id="datepicker" onchange="validateDate(this.value,'end')" name="endDate" value="{{old('endDate')}}" placeholder="{{__('accounting::modules.accounting.date')}}"  />
        </div>

    </div>

        <div class="table-responsive">
            <table class='table'>
                <tbody>
                    <tr>
                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name='revenueMisc' id="revenueMisc" checked>
                                <label class="form-check-label" for="revenueMisc">{{__('accounting::modules.accounting.includeRevenueMisc')}}</label>
                            </div>
                        </td>
                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="expensesMisc" id="expensesMisc" checked>
                                <label class="form-check-label" for="expensesMisc">{{__('accounting::modules.accounting.includeExpensesMisc')}}</label>
                            </div>
                        </td>
                    </tr>

                    <td>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="accountsMisc" id="accountsMisc" >
                            <label class="form-check-label" for="accountsMisc">{{__('accounting::modules.accounting.includeAccountsMisc')}}</label>
                        </div>
                    </td>

                    <td>
                                                    <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="advancedReport" id="advancedReport" >
                                <label class="form-check-label" for="advancedReport">{{__('accounting::modules.accounting.advancedReport')}}</label>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>


    <button type="submit" class="btn btn-primary mb-2"><i class="fa fa-plus-circle" aria-hidden="true"></i> {{__('accounting::modules.accounting.submit')}}</button>
</form>
        </div>
    </div>
</div>

@endsection
