<?php

namespace Modules\Accounting\Http\Controllers;

use App\Http\Controllers\Admin\AdminBaseController;
use Illuminate\Http\Request;
use Modules\Accounting\Entities\AccountingSetting;

class Capital extends AdminBaseController {

    public function index(Request $request)
    {
        $this->pageTitle = __('accounting::modules.accounting.capital');
        $this->pageIcon = 'fa fa-money';

        $capital=AccountingSetting::first()->capital;

        if($request->isMethod('post'))
        {
            $request->validate(
                [
                    'capital'=> 'required|numeric'
                ]
                );
            $s=AccountingSetting::first();
            $s->update(['capital'=>$request->input('capital')]);
            $capital=AccountingSetting::first()->capital;

            return View('accounting::capital.index',compact('capital'))->with($this->data);
        }
        
        return View('accounting::capital.index',compact('capital'))->with($this->data);
    }
}
