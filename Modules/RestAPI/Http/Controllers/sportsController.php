<?php

namespace Modules\RestAPI\Http\Controllers;

use App\EmployeeDetails;
use App\memberDetails;
use App\SessionMember;
use App\SportAcademy;
use App\SportSession;
use Froiden\RestAPI\ApiResponse;
use Modules\RestAPI\Http\Requests\Event\CreateRequest;
use Modules\RestAPI\Http\Requests\Event\DeleteRequest;
use Modules\RestAPI\Http\Requests\Event\IndexRequest;
use Modules\RestAPI\Http\Requests\Event\ShowRequest;
use Modules\RestAPI\Http\Requests\Event\UpdateRequest;

class sportsController extends ApiBaseController
{
    protected $model = SportAcademy::class;

    protected $indexRequest = IndexRequest::class;
    protected $storeRequest = CreateRequest::class;
    protected $updateRequest = UpdateRequest::class;
    protected $showRequest = ShowRequest::class;
    protected $deleteRequest = DeleteRequest::class;

    public function index()
    {
        app()->make($this->indexRequest);
        $sports=SportAcademy::all();
        $coaches=EmployeeDetails::where('designation_id', 1)->get();
        $results = [
            'sports' => $sports,
            'coaches'=>$coaches
        ];

        return ApiResponse::make(null, $results);
    }
    public function show(...$args)
    {
        $sports = SportAcademy::find($args);
        $i=0;
        $sportSessions=SportSession::where('sport_id' , $args)->get();
        $sessionsArray=array();
        $sportSessions_session_id=array();
        $x=0;
        $q=0;

        $subscribedSessions=array();
        $coachesIds=array();
        foreach($sportSessions as $session) {
            $coachesIds[$i] = EmployeeDetails::where('designation_id', 1)->where('user_id', $session->coach_id)->first();
            $subscribedSessions[$i]=SessionMember::where('session_id' , $session->session_id)->where('user_id' , auth()->user()->id)->first();
            if (!in_array($session->session_id,$sportSessions_session_id)) {
                $sportSessions_session_id[$q] = $session->session_id;
                $q++;
            }
            $i++;
        }
        foreach ($sportSessions_session_id as $sportSession_id){
            $sessionsArray[$x]=SportSession::where('session_id', $sportSession_id)->get();
            $x++;
        }
        $coaches=array();
        $y=0;
        foreach ($coachesIds as $coachesId){
            if (!in_array($coachesId , $coaches)) {
                $coaches[$y] =$coachesId;
                $y++;
                }
        }

        $subscribed=array();
        $j=0;
        foreach ($subscribedSessions as $subscribedSession){
            if ($subscribedSession){
            if(!in_array($subscribedSession->session_id,$subscribed)) {
                $subscribed[$j] = $subscribedSession->session_id;
                $j++;
            }
            }
        }
        $member=memberDetails::where('user_id',auth()->user()->id)->first();
        $familyMembers=memberDetails::where('family_id',$member->family_id)->select('user_id','name')->get()->except('user_id' , auth()->user()->id);

        $results = [
            'sports' => $sports,
            'coaches'=>$coaches,
            'sessions'=>$sessionsArray,
            'subscribed'=>$subscribed,
            'familyMembers'=>$familyMembers

        ];



        return ApiResponse::make(null, $results);    }
}