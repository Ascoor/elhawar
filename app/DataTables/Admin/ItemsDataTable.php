<?php

namespace App\DataTables\Admin;

use App\DataTables\BaseDataTable;
use App\Product;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class ItemsDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $user =  \Auth::user();
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($row) use ($user) {
                $action = '<div class="btn-group dropdown m-r-10">
                 <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default dropdown-toggle waves-effect waves-light" type="button"><i class="fa fa-gears "></i></button>
                <ul role="menu" class="dropdown-menu pull-right">';
                if($user->cans('edit_inventories'))
                $action.='  <li><a href="' . route('admin.items.edit', [$row->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i> ' . trans('app.edit') . '</a></li>';
                $action .= '</ul> </div>';

                return $action;
            })
            ->editColumn('name', function ($row) {
                return ucfirst($row->name);
            })
            ->editColumn('inventory_name', function ($row) {
                return ($row->inventory_name) ;
            })->editColumn('category_name', function ($row) {
                return ($row->category_name) ;
            })->editColumn('item_in_stock', function ($row) {
                return ($row->item_in_stock);
            })->editColumn('price', function ($row) {
                if (!is_null($row->taxes) && $row->taxes != "null") {
                    $totalTax = 0;
                    foreach (json_decode($row->taxes) as $tax) {
                        $this->tax = Product::taxbyid($tax)->first();
                        $totalTax = $totalTax + ($row->price * ($this->tax->rate_percent / 100));
                    }
                    return currency_formatter(($row->price + $totalTax), $this->global->currency->currency_symbol);
                }
                return currency_formatter($row->price, $this->global->currency->currency_symbol);
            })->
            editColumn('expiration_date', function ($row) {
                $today =  date("Y-m-d") ;
                if($row->expiration_date )
                    if( $today > $row->expiration_date)
                    return ' <label class="label label-danger">'.'Expired since '. $row->expiration_date.'</label>';
                    else
                    return ' <label class="label label-success">'.'Expired at '. $row->expiration_date.'</label>';
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'price','expiration_date']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Product $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Product $model)
    {
        $product = $model;
        $request = $this->request();
        $model = $this->getModel($product);

        if ($request->category_id !== null && $request->category_id !== 'all'){
            $model = $this->getModel($product)
                ->where('product_category.id', '=',$request->category_id);
        }
        if ($request->inventory_id !== null && $request->inventory_id !== 'all'){
            $model = $this->getModel($product)
                ->where('inventories.id', '=',$request->inventory_id);
        }
        if($request->state !== null && $request->state !== 'all'){
            $today =  date("Y-m-d") ;
            if($request->state === 'expired'){
                $model = $this->getModel($product)
                    ->where('products.expiration_date', '<',$today);
            }elseif ($request->state === 'not-expired'){
                $model = $this->getModel($product)
                    ->where('products.expiration_date','=',null)->orWhere('products.expiration_date', '>',$today);
            }

        }

        return $model;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('products-table')
            ->columns($this->processTitle($this->getColumns()))
            ->minifiedAjax()
            ->dom("<'row'<'col-md-6'l><'col-md-6'Bf>><'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>")
            ->orderBy(0)
            ->destroy(true)
            ->responsive(true)
            ->serverSide(true)
            ->stateSave(true)
            ->processing(true)
            ->language(__("app.datatable"))
            ->buttons(
                Button::make(['extend' => 'export', 'buttons' => ['excel', 'csv'], 'text' => '<i class="fa fa-download"></i> ' . trans('app.exportExcel') . '&nbsp;<span class="caret"></span>'])
            )
            ->parameters([
                'initComplete' => 'function () {
                   window.LaravelDataTables["products-table"].buttons().container()
                    .appendTo( ".bg-title .text-right")
                }',
                'fnDrawCallback' => 'function( oSettings ) {
                    $("body").tooltip({
                        selector: \'[data-toggle="tooltip"]\'
                    })
                }',
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $invoiceSetting = invoice_setting();

        $sacFieldShow = ($invoiceSetting->hsn_sac_code_show) ? true : false;

        return [
            '#' => ['data' => 'id', 'name' => 'id', 'visible' => true],
            __('modules.stocks.name') => ['data' => 'name', 'name' => 'name'],
            __('modules.stocks.inventory_name')  => ['data' => 'inventory_name', 'name' => 'inventory_name','searchable'=> false],
            __('modules.stocks.category') => ['data' => 'category_name', 'name' => 'category_name','searchable'=> false],
            __('modules.stocks.item_in_stock')  => ['data' => 'item_in_stock', 'name' => 'item_in_stock'],
            __('app.price') . '(' . __('app.inclusiveAllTaxes') . ')' => ['data' => 'price', 'name' => 'price'],
            'state' => ['data' => 'expiration_date', 'name' => 'expiration_date'],
            Column::computed('action', __('app.action'))
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
                ->searchable(false)
                ->width(150)
                ->addClass('text-center')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Products_' . date('YmdHis');
    }

    public function pdf()
    {
        set_time_limit(0);
        if ('snappy' == config('datatables-buttons.pdf_generator', 'snappy')) {
            return $this->snappyPdf();
        }

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('datatables::print', ['data' => $this->getDataForPrint()]);

        return $pdf->download($this->getFilename() . '.pdf');
    }

    /**
     * @param Product $model
     * @return mixed
     */
    private function getModel(Product $model)
    {
        $model = $model
            ->join('product_inventories', 'products.id', '=', 'product_inventories.product')
            ->join('inventories', 'product_inventories.inventory', '=', 'inventories.id')
            ->join('product_category', 'products.category_id', 'product_category.id')
            ->select('product_inventories.*', 'inventories.id as inventory_id', 'inventories.name as inventory_name', 'products.name','products.expiration_date' ,'product_category.id as category_id', 'product_category.name as category_name');
        return $model;
    }
}
