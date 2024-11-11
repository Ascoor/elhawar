<?php

namespace Modules\RestAPI\Http\Controllers;

use App\EmployeeDetails;
use App\SportSession;
use Froiden\RestAPI\ApiResponse;
use Modules\RestAPI\Http\Requests\Event\CreateRequest;
use Modules\RestAPI\Http\Requests\Event\DeleteRequest;
use Modules\RestAPI\Http\Requests\Event\IndexRequest;
use Modules\RestAPI\Http\Requests\Event\ShowRequest;
use Modules\RestAPI\Http\Requests\Event\UpdateRequest;

class CoachesController extends ApiBaseController
{
    protected $model = EmployeeDetails::class;

    protected $indexRequest = IndexRequest::class;
    protected $storeRequest = CreateRequest::class;
    protected $updateRequest = UpdateRequest::class;
    protected $showRequest = ShowRequest::class;
    protected $deleteRequest = DeleteRequest::class;

    public function schedule($id){
        $coach=EmployeeDetails::where('user_id' , $id)->first();
        $sessions=SportSession::where('coach_id' , $id)->get();
        $sessionsArray=array();
        $sessions_ids=array();
        $i=0;
        $j=0;
        foreach ($sessions as $session){
            if (!in_array($session->session_id,$sessions_ids)) {
                $sessions_ids[$i] =$session->session_id;
                $i++;
                }
        }
        foreach ($sessions_ids as $sessions_id){
            $sessionsArray[$j]=SportSession::where('session_id',$sessions_id)->get();
            $j++;
        }
        $results = [
            'sessions' => $sessionsArray,
            'coach'=>$coach
        ];

        return ApiResponse::make(null, $results);
    }

}