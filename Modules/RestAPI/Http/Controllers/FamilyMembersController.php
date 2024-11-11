<?php

namespace Modules\RestAPI\Http\Controllers;

use App\EmployeeDetails;
use App\memberDetails;
use App\SessionMember;
use App\SportAcademy;
use App\SportSession;
use App\TripMember;
use App\Trips;
use Froiden\RestAPI\ApiResponse;
use Modules\RestAPI\Http\Requests\Event\CreateRequest;
use Modules\RestAPI\Http\Requests\Event\DeleteRequest;
use Modules\RestAPI\Http\Requests\Event\IndexRequest;
use Modules\RestAPI\Http\Requests\Event\ShowRequest;
use Modules\RestAPI\Http\Requests\Event\UpdateRequest;

class FamilyMembersController extends ApiBaseController
{
    protected $model = memberDetails::class;

    protected $indexRequest = IndexRequest::class;
    protected $storeRequest = CreateRequest::class;
    protected $updateRequest = UpdateRequest::class;
    protected $showRequest = ShowRequest::class;
    protected $deleteRequest = DeleteRequest::class;

    public function index()
    {
        app()->make($this->indexRequest);
        $member=memberDetails::where('user_id',auth()->user()->id)->join('users', 'users.id' ,'=', 'member_details.user_id')->join('member_relations' , 'member_relations.id' , '=','member_details.relation_id')->select('user_id','member_details.family_id','member_details.name','users.image','member_relations.relation_name','member_id')->first();
        $allFamilyMembers=memberDetails::where('family_id',$member->family_id)->join('users', 'users.id' ,'=', 'member_details.user_id')->join('member_relations' , 'member_relations.id' , '=','member_details.relation_id')->select('user_id','member_details.name','users.image','member_relations.relation_name','member_id')->get()->except('user_id' , auth()->user()->id);
        $results = [
            'member' => $member,
            'familyMember'=>$allFamilyMembers
        ];

        return ApiResponse::make(null, $results);
    }

    public function show(...$args)
    {
        $member=memberDetails::where('user_id',$args)->join('users', 'users.id' ,'=', 'member_details.user_id')->join('member_relations' , 'member_relations.id' , '=','member_details.relation_id')->select('user_id','member_details.family_id','member_details.name','users.image','member_relations.relation_name','member_id')->first();
        $subscribedSessions=SessionMember::where('user_id',$args)->get();
        $sessions=array();
        $i=0;
        foreach ($subscribedSessions as $subscribedSession) {
            $sessions[$i] = SportSession::where('session_id', $subscribedSession->session_id)->get();
            $i++;
        }
        $subscribedEvents=TripMember::where('user_id', $args)->get();
        $events=array();
        $j=0;
        foreach ($subscribedEvents as $subscribedEvent){
            $events[$j]=Trips::find($subscribedEvent->trip_id);
            $j++;
        }
        $results = [
            'member' => $member,
            'sessions'=>$sessions,
            'events'=>$events

        ];

        return ApiResponse::make(null, $results);
    }

}