@extends('layouts.app')
@include('accounting::sections.pageTitleButtons')
@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="white-box">


@include('accounting::sections.blocks.messages')
                @if (App::isLocale('ar'))
                        <style>.table-responsive .dropdown-menu {left : 0!important;right:auto!important;max-width: fit-content!important;}.table-responsive .dropdown-menu li{text-align: start!important;}div.dt-buttons{float:left!important}</style>
                @endif
            <div class="table-responsive" {{__('accounting::modules.accounting.rtl')}}>
                {!! $dataTable->table(['class' => 'table table-bordered table-hover toggle-circle default footable-loaded footable']) !!}
            </div>
        </div>
    </div>
</div>
<!-- .row -->
@endsection

@push('footer-script')
    @include('accounting::sections.blocks.DT')
    @include('accounting::sections.blocks.deleteConfirmSwal')
@endpush
