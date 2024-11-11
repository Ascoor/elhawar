@section('page-title')
    <style> .bg-title{display:flex} </style>
    <div class="row bg-title" {{__('accounting::modules.accounting.rtl')}} >
        <!-- .page title -->
        <div class="col-md-12 col-sm-12 bg-title-left">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ $pageTitle }}</h4>
        </div>
        <!-- /.page title -->
    </div>
@endsection
