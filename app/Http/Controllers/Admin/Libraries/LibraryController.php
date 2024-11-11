<?php

namespace App\Http\Controllers\Admin\Libraries;

use App\Borrowing;
use App\DataTables\Admin\LibrariesDataTable;

use Illuminate\Http\Request;
use App\Helper\Reply;
use App\Http\Controllers\Admin\AdminBaseController;
use App\Invoice;
use App\InvoiceSetting;
use App\Currency;
use App\DataTables\Admin\BorrowingsDataTable;
use App\Tax;
use App\Product;
use App\Project;
use App\Resource;
use App\ResourceType;
use App\User;
use Illuminate\Support\Facades\DB;
use stdClass;

class LibraryController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'Libraries';
        $this->pageIcon = 'fa fa-book';
        $this->middleware(function ($request, $next) {
            abort_if(!in_array('libraries', $this->user->modules),403);
            return $next($request);
        });
        $this->middleware('permission:add_libraries')->only('create','store');
        $this->middleware('permission:edit_libraries')->only('edit','update');
        $this->middleware('permission:view_libraries')->only('showRequests','index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(LibrariesDataTable $dataTable)
    {
        // dd("arrived");
        $resources = DB::table('resources')->Join('resource_types','resources.type','=','resource_types.id')
        ->select('resources.*','resource_types.name as resource_type')->get();
        
        $resource_types = ResourceType::all();
        
        return $dataTable->render('admin.Libraries.index',$this->data,compact('resource_types'));
        
    }
    public function create(){
        $resource_types = ResourceType::all();
        // return($resource_types);
        return view("admin.Libraries.create",$this->data,compact('resource_types'));
    }
     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $this->validate($request,[
            'name' => 'required',
            'description'=> 'required',
            'number'=> 'required',
            'type'=> 'required',
            'borrowable'=> 'required'
        ]);
        $new_resource = new Resource();
        $new_resource->name = $request->name;
        $new_resource->description = $request->description;
        $new_resource->item_in_stock = $request->number;
        $new_resource->type = $request->type;
        $new_resource->borrowable = $request->borrowable;
        $new_resource->save();
        return redirect()->back();

    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $resource = Resource::find($id);
        $resource_types = ResourceType::all();
        
        return view('admin.Libraries.edit', $this->data,compact('resource','resource_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        $this->validate($request,[
            'name' => 'required',
            'description'=> 'required',
            'number'=> 'required',
            'type'=> 'required',
            'borrowable'=> 'required'
        ]);
        $new_resource = Resource::find($id);
        $new_resource->name = $request->name;
        $new_resource->description = $request->description;
        $new_resource->item_in_stock = $request->number;
        $new_resource->type = $request->type;
        $new_resource->borrowable = $request->borrowable;
        $new_resource->save();
        // return redirect()->back();

        return Reply::success(__('messages.updatedSuccessfully'));

    }

    
    public function Request($request_type)
    {


        $this->clients = User::allClients();
        $this->employees=User::allEmployees();
        $this->projects = Project::whereNotNull('client_id')->get();
        $this->currencies = Currency::all();
        $this->resources = Resource::all()->where("borrowable", "!=", 0);
        //  return $this->resources;F
        if($request_type === "turn_in"){
            $this->borrowed = DB::table('borrowings')->join('users','borrowings.borrower','users.id')->join('resources','borrowings.resources','resources.id')->select('borrowings.*','users.name as borrower_name','resources.name as resource_name')->get();
//             return $this->borrowed;
        }
        return view('admin.Libraries.request', $this->data,compact('request_type'));
    }
    public function saveRequest(Request $request, $request_type){

        $columnIncreased = $request_type === "turn_in" ? "item_in_stock" : $request_type;
        $columnDecreased = $request_type === "turn_in" ? "borrowed": "item_in_stock";
        if($request_type === "turn_in"){
//            return $request;
            $this->validate($request,[
                'borrower_select' => 'required',
                'number'=> 'required',
                'resource'=> 'required'
            ]);
            $borrowing  =  Borrowing::find($request->borrower_select);
            $borrowing->turn_in = 1;
            $borrowing->save();
        }
        else{

            $this->validate($request,[
                'user_id' => 'required',
                'date'=> 'required',
                'number'=> 'required',
                'resource'=> 'required',

            ]);
            $user =  \Auth::user();



            $user_id = $user->id;
            $isAdmin = $user->hasRole('admin');

            $today =  date("Y-m-d") ;

            $borrowing = new Borrowing();
            // dd($request_type);
            $borrowing->borrower = $request->user_id;
            $borrowing->due_date = $request->date;

            $borrowing->borrow_date = $today;
            $borrowing->created_by = $user_id;
            $borrowing->resources = $request->resource;
            $borrowing->borrowed = $request->number;
            $borrowing->approved = 1;
            $borrowing->approved_by = 1;


            $borrowing->save();
        }


        $table = DB::table('resources')->where('id',$request->resource);
        $table->decrement($columnDecreased,$request->number);
        $table->increment($columnIncreased ,$request->number);
        return Reply::redirect(route('admin.libraries.index'), 'Resource successfully'.$request_type);

    }

    public function showRequests(BorrowingsDataTable $dataTable){
        // dd("arrived");
        $this->projects = Project::all();
        $this->clients = User::allClients();
        return  $dataTable->render('admin.Libraries.borrowings',$this->data);
    }
}
