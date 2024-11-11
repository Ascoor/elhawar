<?php

namespace App\Http\Controllers;

use App\EmployeeDetails;
use App\SessionMember;
use App\SportAcademy;
use App\SportSession;
use Froiden\RestAPI\ApiResponse;
use Modules\RestAPI\Http\Controllers\ApiBaseController;
use Modules\RestAPI\Http\Requests\Event\CreateRequest;
use Modules\RestAPI\Http\Requests\Event\DeleteRequest;
use Modules\RestAPI\Http\Requests\Event\IndexRequest;
use Modules\RestAPI\Http\Requests\Event\ShowRequest;
use Modules\RestAPI\Http\Requests\Event\UpdateRequest;

class MobileSportsController extends ApiBaseController
{
    protected $model = SportAcademy::class;

    protected $indexRequest = IndexRequest::class;
    protected $storeRequest = CreateRequest::class;
    protected $updateRequest = UpdateRequest::class;
    protected $showRequest = ShowRequest::class;
    protected $deleteRequest = DeleteRequest::class;

    public function index()
    {
//        app()->make($this->indexRequest);
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
        $sessionsArray=array();
        $sportSessions_session_id=array();
        $x=0;
        $q=0;
        $sportSession=SportSession::where('sport_id' , $args)->get();
        $coachesIds=array();
        foreach($sportSession as $session) {
            $coachesIds[$i] = EmployeeDetails::where('designation_id', 1)->where('user_id', $session->coach_id)->first();
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



        $results = [
            'sports' => $sports,
            'coaches'=>$coaches,
            'sessions'=>$sessionsArray,

        ];



        return ApiResponse::make(null, $results);    }

}