<?php

namespace Modules\RestAPI\Http\Controllers;

use App\Trips;
use Froiden\RestAPI\ApiResponse;
use Modules\RestAPI\Http\Requests\Event\CreateRequest;
use Modules\RestAPI\Http\Requests\Event\DeleteRequest;
use Modules\RestAPI\Http\Requests\Event\IndexRequest;
use Modules\RestAPI\Http\Requests\Event\ShowRequest;
use Modules\RestAPI\Http\Requests\Event\UpdateRequest;

class GalleryController extends ApiBaseController
{
    protected $model = Trips::class;
    protected $indexRequest = IndexRequest::class;
    protected $storeRequest = CreateRequest::class;
    protected $updateRequest = UpdateRequest::class;
    protected $showRequest = ShowRequest::class;
    protected $deleteRequest = DeleteRequest::class;

    public function index()
    {
        app()->make($this->indexRequest);
        $events=Trips::all();
        $photos=array();
        $i=0;
        foreach ($events as $event){
        $photos[$i]=$event->image;
        $i++;
        }
        $results = [
            'photos'=>$photos
        ];

        return ApiResponse::make(null, $results);
    }

}