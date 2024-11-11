<?php

namespace Modules\Accounting\Http\Controllers;
use Modules\Accounting\Entities\BudgetTerm;

use Modules\Accounting\Entities\TermItem;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Admin\AdminBaseController;
use Modules\Accounting\Entities\Code;

class BudgetTerms extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = __('accounting::modules.accounting.sidebar.budgetterms');
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
        $pName= __('accounting::modules.accounting.sidebar.budgetterms');
        if($type=='expenses'){
            $this->pageTitle = $pName.' / '.__('accounting::modules.accounting.expenses_term');
        }else{
            $this->pageTitle = $pName.' / '.__('accounting::modules.accounting.revenue_term');
        }

        if ($request->ajax()) {

            $query = BudgetTerm::select('id', 'name')
            ->withCount('items')
            ->where('type', ($type=='revenue')?'REVEN':'EXPEN');
            
            return DataTables::of($query)
            ->make(true);
        }


        $viewData=['pageTitle'=>__('accounting::modules.budgetTerms').' | '.ucfirst(__('accounting::modules.'.$type)),
        'contentHeaderTitle'=>ucfirst(__('accounting::modules.budgetTerms')).' - '.ucfirst(__('accounting::modules.'.$type))];
        $viewData['type']=$type;


        return view('accounting::budgetterms.index',$this->data)->with('viewData', $viewData);
    }

    public function destroy($type, $id = 'notdefinied')
    {

        $term = BudgetTerm::findOrFail($id);
        $term->delete();

        return redirect(route('admin.accounting.budgetterms.index', $type))
        ->with('success', __('accounting::modules.accounting.deleteSuccess'));
    }

    public function create($type)
    {
        $pName= __('accounting::modules.accounting.sidebar.budgetterms');
        if($type=='expenses'){
            $this->pageTitle = $pName.' / '.__('accounting::modules.accounting.expenses_term');
        }else{
            $this->pageTitle = $pName.' / '.__('accounting::modules.accounting.revenue_term');
        }
        $this->pageTitle =$pName.'/'.__('accounting::modules.accounting.budgetTermsAdd');

        $viewData=['pageTitle'=>__('accounting::modules.budgetTermsAdd').' | '.ucfirst(__('accounting::modules.'.$type)),
        'contentHeaderTitle'=>ucfirst(__('accounting::modules.budgetTermsAdd')).' - '.ucfirst(__('accounting::modules.'.$type))];
        $viewData['type']=$type;
        return view('accounting::budgetterms.create',$this->data)->with('viewData', $viewData);

    }

    public function store(Request $request, $type)
    {

        $term=new BudgetTerm();
        $term->validate($request,$type);

        try
        {
            $term=BudgetTerm::create(
                [
                    'name'=> $request->input('name'),
                    'type'=> ($type=='revenue')?'REVEN':'EXPEN'
                ]
                );


            foreach($request->input('codes') as $code)
            {
                TermItem::create(
                    [
                        'code_id' => $code,
                        'budget_term_id'=> $term['id']
                    ]
                    );
            }

        }
        catch(Exception $e)
        {

            throw ValidationException::withMessages([__('accounting::modules.budgetTermUnexcepectedError')]);

        }

        return redirect(route('admin.accounting.budgetterms.index', $type))
        ->with('success', __('accounting::modules.accounting.storesuccess'));

    }

    public function edit($type,$id,Request $request)
    {

        $term = BudgetTerm::findOrFail($id);

        $items = TermItem::where('budget_term_id', $id)->get();

        $viewData=['pageTitle'=>__('accounting::modules.budgetTermsEdit').' | '.ucfirst(__('accounting::modules.'.$type)),
        'contentHeaderTitle'=>ucfirst(__('accounting::modules.budgetTermsEdit')).' - '.ucfirst(__('accounting::modules.'.$type))];
        $viewData['type']=$type;
        $viewData['term']=$term;
        $viewData['items']=$items;

        return view('accounting::budgetterms.edit',$this->data)->with('viewData', $viewData);

    }

    public function update($type,$id,Request $request)
    {
        $term=BudgetTerm::findOrFail($id);
        $term->validate($request,$type,$id);
        $term->setName($request->input('name'));
        $term->save();
        if(!is_null($request->input('codes')))
        {
            foreach($request->input('codes') as $code)
            {
                try
                {
                    TermItem::create(
                        [
                            'code_id' => $code,
                            'budget_term_id'=> $term['id']
                        ]
                        );

                }
                catch(Exception $e)
                {

                    throw ValidationException::withMessages([__('accounting::modules.budgetTermUnexcepectedError')]);

                }
            }
        }


        return redirect(route('admin.accounting.budgetterms.index', $type))
        ->with('success', __('accounting::modules.accounting.editsuccess'));
    }



    public function destroyItem($type,$termID,$itemID)
    {
        $term=BudgetTerm::findOrFail($termID);
        $item=TermItem::findOrFail($itemID);
        $item->delete();

        return redirect(route('admin.accounting.budgetterms.edit', [$type, $termID]))
        ->with('success', __('accounting::modules.accounting.itemDestroyed'));
    }




    public function misc($type, Request $request)
    {
        $pName= __('accounting::modules.accounting.sidebar.budgetterms');
        if($type=='expenses'){
            $this->pageTitle = $pName.' / '.__('accounting::modules.accounting.misc_expenses_term');
        }else{
        $this->pageTitle = $pName.' / '.__('accounting::modules.accounting.misc_revenue_term');
    }


        if ($request->ajax()) {

            $exclude=array_merge(TermItem::pluck('code_id')->toArray());

            $query = Code::whereIn('type', [($type=='revenue')?'REVEN':'EXPEN','ACC'])
            ->where('is_main', '0')
            ->whereNotIn('id',$exclude);

            return DataTables::of($query)->make(true);
        }


        $viewData=['pageTitle'=>__('accounting::modules.budgetTerms').' | '.ucfirst(__('accounting::modules.misc')),
        'contentHeaderTitle'=>ucfirst(__('accounting::modules.budgetTerms')).' - '.ucfirst(__('accounting::modules.misc').' - '.ucfirst(__('accounting::modules.'.$type)))];
        $viewData['type']=$type;

        return view('accounting::budgetterms.misc',$this->data)->with('viewData', $viewData);
    }

    public function miscStore($type, Request $request)
    {

        $request->validate(
               [
                'add_to_existing' => 'required|boolean',
                'name'=>'required|max:120',
                'term'=>'required_if:add_to_existing,true',
                'codes'=>'required'
               ]

             );


        if($request->input('add_to_existing'))
        {
            $request->validate(
                [
                    'term'=>'required|exists:Modules\Accounting\Entities\BudgetTerm,id'
                ]

                );

            return $this->update($type,$request->input('term'),$request);

        }
        else
        {

            return $this->store($request,$type);

        }
    }



    public function ajax(Request $request,$type,$operation)
    {
        switch($operation)
        {
            case 'codeSearch':
                $request->validate([
                    'exclude'=>'required',
                    'key'=>'required'
                ]);

                $exclude=is_null(json_decode($request->input('exclude')))?[]:json_decode($request->input('exclude'));
                $exclude=array_merge($exclude,TermItem::pluck('code_id')->toArray());

                $query=Code::whereIn('type', [($type=='revenue')?'REVEN':'EXPEN','ACC'])
                ->where('is_main', '0')
                ->where(function($query) use ($request){
                    return $query->where('name', 'like', '%' . $request->input('key') . '%',)
                    ->orWhere('code', 'like', '%' . $request->input('key') . '%');
                })
                ->whereNotIn('id',$exclude)
                ->limit(100)
                ->get();

                return response()->json($query);

            break;

            case 'searchTerm':

                $request->validate([
                    'key'=>'required'
                ]);

                $query=BudgetTerm::select('id','name')
                ->where('type', ($type=='revenue')?'REVEN':'EXPEN')
                ->where('name', 'like', '%' . $request->input('key') . '%',)
                ->limit(100)
                ->get();

                return response()->json($query);

            break;

            default:
                abort(404);
                die();
            break;
        }
    }
}
