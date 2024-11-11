<?php

namespace Modules\Accounting\Http\Controllers;

use App\Http\Controllers\Admin\AdminBaseController;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Modules\Accounting\DataTables\LettersOfGuaranteeDataTable;
use Modules\Accounting\Entities\Letter;
use Modules\Accounting\Entities\LetterType;

class LettersOfGuarantee extends AdminBaseController {

    public function __construct()
    {
        parent::__construct();
        //Fail-safe page titile
        $this->pageTitle='Letters Of Guarantee';
        $this->pageIcon = 'fa fa-file-text';
        $this->middleware(function ($request, $next) {
            //localize Page title based on current locale
            $this->pageTitle = __('accounting::modules.accounting.lettersOfGuarantee');
            if (!in_array('accounting', $this->modules)) {
                abort(403);
            }    // to be added after adding the accounting module inside the db table of working modules
            return $next($request);
        });
    }

    public function index(LettersOfGuaranteeDataTable $dataTable)
    {

        $lettersOfGuaranteeTypes = LetterType::all();
        
        return $dataTable->render('accounting::Lettersofguarantee.index',$this->data,compact('lettersOfGuaranteeTypes'));
        
    }




    public function create(Request $request)
    {
        
        if ($request->isMethod('POST')) {
                $request->validate(
                    [
                        'letterNumber' => 'required|unique:Modules\Accounting\Entities\Letter,letterNumber|max:120',
                        'letterType' => 'required|exists:Modules\Accounting\Entities\LetterType,id',
                        'issuedToCompany' => 'required|max:120',
                        'issuingBank' => 'required|max:120',
                        'issuingDate' => 'required|date',
                        'expirationDate' => 'required|date',
                        'amount' => 'required|numeric',
                        'description' => 'nullable',
                    ]
                    );

                    try
                    {
                        Letter::create(
                            [
                                'letterNumber' => $request->input('letterNumber'),
                                'letterType' => $request->input('letterType'),
                                'issuedToCompany' => $request->input('issuedToCompany'),
                                'issuingBank' => $request->input('issuingBank'),
                                'issuingDate' => $request->input('issuingDate'),
                                'expirationDate' => $request->input('expirationDate'),
                                'amount' => $request->input('amount'),
                                'description' => $request->input('description'),
                            ]
                            );

                            return redirect(route('admin.accounting.lettersofguarantee.index'))
                            ->with('success', __('accounting::modules.accounting.storesuccess'));                    
                    }
                    catch(Exception $e)
                    {
                        throw ValidationException::withMessages([__('accounting::modules.accounting.unexcpectedError')]);
                    }
 
                
        }      
        
        $lettersOfGuaranteeTypes = LetterType::all();
        return view('accounting::Lettersofguarantee.create',$this->data,compact('lettersOfGuaranteeTypes'));
    }

    public function update(Request $request)
    {
        $letter=Letter::findOrFail($request->id);
        if ($request->isMethod('POST')) {
            $request->validate(
                [
                    'letterNumber' => 'required|max:120|unique:Modules\Accounting\Entities\Letter,letterNumber,'.$letter->id,
                    'letterType' => 'required|exists:Modules\Accounting\Entities\LetterType,id',
                    'issuedToCompany' => 'required|max:120',
                    'issuingBank' => 'required|max:120',
                    'issuingDate' => 'required|date',
                    'expirationDate' => 'required|date',
                    'amount' => 'required|numeric',
                    'description' => 'nullable',
                ]
                );

                try
                {
                    $letter->update(
                        [
                            'letterNumber' => $request->input('letterNumber'),
                            'letterType' => $request->input('letterType'),
                            'issuedToCompany' => $request->input('issuedToCompany'),
                            'issuingBank' => $request->input('issuingBank'),
                            'issuingDate' => $request->input('issuingDate'),
                            'expirationDate' => $request->input('expirationDate'),
                            'amount' => $request->input('amount'),
                            'description' => $request->input('description'),
                        ]
                        );

                        return redirect(route('admin.accounting.lettersofguarantee.index'))
                        ->with('success', __('accounting::modules.accounting.editsuccess'));                    
                }
                catch(Exception $e)
                {
                    throw ValidationException::withMessages([__('accounting::modules.accounting.unexcpectedError')]);
                }

            
        }      

        $lettersOfGuaranteeTypes = LetterType::all();
        return view('accounting::Lettersofguarantee.edit',$this->data,compact('lettersOfGuaranteeTypes','letter'));
    }

    public function delete(Request $request)
    {
        (Letter::findOrFail($request->id))->delete();
        return redirect(route('admin.accounting.lettersofguarantee.index'))
        ->with('success', __('accounting::modules.accounting.deleteSuccess'));
    }

}
