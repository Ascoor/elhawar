@push('head-script')

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
<style>
    #DT-table > thead > tr > th ,  #DT-table > tbody > tr > td
    {
        text-align: center;
    }
</style>
@endpush

<script src="{{ asset('plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('js/datatables/buttons.server-side.js') }}"></script>
{!! $dataTable->scripts() !!}

<script>
function loadTable() {
    window.LaravelDataTables["DT-table"].draw();
}


$('#apply-filters').click(function() {
    $('#DT-table').on('preXhr.dt', function (e, settings, data) {
            @yield('dt-filter-data','')
        });

    loadTable();
});

$('#reset-filters').click(function() {
    $('#filter-form')[0].reset();
    @yield('dt-filter-reset','')
    loadTable();
})
</script>
