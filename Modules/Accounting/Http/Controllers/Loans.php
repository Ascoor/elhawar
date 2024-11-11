<?php

namespace Modules\Accounting\Http\Controllers;

use App\Http\Controllers\Admin\AdminBaseController;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Modules\Accounting\DataTables\LoansDataTable;
use Modules\Accounting\Entities\Loan;

class Loans extends AdminBaseController {

    public function __construct()
    {
        parent::__construct();
        //Fail-safe page titile
        $this->pageTitle='Loans';
        $this->pageIcon = 'fa fa-money';
        $this->middleware(function ($request, $next) {
            //localize Page title based on current locale
            $this->pageTitle = __('accounting::modules.accounting.loans');
            if (!in_array('accounting', $this->modules)) {
                abort(403);
            }    // to be added after adding the accounting module inside the db table of working modules
            return $next($request);
        });
    }

    public function index(LoansDataTable $dataTable)
    {

        return $dataTable->render('accounting::loans.index',$this->data);
        
    }




    public function create(Request $request)
    {
        
        if ($request->isMethod('POST')) {
                $request->validate(
                    [
                        'borrower' => 'required|max:120',
                        'issuingDate' => 'required|date',
                        'expirationDate' => 'required|date',
                        'amount' => 'required|numeric',
                        'description' => 'nullable',
                    ]
                    );

                    try
                    {
                        Loan::create(
                            [
                                'borrower' => $request->input('borrower'),
                                'issuingDate' => $request->input('issuingDate'),
                                'expirationDate' => $request->input('expirationDate'),
                                'amount' => $request->input('amount'),
                                'description' => $request->input('description'),
                            ]
                            );

                            return redirect(route('admin.accounting.loans.index'))
                            ->with('success', __('accounting::modules.accounting.storesuccess'));                    
                    }
                    catch(Exception $e)
                    {
                        throw ValidationException::withMessages([__('accounting::modules.accounting.unexcpectedError')]);
                    }
 
                
        }      
        
        return view('accounting::loans.create',$this->data);
    }

    public function update(Request $request)
    {
        $loan=Loan::findOrFail($request->id);
        if ($request->isMethod('POST')) {
            $request->validate(
                [
                    'borrower' => 'required|max:120',
                    'issuingDate' => 'required|date',
                    'expirationDate' => 'required|date',
                    'amount' => 'required|numeric',
                    'description' => 'nullable',
                ]
                );

                try
                {
                    $loan->update(
                        [
                            'borrower' => $request->input('borrower'),
                            'issuingDate' => $request->input('issuingDate'),
                            'expirationDate' => $request->input('expirationDate'),
                            'amount' => $request->input('amount'),
                            'description' => $request->input('description'),
                        ]
                        );

                        return redirect(route('admin.accounting.loans.index'))
                        ->with('success', __('accounting::modules.accounting.editsuccess'));                    
                }
                catch(Exception $e)
                {
                    throw ValidationException::withMessages([__('accounting::modules.accounting.unexcpectedError')]);
                }

            
        }      

        return view('accounting::loans.edit',$this->data,compact('loan'));
    }


    public function delete(Request $request)
    {
        (Loan::findOrFail($request->id))->delete();

        return redirect(route('admin.accounting.loans.index'))
        ->with('success', __('accounting::modules.accounting.deleteSuccess'));
    }

}
