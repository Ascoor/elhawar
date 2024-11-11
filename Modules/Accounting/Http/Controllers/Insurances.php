<?php

namespace Modules\Accounting\Http\Controllers;

use App\Http\Controllers\Admin\AdminBaseController;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Modules\Accounting\DataTables\InsurancesDataTable;
use Modules\Accounting\Entities\Insurance;
use Modules\Accounting\Entities\InsuranceType;

class Insurances extends AdminBaseController {

    public function __construct()
    {
        parent::__construct();
        //Fail-safe page titile
        $this->pageTitle='Insurances';
        $this->pageIcon = 'fa fa-file-text';
        $this->middleware(function ($request, $next) {
            //localize Page title based on current locale
            $this->pageTitle = __('accounting::modules.accounting.insurances');
            if (!in_array('accounting', $this->modules)) {
                abort(403);
            }    // to be added after adding the accounting module inside the db table of working modules
            return $next($request);
        });
    }

    public function index(InsurancesDataTable $dataTable)
    {

        $insuranceTypes = InsuranceType::all();
        
        return $dataTable->render('accounting::insurances.index',$this->data,compact('insuranceTypes'));
        
    }




    public function create(Request $request)
    {
        
        if ($request->isMethod('POST')) {
                $request->validate(
                    [
                        'insuranceType' => 'required|exists:Modules\Accounting\Entities\InsuranceType,id',
                        'paymentDate' => 'required|date',
                        'returnDate' => 'required|date',
                        'amount' => 'required|numeric',
                        'purpose' => 'nullable',
                    ]);

                    try
                    {
                        Insurance::create([
                                'insurance_type_id' => $request->input('insuranceType'),
                                'paymentDate' => $request->input('paymentDate'),
                                'returnDate' => $request->input('returnDate'),
                                'amount' => $request->input('amount'),
                                'purpose' => $request->input('purpose'),
                            ]);

                            return redirect(route('admin.accounting.insurances.index'))
                            ->with('success', __('accounting::modules.accounting.storesuccess'));                    
                    }
                    catch(Exception $e)
                    {
                        throw ValidationException::withMessages([__('accounting::modules.accounting.unexcpectedError')]);
                    }
 
                
        }      
        
        $insuranceTypes = InsuranceType::all();
        return view('accounting::insurances.create',$this->data,compact('insuranceTypes'));
    }

    public function update(Request $request)
    {
        $insurance=Insurance::findOrFail($request->id);
        if ($request->isMethod('POST')) {
            $request->validate(
                [
                    'insuranceType' => 'required|exists:Modules\Accounting\Entities\InsuranceType,id',
                    'paymentDate' => 'required|date',
                    'returnDate' => 'required|date',
                    'amount' => 'required|numeric',
                    'purpose' => 'nullable',
                 ]);

                try
                {
                    $insurance->update(
                        [
                            'insurance_type_id' => $request->input('insuranceType'),
                            'paymentDate' => $request->input('paymentDate'),
                            'returnDate' => $request->input('returnDate'),
                            'amount' => $request->input('amount'),
                            'purpose' => $request->input('purpose'),
                        ]);

                        return redirect(route('admin.accounting.insurances.index'))
                        ->with('success', __('accounting::modules.accounting.editsuccess'));                    
                }
                catch(Exception $e)
                {
                    throw ValidationException::withMessages([__('accounting::modules.accounting.unexcpectedError')]);
                }

            
        }      

        $insuranceTypes = InsuranceType::all();
        return view('accounting::insurances.edit',$this->data,compact('insuranceTypes','insurance'));
    }

    public function delete(Request $request)
    {
        (Insurance::findOrFail($request->id))->delete();
        return redirect(route('admin.accounting.insurances.index'))
        ->with('success', __('accounting::modules.accounting.deleteSuccess'));
    }

}
