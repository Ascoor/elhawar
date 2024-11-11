
@section('filter-section')      
@if (App::isLocale('ar')) 
<style>
#page-wrapper > div > div.col-md-3.filter-section > h5.pull-left
{
    float:right!important;
    padding: 8px;
}
</style>
@endif

<div class="row m-b-15" id="filters" {{__('accounting::modules.accounting.rtl')}}>

    <form  id="filter-form">
            
            @yield('dt-filter-form-inputs')

            <div class="col-md-12">
                <div class="form-group">
                    <button type="button" id="apply-filters" class="btn btn-success"><i class="fa fa-check"></i> @lang('app.apply')</button>
                    <button type="button" id="reset-filters" class="btn btn-inverse m-l-10"><i class="fa fa-refresh"></i> @lang('app.reset')</button>
                </div>
            </div>
    </form>
</div>
@endsection
