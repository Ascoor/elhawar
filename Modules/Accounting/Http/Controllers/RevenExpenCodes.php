<?php

namespace Modules\Accounting\Http\Controllers;
use App\Http\Controllers\Admin\AdminBaseController;
use Illuminate\Http\Request;
use Modules\Accounting\Entities\RevenExpenCode;

class RevenExpenCodes extends AdminBaseController {

    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            if (!in_array('accounting', $this->modules)) {
                abort(403);
            }    // to be added after adding the accounting module inside the db table of working modules
            $this->pageTitle = __('accounting::modules.accounting.revenexpencodes');
            $this->pageIcon = 'fa fa-money';
    
            return $next($request);
        });
    }

    public function index()
    {
        $this->data['codes']=RevenExpenCode::get();
        return view('accounting::revenexpencodes.index', $this->data);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('POST')) 
        {
            $request->validate(
                [
                    'code_id' => 'required|exists:Modules\Accounting\Entities\Code,id',
                ]);

            RevenExpenCode::create(['code_id'=>$request->code_id]);

            return redirect(route('admin.accounting.revenexpencodes'))
            ->with('success', __('accounting::modules.accounting.storesuccess'));
        }

        return view('accounting::revenexpencodes.create', $this->data);

    }

    public function delete(Request $request)
    {
        (RevenExpenCode::findOrFail($request->id))->delete();
        return redirect(route('admin.accounting.revenexpencodes'))
        ->with('success', __('accounting::modules.accounting.deleteSuccess'));
    }

}
