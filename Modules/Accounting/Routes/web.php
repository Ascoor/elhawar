<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Accounting\Entities\Code;
use Modules\Accounting\Entities\InoutGroup;
use Modules\Accounting\Http\Controllers\Codesettings;
use Modules\Accounting\Http\Controllers\Dailyrecords;
use Modules\Accounting\Http\Controllers\Report;
use Modules\Accounting\Http\Controllers\BudgetTerms;
use Modules\Accounting\Http\Controllers\Credebtors;
use Modules\Accounting\Http\Controllers\Inout;
use Modules\Accounting\Http\Controllers\Insurances;
use Modules\Accounting\Http\Controllers\LettersOfGuarantee;
use Modules\Accounting\Http\Controllers\Loans;
use Modules\Accounting\Http\Controllers\Checks;
use Modules\Accounting\Http\Controllers\BankTransfers;
use Modules\Accounting\Http\Controllers\AssetsDeprecations;
use Modules\Accounting\Http\Controllers\Capital;
use Modules\Accounting\Http\Controllers\RevenExpenCodes;

Route::group(['middleware' => 'auth'], function () {

    // Admin routes
    Route::group(
        ['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['role:admin']],
        function () {
Route::prefix('accounting')->group(function() {
   Route::get('/', 'AccountingController@index');

    Route::get('codesettings/{type}', [Codesettings::class, 'index'])->where('type',Code::getRoutingTypeValidator())->name('accounting.codesettings.index');
    Route::get('codesettings/{type}/destroy/{id?}', [Codesettings::class, 'destroy'])->where('type',Code::getRoutingTypeValidator())->name('accounting.codesettings.destroy');
    Route::get('codesettings/{type}/create', [Codesettings::class, 'create'])->where('type',Code::getRoutingTypeValidator())->name('accounting.codesettings.create');
    Route::post('codesettings/{type}/search', [Codesettings::class, 'search'])->where('type',Code::getRoutingTypeValidator())->name('accounting.codesettings.search');
    Route::post('codesettings/{type}/store', [Codesettings::class, 'store'])->where('type',Code::getRoutingTypeValidator())->name('accounting.codesettings.store');

//To be refractored
    Route::post('/getCodeLevel', function(Request $request)
    {
        $request->validate(['selection'=>'required|numeric|exists:Modules\Accounting\Entities\Code,id']);
        return response()->json(Code::select('level')->findOrFail($request['selection']));
    })->name('accounting.codesettings.getCodeLevel');


    Route::get('dailyrecords/{type}', [Dailyrecords::class, 'index'])->where('type',Code::getRoutingTypeValidator())->name('accounting.dailyrecords.index');
    Route::get('dailyrecords/{type}/create', [Dailyrecords::class, 'create'])->where('type',Code::getRoutingTypeValidator())->name('accounting.dailyrecords.create');
    Route::get('dailyrecords/{type}/destroy/{id?}', [Dailyrecords::class, 'destroy'])->where('type',Code::getRoutingTypeValidator())->name('accounting.dailyrecords.destroy');
    Route::get('dailyrecords/{type}/edit/{id?}', [Dailyrecords::class, 'edit'])->where('type',Code::getRoutingTypeValidator())->name('accounting.dailyrecords.edit');
    Route::get('dailyrecords/print/{id?}', [Dailyrecords::class, 'print'])->name('accounting.dailyrecords.print');
    Route::get('dailyrecords/preview/{id?}', [Dailyrecords::class, 'preview'])->name('accounting.dailyrecords.preview');
    Route::post('dailyrecords/{type}/ajax/{operation}', [Dailyrecords::class, 'ajax'])->where('type',Code::getRoutingTypeValidator())->name('accounting.dailyrecords.ajax');
    Route::post('dailyrecords/{type}/store', [Dailyrecords::class, 'store'])->where('type',Code::getRoutingTypeValidator())->name('accounting.dailyrecords.store');
    Route::put('dailyrecords/{type}/{id}/update', [Dailyrecords::class, 'update'])->where('type',Code::getRoutingTypeValidator())->name('accounting.dailyrecords.update');
    Route::post('dailyrecords/{type}/periodicreport/', [Dailyrecords::class, 'periodicreport'])->name('accounting.dailyrecords.periodicreport');


    Route::get('report/', [Report::class, 'index'])->name('accounting.report.index');

    Route::get('report/revenexpen', [Report::class, 'revexpenReport'])->name('accounting.report.revenexpen');
    Route::get('report/receiptpayments', [Report::class, 'receiptpayments'])->name('accounting.report.receiptpayments');
    Route::get('report/trialbalance', [Report::class, 'trialbalance'])->name('accounting.report.trialbalance');    
    Route::post('report/revenexpen', [Report::class, 'revexpenReport'])->name('accounting.report.revenexpen');
    Route::post('report/receiptpayments', [Report::class, 'receiptpayments'])->name('accounting.report.receiptpayments');
    Route::post('report/trialbalance', [Report::class, 'trialbalance'])->name('accounting.report.trialbalance');

   
    Route::post('report/generate', [Report::class, 'generate'])->name('accounting.report.generate');
    Route::post('report/ajax/{action}', [Report::class, 'ajax'])->name('accounting.report.ajax');


    Route::get('budgetterms/{type}', [BudgetTerms::class, 'index'])->where('type',Code::getRoutingTypeValidator())->name('accounting.budgetterms.index');
    Route::get('budgetterms/misc/{type}', [BudgetTerms::class, 'misc'])->where('type',Code::getRoutingTypeValidator())->name('accounting.budgetterms.misc');

    Route::get('budgetterms/{type}/destroy/{id?}', [BudgetTerms::class, 'destroy'])->where('type',Code::getRoutingTypeValidator())->name('accounting.budgetterms.destroy');
    Route::get('budgetterms/{type}/edit/{id?}', [BudgetTerms::class, 'edit'])->where('type',Code::getRoutingTypeValidator())->name('accounting.budgetterms.edit');
    Route::get('budgetterms/{type}/create', [BudgetTerms::class, 'create'])->where('type',Code::getRoutingTypeValidator())->name('accounting.budgetterms.create');
    Route::post('budgetterms/{type}/ajax/{operation}', [BudgetTerms::class, 'ajax'])->where('type',Code::getRoutingTypeValidator())->name('accounting.budgetterms.ajax');
    Route::post('budgetterms/{type}/store', [BudgetTerms::class, 'store'])->where('type',Code::getRoutingTypeValidator())->name('accounting.budgetterms.store');
    Route::get('budgetterms/{type}/{termID}/termItem/destroy/{itemID}', [BudgetTerms::class, 'destroyItem'])->where('type',Code::getRoutingTypeValidator())->name('accounting.budgetterms.destroyItem');
    Route::put('budgetterms/{type}/update/{id}', [BudgetTerms::class, 'update'])->where('type',Code::getRoutingTypeValidator())->name('accounting.budgetterms.update');

    Route::post('budgetterms/misc/{type}/store', [BudgetTerms::class, 'miscStore'])->where('type',Code::getRoutingTypeValidator())->name('accounting.budgetterms.miscStore');

    Route::get('credibtors', [Credebtors::class, 'index'])->name('accounting.credibtors.index');

    Route::get('credibtors/credibtorsheet/{id?}', [Credebtors::class, 'credibtorsheet'])->name('accounting.credibtors.credibtorsheet');
    Route::post('credibtors/credibtorsheet/{id?}', [Credebtors::class, 'credibtorsheet'])->name('accounting.credibtors.credibtorsheet');
    
    Route::get('credibtors/generaledgersheet/{id?}', [Credebtors::class, 'generaledgersheet'])->name('accounting.credibtors.generaledgersheet');
    Route::post('credibtors/generaledgersheet/{id?}', [Credebtors::class, 'generaledgersheet'])->name('accounting.credibtors.generaledgersheet');

    Route::get('inout/{type}', [Inout::class, 'index'])->where('type',InoutGroup::getRoutingTypeValidator())->name('accounting.inout.index');

    Route::get('inout/{type}/create', [Inout::class, 'create'])->where('type',InoutGroup::getRoutingTypeValidator())->name('accounting.inout.create');
    Route::post('inout/{type}/create', [Inout::class, 'create'])->where('type',InoutGroup::getRoutingTypeValidator())->name('accounting.inout.create');

    Route::get('inout/{type}/destroy/{id?}', [Inout::class, 'destroy'])->where('type',InoutGroup::getRoutingTypeValidator())->name('accounting.inout.destroy');
    
    Route::get('inout/{type}/list/{id?}', [Inout::class, 'list'])->where('type',InoutGroup::getRoutingTypeValidator())->name('accounting.inout.list');
    
    Route::get('inout/download/{id?}', [Inout::class, 'download'])->name('accounting.inout.download');
  
  
    Route::get('lettersofguarantee', [LettersOfGuarantee::class, 'index'])->name('accounting.lettersofguarantee.index');
    Route::get('lettersofguarantee/create', [LettersOfGuarantee::class, 'create'])->name('accounting.lettersofguarantee.create');
    Route::post('lettersofguarantee/create', [LettersOfGuarantee::class, 'create'])->name('accounting.lettersofguarantee.create');   
    Route::get('lettersofguarantee/update/{id}', [LettersOfGuarantee::class, 'update'])->name('accounting.lettersofguarantee.update');
    Route::post('lettersofguarantee/update/{id}', [LettersOfGuarantee::class, 'update'])->name('accounting.lettersofguarantee.update');
    Route::get('lettersofguarantee/delete/{id?}', [LettersOfGuarantee::class, 'delete'])->name('accounting.lettersofguarantee.delete');

    Route::get('loans', [Loans::class, 'index'])->name('accounting.loans.index');
    Route::get('loans/create', [Loans::class, 'create'])->name('accounting.loans.create');
    Route::post('loans/create', [Loans::class, 'create'])->name('accounting.loans.create');   
    Route::get('loans/update/{id}', [Loans::class, 'update'])->name('accounting.loans.update');
    Route::post('loans/update/{id}', [Loans::class, 'update'])->name('accounting.loans.update');
    Route::get('loans/delete/{id?}', [Loans::class, 'delete'])->name('accounting.loans.delete');

      
    Route::get('insurances', [Insurances::class, 'index'])->name('accounting.insurances.index');
    Route::get('insurances/create', [Insurances::class, 'create'])->name('accounting.insurances.create');
    Route::post('insurances/create', [Insurances::class, 'create'])->name('accounting.insurances.create');   
    Route::get('insurances/update/{id}', [Insurances::class, 'update'])->name('accounting.insurances.update');
    Route::post('insurances/update/{id}', [Insurances::class, 'update'])->name('accounting.insurances.update');
    Route::get('insurances/delete/{id?}', [Insurances::class, 'delete'])->name('accounting.insurances.delete');

    Route::get('checks', [Checks::class, 'index'])->name('accounting.checks.index');
    Route::get('checks/create', [Checks::class, 'create'])->name('accounting.checks.create');
    Route::post('checks/create', [Checks::class, 'create'])->name('accounting.checks.create');   
    Route::get('checks/update/{id}', [Checks::class, 'update'])->name('accounting.checks.update');
    Route::post('checks/update/{id}', [Checks::class, 'update'])->name('accounting.checks.update');
    Route::get('checks/delete/{id?}', [Checks::class, 'delete'])->name('accounting.checks.delete');

    Route::get('banktransfers', [BankTransfers::class, 'index'])->name('accounting.banktransfers.index');
    Route::get('banktransfers/create', [BankTransfers::class, 'create'])->name('accounting.banktransfers.create');
    Route::post('banktransfers/create', [BankTransfers::class, 'create'])->name('accounting.banktransfers.create');   
    Route::get('banktransfers/update/{id}', [BankTransfers::class, 'update'])->name('accounting.banktransfers.update');
    Route::post('banktransfers/update/{id}', [BankTransfers::class, 'update'])->name('accounting.banktransfers.update');
    Route::get('banktransfers/delete/{id?}', [BankTransfers::class, 'delete'])->name('accounting.banktransfers.delete');

    Route::get('balancesheet', [Report::class, 'balanceSheet'])->name('accounting.balancesheet');
    Route::post('balancesheet', [Report::class, 'balanceSheet'])->name('accounting.balancesheet');
  
    Route::get('depreciationsheet', [Report::class, 'depreciationSheet'])->name('accounting.depreciationsheet');
    Route::post('depreciationsheet', [Report::class, 'depreciationSheet'])->name('accounting.depreciationsheet');

    Route::get('assetsdeprecations', [AssetsDeprecations::class, 'index'])->name('accounting.assetsdeprecations.index');
    Route::get('assetsdeprecations/create', [AssetsDeprecations::class, 'create'])->name('accounting.assetsdeprecations.create');
    Route::post('assetsdeprecations/create', [AssetsDeprecations::class, 'create'])->name('accounting.assetsdeprecations.create');   
    Route::get('assetsdeprecations/update/{id}', [AssetsDeprecations::class, 'update'])->name('accounting.assetsdeprecations.update');
    Route::post('assetsdeprecations/update/{id}', [AssetsDeprecations::class, 'update'])->name('accounting.assetsdeprecations.update');
    Route::get('assetsdeprecations/delete/{id?}', [AssetsDeprecations::class, 'delete'])->name('accounting.assetsdeprecations.delete');

    Route::get('capital', [Capital::class, 'index'])->name('accounting.capital');
    Route::post('capital', [Capital::class, 'index'])->name('accounting.capital');

    Route::get('revenexpencodes', [RevenExpenCodes::class, 'index'])->name('accounting.revenexpencodes');
    Route::get('revenexpencodes/create', [RevenExpenCodes::class, 'create'])->name('accounting.revenexpencodes.create');
    Route::post('revenexpencodes/create', [RevenExpenCodes::class, 'create'])->name('accounting.revenexpencodes.create');

    Route::get('revenexpencodes/delete/{id?}', [RevenExpenCodes::class, 'delete'])->name('accounting.revenexpencodes.delete');
    
});});});
