@extends('layouts.layWithoutSid')


@push('head-script')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">

    <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/multiselect/css/multi-select.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <style>
        .table-responsive .table-custom-border {
            border-left: 1px solid #e4e7ea ;
            border-right: 1px solid #e4e7ea ;
        }
        #regenerate-buttons, #payment-fields {
            display: none;
        }

        .select2-container-multi .select2-choices .select2-search-choice {
            background: #ffffff !important;
        }
        table, th, td {
            border: 1px solid black;
        }
        th {
            height: 50px;
            font-weight: bold;
            text-align: left;
            background-color: #f1ecec;
            text-align: center;
        }
        td {
            text-align: center;
        }

    </style>
@endpush

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <table style="width: 100%; border: none;">
                    <tr>
                        <th rowspan="4"  style="height: 99px; border: none;background-color: #ffffff;"> <a class="logo text-center"><img src="{{ $global->logo_url }}" alt="home"/></a></th>
                        <th rowspan="4"  style="height: 99px; border: none; font-weight: bold; font-size: xx-large;background-color: #ffffff;">{{$arabicTitle}}</th>
                        <th style="height: 10px; border: none;background-color: #ffffff;">مديرية الشباب والرياضة</th>
                    </tr>
                    <tr>
                        <th style="font-size:20px;height: 10px; border: none;background-color: #ffffff; font-weight: 300">نادي الحوار للالعاب الرياضية</th>
                    </tr>
                    <tr>
                        <th style="height: 10px; border: none;background-color: #ffffff;">الجزيرة-المنصورة</th>
                    </tr>
                    <tr>
                        <th style="height: 10px; border: none;background-color: #f1ecec;">المشهرة برقم 260 لسنة 2002</th>
                    </tr>
                </table>
                <font size="3" face="Courier New" >
                    <table style="width:100%">
                        <thead>
                        <tr>
                            <th rowspan="2" >@lang('payroll::modules.payroll.notices')</th>
                            <th rowspan="2" >@lang('payroll::modules.payroll.signatureOfReceipt')</th>
                            <th rowspan="2" >@lang('payroll::modules.payroll.net')</th>
                            <th rowspan="2" >@lang('payroll::modules.payroll.totalDeductions')</th>
                            <th rowspan="1" colspan="4">@lang('payroll::modules.payroll.deductions')</th>
                            <th rowspan="2" >@lang('payroll::modules.payroll.totalAccruals')</th>
                            <th rowspan="2" >@lang('payroll::modules.payroll.clubPercentageBasic')</th>
                            <th rowspan="2" >@lang('payroll::modules.payroll.total')</th>
                            <th rowspan="2" >@lang('payroll::modules.payroll.allowances')</th>
                            <th rowspan="2" >@lang('payroll::modules.payroll.basic')</th>
                            <th rowspan="2" >@lang('payroll::modules.payroll.daysNo')</th>
                            <th rowspan="2" >@lang('payroll::modules.payroll.designation')</th>
                            <th rowspan="2" >@lang('app.name')</th>
                            <th rowspan="2" >#</th>
                        </tr>
                        <tr>
                            <th>@lang('payroll::modules.payroll.incomeTaxes')</th>
                            <th>@lang('payroll::modules.payroll.others')</th>
                            <th>@lang('payroll::modules.payroll.employeePercentage')</th>
                            <th>@lang('payroll::modules.payroll.clubPercentage')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($contents as $item)
                            <tr>
                                <td></td>
                                <td></td>
                                <td>{{strtr($item['Net'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                                <td>{{strtr($item['TotalDeductions'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                                <td>{{strtr($item['TDS'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                                <td></td>
                                <td>{{strtr($item['ded2'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                                <td>{{strtr($item['ded1'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                                <td>{{strtr($item['TotalAccruals'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                                <td>{{strtr($item['ear1'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                                <td>{{strtr($item['Total'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                                <td>{{strtr($item['Allowance'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                                <td>{{strtr($item['Basic'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                                <td>{{strtr($item['NoOfDays'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                                <td>{{strtr($item['designation'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                                <td>{{strtr($item['name'], array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                                <td>{{strtr($item['ind']+1, array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'))}}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td></td>
                            <td>{{$totalNet}}</td>
                            <td>{{$totalTdeduc}}</td>
                            <td>{{$totalTDS}}</td>
                            <td></td>
                            <td>{{$totalDed2}}</td>
                            <td>{{$totalDed1}}</td>
                            <td>{{$totalAccuir}}</td>
                            <td>{{$totalEar1}}</td>
                            <td>{{$totalTotal}}</td>
                            <td>{{$totalAllow}}</td>
                            <td>{{$totalBasic}}</td>
                            <td colspan="4">@lang('payroll::modules.payroll.total')</td>
                        </tr>
                        <tr>
                            <td colspan="17">{{$arabicTotalAmount}}</td>
                        </tr>
                        </tbody>
                    </table>
                </font>
            </div>
        </div>
    </div>


@endsection

@push('footer-script')
    <script src="{{ asset('plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script>

    <script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/multiselect/js/jquery.multi-select.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>

@endpush
