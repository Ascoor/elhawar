<?php

namespace Modules\Accounting\Http\Controllers;
use Illuminate\Http\Request;

use Modules\Accounting\Entities\Code;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Admin\AdminBaseController;


class Codesettings extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = __('accounting::modules.accounting.sidebar.codesettings');
        $this->pageIcon = 'fa fa-money';
        $this->middleware(function ($request, $next) {
            if (!in_array('accounting', $this->modules)) {
                abort(403);
            }    // to be added after adding the accounting module inside the db table of working modules
            return $next($request);
        });
    }

    public function index($type, Request $request)
    {
    
        $pName= __('accounting::modules.accounting.sidebar.main').': '.__('accounting::modules.accounting.sidebar.codesettings');
            $this->pageTitle = $pName.'/'.Code::getCodeSettingLocale($type);

        if ($request->ajax()) {
            $query = Code::where('type', Code::getTypeEnum($type));
            return DataTables::of($query)->make(true);
        }
        $viewData=[
            'pageTitle'=>__('accounting::app.menu.codesettings').' | '.ucfirst(__('accounting::app.menu.accounting.'.$type)),
            'contentHeaderTitle'=>ucfirst(__('accounting::modules.codesettings')).' - '.ucfirst(__('accounting::modules.'.$type))];
        $viewData['type']=$type;

        return view('accounting::codesettings.index', $this->data)->with('viewData', $viewData);
    }
    public function destroy($type, $id = 'notdefinied')
    {
        $code = Code::findOrFail($id);
        $code->delete();

        return redirect(route('admin.accounting.codesettings.index', $type))
        ->with('success', __('accounting::modules.accounting.deleteSuccess'));
    }
    public function create($type)
    {
        $pName= __('accounting::modules.accounting.sidebar.main').' : '.__('accounting::modules.accounting.sidebar.codesettings');
        // if($type=='accounts'){
        //     $pName = $pName.' / '.__('accounting::modules.accounting.sidebar.codesettings_acc');
        // }elseif($type=='expenses'){
        //     $pName = $pName.' / '.__('accounting::modules.accounting.sidebar.codesettings_expen');
        // }else{
        //     $pName = $pName.' / '.__('accounting::modules.accounting.credibtorCodes');
        // }

        //rola
        if($type=='accounts'){
            $pName = $pName.' / '.__('accounting::modules.accounting.sidebar.codesettings_acc');
        }elseif($type=='expenses'){
            $pName = $pName.' / '.__('accounting::modules.accounting.sidebar.codesettings_expen');
         }
         elseif($type=='revenue'){
            $pName = $pName.' / '. __('accounting::modules.accounting.sidebar.codesettings_reven');
        }
        else{
            // if($type=='credibtors')
            $pName = $pName.' / '.__('accounting::modules.accounting.credibtorCodes');
        }


        // 'expenses'=>__('accounting::modules.accounting.sidebar.codesettings_expen'),
        // 'credibtors'=>__('accounting::modules.accounting.credibtorCodes')];

        
        $this->pageTitle =$pName.' / '.__('accounting::modules.accounting.addCode');
        $viewData=['pageTitle'=>__('accounting::modules.codesettings').' | '.__('accounting::modules.add'),
        'contentHeaderTitle'=>ucfirst(__('accounting::modules.codesettings')).' - '.__('accounting::modules.add')];
        $viewData['type']=$type;


        return view('accounting::codesettings.create',$this->data)->with('viewData', $viewData);
    }


    public function store(Request $request, $type)
    {


        $request->validate([
                'parentCode' => 'required_without:parentCodeSearch',
                'parentCodeSearch' => 'required_without:parentCode|max:45',
                'childrenCodes'=>'sometimes|array|min:1',
                'childrenCodes.*'=>'required|string|max:45|min:1'
                        ]);

        if(!empty($request->input('parentCode')))
        {
            $request->validate(
                [
                    'parentCode'=>'exists:Modules\Accounting\Entities\Code,id'
                ]
                );

            $parentCode=Code::find($request->input('parentCode'));

            if(!Code::verifyType($type))
            {
                throw ValidationException::withMessages([__('accounting::modules.codesettingsUnexcepectedError')]);
            }
            $parentCode->is_main='1';
            $parentCode->save();
        }
        
        else
        {
            try
            {
                $is_main=!is_null($request->input('childrenCodes'))?'1':'0';
                $parentCode=Code::create(
                    [
                        'name'=>$request->input('parentCodeSearch'),
                        'type'=>Code::getTypeEnum($type),
                        'is_main'=>$is_main
                    ]
                );
            }
            catch(Exception $e)
            {
                throw ValidationException::withMessages([__('accounting::modules.codesettingsUnexcepectedError')]);
            }
        }

        $maximumChilren= 5 - (int)$parentCode->level;

        if(!is_null($request->input('childrenCodes')))
        {
            $childrenCodes=$request->input('childrenCodes');
            $maximumChilren=$maximumChilren>count($childrenCodes)?count($childrenCodes):$maximumChilren;
            $childrenCodes=array_splice($childrenCodes,0,$maximumChilren);
            $lastID=$parentCode->id;

            DB::beginTransaction();

            try
            {
                foreach($childrenCodes as $key=>$code)
                {
                    $is_main= $key === array_key_last($childrenCodes)?'0':'1';

                    if($maximumChilren>0)
                    {
                        $lastID=Code::create(
                            [
                                'name'=>$code,
                                'type'=>Code::getTypeEnum($type),
                                'is_main'=>$is_main,
                                'code_id'=>is_int($lastID)?$lastID:$lastID->id
                            ]
                        );
                                                            
                    }
                }

                DB::commit();
            }
            catch (Exception $e)
            {
                DB::rollback();
                throw $e;
            }


        }
            return redirect(route('admin.accounting.codesettings.index', $type))
            ->with('success', __('accounting::modules.accounting.storesuccess'));
    }


    public function search($type, Request $request)
    {
        if (!is_null($request->input('key')) && !empty($request->input('key'))) {        
            $query['data'] = Code::where('type','=',Code::getTypeEnum($type))
            ->where('level','<','05')
            ->where(function($query) use ($request){
                return $query->where('name', 'like', '%' . $request->input('key') . '%',)
                ->orWhere('code', 'like', '%' . $request->input('key') . '%');
            })
            ->limit(50)
            ->get();
        }
        else
        {
            $query['data']=null;
        }

        return response()->json($query);
    }
}
