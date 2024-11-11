<?php
namespace Modules\Accounting\Http\Controllers;
use App\Http\Controllers\Admin\AdminBaseController;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Modules\Accounting\DataTables\ChecksDataTable;
use Modules\Accounting\Entities\Check;
use Modules\Accounting\Entities\BankAccountType;

class Checks extends AdminBaseController {

    public function __construct()
    {
        parent::__construct();
        //Fail-safe page titile
        $this->pageTitle='Checks';
        $this->pageIcon = 'fa fa-money';
        $this->middleware(function ($request, $next) {
            //localize Page title based on current locale
            $this->pageTitle = __('accounting::modules.accounting.checks');
            if (!in_array('accounting', $this->modules)) {
                abort(403);
            }    // to be added after adding the accounting module inside the db table of working modules
            return $next($request);
        });
    }
	@@ -35,119 +32,114 @@ public function index(ChecksDataTable $dataTable)
    {

        $accountTypes = BankAccountType::all();

        return $dataTable->render('accounting::checks.index',$this->data,compact('accountTypes'));

    }




    public function create(Request $request)
    {
        
        if ($request->isMethod('POST')) {
                $request->validate(
                    [
                        'accountType' => 'required|exists:Modules\Accounting\Entities\BankAccountType,id',
                        'number' => 'required|unique:Modules\Accounting\Entities\Check,number|max:120',
                        'date' => 'required|date',
                        'bankName' => 'required_if:status,in|required_without:code_id|max:120',
                        'code_id' => 'required_if:status,out|required_without:bankName|exists:Modules\Accounting\Entities\Code,id',
                        'recipient' => 'required|max:120',
                        'amount' => 'required|numeric',
                        'status' => 'required|in:in,out',
                        'cashed' => 'required|in:1,0'
                    ]);

                    try
                    {
                        Check::create([
                                'bank_account_type_id' => $request->input('accountType'),
                                'number' => $request->input('number'),
                                'date' => $request->input('date'),
                                'bankName' => $request->input('bankName')??'',
                                'code_id' => $request->input('code_id')??null,
                                'recipient' => $request->input('recipient'),
                                'amount' => $request->input('amount'),
                                'status' => $request->input('status'),
                                'cashed' => $request->input('cashed'),

                            ]);

                            return redirect(route('admin.accounting.checks.index'))
                            ->with('success', __('accounting::modules.accounting.storesuccess'));                    
                    }
                    catch(Exception $e)
                    {
                        throw ValidationException::withMessages([__('accounting::modules.accounting.unexcpectedError')]);
                    }


        }      

        $accountTypes = BankAccountType::all();
        return view('accounting::checks.create',$this->data,compact('accountTypes'));
    }

    public function update(Request $request)
    {
        $check=Check::findOrFail($request->id);
        if ($request->isMethod('POST')) {
            $request->validate(
                [
                    'accountType' => 'required|exists:Modules\Accounting\Entities\BankAccountType,id',
                    'number' => 'required|unique:Modules\Accounting\Entities\Check,number,'.$check->id.'|max:120',
                    'date' => 'required|date',
                    'bankName' => 'required_without:code_id|max:120',
                    'code_id' => 'required_without:bankName|exists:Modules\Accounting\Entities\Code,id',
                    'recipient' => 'required|max:120',
                    'amount' => 'required|numeric',
                    'status' => 'required|in:in,out',
                    'cashed' => 'required|in:1,0'
             ]);

                try
                {
                    $check->update(
                        [
                            'bank_account_type_id' => $request->input('accountType'),
                            'number' => $request->input('number'),
                            'date' => $request->input('date'),
                            'bankName' => $request->input('bankName')??'',
                            'code_id' => $request->input('code_id')??null,
                            'recipient' => $request->input('recipient'),
                            'amount' => $request->input('amount'),
                            'status' => $request->input('status'),
                            'cashed' => $request->input('cashed'),
                    ]);

                        return redirect(route('admin.accounting.checks.index'))
                        ->with('success', __('accounting::modules.accounting.editsuccess'));                    
                }
                catch(Exception $e)
                {
                    throw ValidationException::withMessages([__('accounting::modules.accounting.unexcpectedError')]);
                }


        }      

        $accountTypes = BankAccountType::all();
        return view('accounting::checks.edit',$this->data,compact('accountTypes','check'));

    }

    public function delete(Request $request)
    {
        (Check::findOrFail($request->id))->delete();
        return redirect(route('admin.accounting.checks.index'))
        ->with('success', __('accounting::modules.accounting.deleteSuccess'));
    }

}