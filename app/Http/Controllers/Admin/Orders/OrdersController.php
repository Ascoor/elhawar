<?php

namespace App\Http\Controllers\Admin\Orders;

use App\Borrowing;


use App\Notifications\NewOrder;
use App\OrdersComment;
use App\SurveyOrder;
use App\Team;
use Illuminate\Http\Request;
use App\Helper\Reply;
use App\Http\Controllers\Admin\AdminBaseController;

use App\DataTables\Admin\BorrowingsDataTable;
use App\DataTables\Admin\OrdersDataTable;
use App\MembersOrder;
use App\Project;
use App\Resource;
use App\ResourceType;
use App\User;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;


class OrdersController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'Issues';
        $this->pageIcon = 'fa fa-file';
        $this->middleware(function ($request, $next) {
            abort_if(!in_array('archives', $this->user->modules),403);
            return $next($request);
        });
        $this->middleware('permission:view_archives')->only('index','showRequests');
        $this->middleware('permission:add_archives')->only('create','store','Request','saveRequest');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
      */
    public function index(OrdersDataTable $dataTable)
    {

        $resources = DB::table('resources')->Join('resource_types','resources.type','=','resource_types.id')
        ->select('resources.*','resource_types.name as resource_type')->get();
        
        $resource_types = ResourceType::all();
        
        return $dataTable->render('admin.orders.index',$this->data,compact('resource_types' , 'resources'));
        
    }
    public function create(){
        $users = User::all();
        $teams = Team::all();
//        return $teams;
        return view("admin.orders.create",$this->data,compact('users','teams'));
    }
     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User();


        $this->validate($request,[
            'name' => 'required',
            'description'=> 'required',
            'date'=> 'required',
            'directed'=> 'required',
            'file' => 'mimes:csv,txt,xlx,xls,pdf,word,docx'
        ]);


        $user_id = $this->getUser_id();
        $today =  date("Y-m-d");

        $member_order = new MembersOrder();
        $member_order->name = $request->name;
        $member_order->description = $request->description;
        $member_order->date = $today;
        $member_order->due_date = $request->date;
        $member_order->directed_to = $request->directed;
        $member_order->created_by = $user_id;
        if($request->file()){
            $file = $request->file;
            $fileName = time().'_'.$file->getClientOriginalName();
            $file->move('uploads/orders',$fileName);

            $member_order->file = '/uploads/orders/' . $fileName;
        }
        $member_order->save();
        $directed = $this->getUsersWithDepratment($user, $request);;
        $created = DB::table('users')->where('id', '=',$this->getUser_id())->first();
        Notification::send($directed, New NewOrder($created, $member_order->id));
        return back()
            ->with('success','Order has been created.');
    }

    /**
     * Show the form for repling the specified resource.
     *
     * @param  int  $order_id
     * @return \Illuminate\Http\Response
     */
    public function reply($order){
        $member_order = $this->getOrder($order);
        $comments = $this->getComments($order);
        $details = DB::table('employee_details')->where('user_id', '=' , $this->getUser_id())->get();
        $can_reply = 0;
        foreach ($details as $detail){
            if($detail->department_id === $member_order->directed_to){
                $can_reply= 1;
            }
        }
        return view('admin.orders.reply', $this->data,compact('member_order','comments' ,'can_reply'));
    }

    public function storeReply(Request $request, $order) {
        $this->validate($request,[
            'reply'=> 'required'
        ]);
        $user_id = $this->getUser_id();
        $member_order = MembersOrder::find($order);
        if($request->closeOrder)
         $member_order->state = 1;
        $orders_comment = new OrdersComment();
        $orders_comment->order_id = $order;
        $orders_comment->comment_by = $user_id;
        $orders_comment->comment = $request->reply;
        $orders_comment->save();
        $member_order->save();
        return redirect()->back()->with("Reply Added");
    }
    public function survey($order) {
        $member_order = $this->getOrder($order);

        $vote = $this->getVote($order);
        $comments = $this->getComments($order);
        return view('admin.orders.survey', $this->data,compact('member_order','comments','vote'));
    }
    public function vote(Request $request,$order) {
        $this->validate($request,[
            'vote'=> 'required'
        ]);
        $vote = $request->vote;
        $vote_found = $this->getFirst($order);
        $column_increment = $this->getColumn_increment($vote);
        $column_decrement = $this->getColumn_decrement($vote);

        if($vote_found){
            if($vote_found->vote === $request->vote)
            {
                return redirect()->back();
            }
        }
        if($vote_found){
            $table =  DB::table('members_orders')->where('id',$order);
            $table->increment($column_increment,1);
            $table->decrement($column_decrement,1);
            SurveyOrder::where('order_id', $order)
                ->where('user_id', $this->getUser_id())
                ->update(['vote' => $vote]);
        }else{
            DB::table('members_orders')->where('id',$order)->increment($column_increment,1);
            $survey_order = new SurveyOrder();
            $survey_order->order_id = $order;
            $survey_order->user_id = $this->getUser_id();
            $survey_order->vote = $vote;
            $survey_order->save();
        }
        return redirect()->back();
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


        return Reply::success(__('messages.updatedSuccessfully'));

    }

    public function Request($request_type)
    {
        // return $this->products;
        $this->clients = User::allClients();
        
        $this->resources = Resource::all()->where("borrowable", "!=", 0);
        if($request_type === "turn_in"){
            $this->borrowed = DB::table('borrowings')->join('users','borrowings.borrower','users.id')->join('resources','borrowings.resources','resources.id')->select('borrowings.*','users.name as borrower_name','resources.name as resource_name')->get();
        }
        return view('admin.Libraries.Request', $this->data,compact('request_type'));
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
                'brrower' => 'required',
                'date'=> 'required',
                'number'=> 'required',
                'resource'=> 'required',
            ]);
            $user_id = $this->getUser_id();
            $user = \Auth::user();
            $isAdmin = $user->hasRole('admin');

            $today =  date("Y-m-d") ;

            $borrowing = new Borrowing();
            // dd($request_type);
            $borrowing->borrower = $request->brrower;
            $borrowing->due_date = $request->date;

            $borrowing->borrow_date = $today;
            $borrowing->created_by = $user_id;
            $borrowing->resources = $request->resource;
            $borrowing->borrowed = $request->number;

            $borrowing->save();
        }


        $table = DB::table('resources')->where('id',$request->resource);
        $table->decrement($columnDecreased,$request->number);
        $table->increment($columnIncreased ,$request->number);
        return Reply::redirect(route('admin.Libraries.index'), 'Resource successfully'.$request_type);

    }

    public function showRequests(BorrowingsDataTable $dataTable){
        // dd("arrived");
        $this->projects = Project::all();
        $this->clients = User::allClients();
        return  $dataTable->render('admin.Libraries.borrowings',$this->data);
    }

    /**
     * @param $order
     * @return \Illuminate\Support\Collection
     */
    public function getComments($order): \Illuminate\Support\Collection
    {
        return DB::table('orders_comments')
            ->join('users', 'users.id', '=', 'orders_comments.comment_by')
            ->where('order_id', $order)
            ->select('orders_comments.*', 'users.name as commented_by')
            ->get();
    }

    /**
     * @param $order
     * @return mixed
     */
    public function getOrder($order)
    {
        return MembersOrder::find($order)
            ->join('teams', 'teams.id', 'members_orders.directed_to')
            ->join('users as by', 'by.id', 'members_orders.created_by')
            ->select('members_orders.*', 'by.name as created', 'teams.team_name as directed')
            ->where('members_orders.id', $order)
            ->get()[0];
    }


    /**
     * @return mixed
     */
    public function getUser_id()
    {
        $user = \Auth::user();
        $user_id = $user->id;
        return $user_id;
    }

    /**
     * @param $vote
     * @return string
     */
    public function getColumn_increment($vote): string
    {
        return $vote === 'agree' ? 'ups' : 'downs';
    }

    /**
     * @param $vote
     * @return string
     */
    public function getColumn_decrement($vote): string
    {
        return $vote === "disagree" ? 'ups' : 'downs';
    }

    /**
     * @param $order
     * @return mixed
     */
    public function getFirst($order)
    {
        return SurveyOrder::where([['user_id', '=', $this->getUser_id()], ['order_id', '=', $order]])->first();
    }

    /**
     * @param $order
     * @return mixed
     */
    private function getVote($order)
    {
        $vote = $this->getFirst($order);
        if ($vote === null) {
            $vote = "agree";
            return $vote;
        }

        $vote = $vote->vote;
        return $vote;
    }

    /**
     * @param User $user
     * @param Request $request
     * @return mixed
     */
    private function getUsersWithDepratment(User $user, Request $request)
    {
        return $user->join('employee_details', 'employee_details.user_id', '=', 'users.id')->select('employee_details.*', 'users.*')->where('employee_details.department_id', '=', $request->directed)->get('employee_details.department_id', 'name');
    }
}
