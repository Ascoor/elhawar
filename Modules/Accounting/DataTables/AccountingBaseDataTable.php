<?php
namespace Modules\Accounting\DataTables;

use App\DataTables\BaseDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;

abstract class AccountingBaseDataTable  extends BaseDataTable
{
    protected $tableID = 'DT-table';
    protected $exportFilename = 'Table';
    

    abstract protected function getColumns();

    
    public function html():HtmlBuilder
    {
        return $this->builder()
            ->setTableId($this->tableID)
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
                Button::make(['extend' => 'export', 'buttons' => ['excel', 'csv'], 'text' => '<i class="fa fa-download"></i> ' . __('app.export') . '&nbsp;<span class="caret"></span>'])
            )
            ->parameters([
                'initComplete' => 'function () {
                   window.LaravelDataTables["'.$this->tableID.'"].buttons().container()
                    .appendTo( ".bg-title #btns-container")
                }',
                'fnDrawCallback' => 'function( oSettings ) {
                    $("body").tooltip({
                        selector: \'[data-toggle="tooltip"]\'
                    })
                }',
            ]);
    }

    protected function filename():string
    {
        return  $this->exportFilename.'_'.date('YmdHis');
    }

}