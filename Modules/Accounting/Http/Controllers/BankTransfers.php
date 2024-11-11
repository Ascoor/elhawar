<?php

namespace Modules\Accounting\Http\Controllers;

use App\Http\Controllers\Admin\AdminBaseController;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Modules\Accounting\DataTables\BankTransfersDataTable;
use Modules\Accounting\Entities\BankTransfer;
use Modules\Accounting\Entities\BankAccountType;

class BankTransfers extends AdminBaseController {

    public function __construct()
    {
        parent::__construct();
        //Fail-safe page titile
        $this->pageTitle='Bank Transfers';
        $this->pageIcon = 'fa fa-exchange';
        $this->middleware(function ($request, $next) {
            //localize Page title based on current locale
            $this->pageTitle = __('accounting::modules.accounting.bankTransfers');
            if (!in_array('accounting', $this->modules)) {
                abort(403);
            }    // to be added after adding the accounting module inside the db table of working modules
            return $next($request);
        });
    }

    public function index(BankTransfersDataTable $dataTable)
    {

        $accountTypes = BankAccountType::all();
        
        return $dataTable->render('accounting::banktransfers.index',$this->data,compact('accountTypes'));
        
    }




    public function create(Request $request)
    {
        
        if ($request->isMethod('POST')) {
                $request->validate(
                    [
                        'accountType' => 'required|exists:Modules\Accounting\Entities\BankAccountType,id',
                        'number' => 'required|unique:Modules\Accounting\Entities\BankTransfer,number|max:120',
                        'date' => 'required|date',
                        'bankName' => 'required|max:120',
                        'recipient' => 'required|max:120',
                        'amount' => 'required|numeric',
                        'status' => 'required|in:in,out'
                    ]);

                    try
                    {
                        BankTransfer::create([
                                'bank_account_type_id' => $request->input('accountType'),
                                'number' => $request->input('number'),
                                'date' => $request->input('date'),
                                'bankName' => $request->input('bankName'),
                                'recipient' => $request->input('recipient'),
                                'amount' => $request->input('amount'),
                                'status' => $request->input('status'),
                            ]);

                            return redirect(route('admin.accounting.banktransfers.index'))
                            ->with('success', __('accounting::modules.accounting.storesuccess'));                    
                    }
                    catch(Exception $e)
                    {
                        throw ValidationException::withMessages([__('accounting::modules.accounting.unexcpectedError')]);
                    }
 
                
        }      
        
        $accountTypes = BankAccountType::all();
        return view('accounting::banktransfers.create',$this->data,compact('accountTypes'));
    }

    public function update(Request $request)
    {
        $transfer=BankTransfer::findOrFail($request->id);
        if ($request->isMethod('POST')) {
            $request->validate(
                [
                    'accountType' => 'required|exists:Modules\Accounting\Entities\BankAccountType,id',
                    'number' => 'required|unique:Modules\Accounting\Entities\BankTransfer,number,'.$transfer->id.'|max:120',
                    'date' => 'required|date',
                    'bankName' => 'required|max:120',
                    'recipient' => 'required|max:120',
                    'amount' => 'required|numeric',
                    'status' => 'required|in:in,out'
             ]);

                try
                {
                    $transfer->update(
                        [
                            'bank_account_type_id' => $request->input('accountType'),
                            'number' => $request->input('number'),
                            'date' => $request->input('date'),
                            'bankName' => $request->input('bankName'),
                            'recipient' => $request->input('recipient'),
                            'amount' => $request->input('amount'),
                            'status' => $request->input('status'),
                    ]);

                        return redirect(route('admin.accounting.banktransfers.index'))
                        ->with('success', __('accounting::modules.accounting.editsuccess'));                    
                }
                catch(Exception $e)
                {
                    throw ValidationException::withMessages([__('accounting::modules.accounting.unexcpectedError')]);
                }

            
        }      

        $accountTypes = BankAccountType::all();
        return view('accounting::banktransfers.edit',$this->data,compact('accountTypes','transfer'));

    }

    public function delete(Request $request)
    {
        (BankTransfer::findOrFail($request->id))->delete();
        return redirect(route('admin.accounting.banktransfers.index'))
        ->with('success', __('accounting::modules.accounting.deleteSuccess'));
    }

}
