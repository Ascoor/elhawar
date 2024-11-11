<?php

namespace Modules\Accounting\Http\Controllers;

use App\Http\Controllers\Admin\AdminBaseController;
use Modules\Accounting\Entities\AssetDeprecation;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Modules\Accounting\DataTables\AssetsDeprecationsDataTable;

class AssetsDeprecations extends AdminBaseController {

    public function __construct()
    {
        parent::__construct();
        //Fail-safe page titile
        $this->pageTitle='Assets Deprecations';
        $this->pageIcon = 'fa fa-money';
        $this->middleware(function ($request, $next) {
            //localize Page title based on current locale
            $this->pageTitle = __('accounting::modules.accounting.assetsDeprecations');
            if (!in_array('accounting', $this->modules)) {
                abort(403);
            }    // to be added after adding the accounting module inside the db table of working modules
            return $next($request);
        });
    }

    public function index(AssetsDeprecationsDataTable $dataTable)
    {

        return $dataTable->render('accounting::assetsdeprecations.index',$this->data);

    }

    public function create(Request $request)
    {
        if ($request->isMethod('POST')) 
        {

            $request->validate(
                [
                    'code_id' => 'required|unique:Modules\Accounting\Entities\AssetDeprecation,code_id',
                    'numberOfYears' => 'required|numeric',
                    'precentageOfDeprecation' => 'required|numeric',
                ]
                );

            try
            {
                AssetDeprecation::create(
                    [
                        'code_id' => $request->input('code_id'),
                        'numberOfYears' =>  $request->input('numberOfYears'),
                        'precentageOfDeprecation' =>  $request->input('precentageOfDeprecation'),    
                    ]
                    );

                    return redirect(route('admin.accounting.assetsdeprecations.index'))
                    ->with('success', __('accounting::modules.accounting.storesuccess'));                    
            }
            catch(Exception $e)
            {
                throw ValidationException::withMessages([__('accounting::modules.accounting.unexcpectedError')]);
            }
 
                
        }      
        
        return view('accounting::assetsdeprecations.create',$this->data);
    }

    public function update(Request $request)
    {
        $assetDeprecation=AssetDeprecation::findOrFail($request->id);

        if ($request->isMethod('POST')) {
            $request->validate(
                [
                    'code_id' => 'required|unique:Modules\Accounting\Entities\AssetDeprecation,code_id,'.$assetDeprecation->id,
                    'numberOfYears' => 'required|numeric',
                    'precentageOfDeprecation' => 'required|numeric',
                ]
                );

                try
                {
                    $assetDeprecation->update(
                        [
                            'code_id' => $request->input('code_id'),
                            'numberOfYears' =>  $request->input('numberOfYears'),
                            'precentageOfDeprecation' =>  $request->input('precentageOfDeprecation'),    
                        ]
                        );

                        return redirect(route('admin.accounting.assetsdeprecations.index'))
                        ->with('success', __('accounting::modules.accounting.editsuccess'));                    
                }
                catch(Exception $e)
                {
                    throw ValidationException::withMessages([__('accounting::modules.accounting.unexcpectedError')]);
                }

            
        }      

        return view('accounting::assetsdeprecations.edit',$this->data,compact('assetDeprecation'));
    }


    public function delete(Request $request)
    {
        (AssetDeprecation::findOrFail($request->id))->delete();

        return redirect(route('admin.accounting.assetsdeprecations.index'))
        ->with('success', __('accounting::modules.accounting.deleteSuccess'));
    }



}
