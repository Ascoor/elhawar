<?php

namespace App\Http\Controllers;

use App\EmployeeDetails;
use App\Notice;
use App\SportAcademy;
use App\SportSession;
use Froiden\RestAPI\ApiResponse;
use Modules\RestAPI\Http\Controllers\ApiBaseController;
use Modules\RestAPI\Http\Requests\Event\CreateRequest;
use Modules\RestAPI\Http\Requests\Event\DeleteRequest;
use Modules\RestAPI\Http\Requests\Event\IndexRequest;
use Modules\RestAPI\Http\Requests\Event\ShowRequest;
use Modules\RestAPI\Http\Requests\Event\UpdateRequest;

class MobileNoticeController extends ApiBaseController
{
    protected $model = Notice::class;

    protected $indexRequest = IndexRequest::class;
    protected $storeRequest = CreateRequest::class;
    protected $updateRequest = UpdateRequest::class;
    protected $showRequest = ShowRequest::class;
    protected $deleteRequest = DeleteRequest::class;

    public function index()
    {
        app()->make($this->indexRequest);
        $notices=Notice::where('to','member')->get();
        $results = [
            'notices' => $notices,
        ];

        return ApiResponse::make(null, $results);
    }
    public function show(...$args)
    {
        $notice = Notice::find($args);



        $results = [
            'notice' => $notice,
        ];



        return ApiResponse::make(null, $results);    }


}