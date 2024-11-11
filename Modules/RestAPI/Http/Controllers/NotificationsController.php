<?php

namespace Modules\RestAPI\Http\Controllers;

use App\User;
use Froiden\RestAPI\ApiResponse;
use Illuminate\Notifications\DatabaseNotification;
use Modules\RestAPI\Http\Requests\Event\CreateRequest;
use Modules\RestAPI\Http\Requests\Event\DeleteRequest;
use Modules\RestAPI\Http\Requests\Event\IndexRequest;
use Modules\RestAPI\Http\Requests\Event\ShowRequest;
use Modules\RestAPI\Http\Requests\Event\UpdateRequest;

class NotificationsController extends ApiBaseController
{
    protected $model = DatabaseNotification::class;

    protected $indexRequest = IndexRequest::class;
    protected $storeRequest = CreateRequest::class;
    protected $updateRequest = UpdateRequest::class;
    protected $showRequest = ShowRequest::class;
    protected $deleteRequest = DeleteRequest::class;

    public function index()
    {
        app()->make($this->indexRequest);
        $user=User::find(auth()->user()->id);
        $notifications=$user->unreadNotifications;
        $results = [

            'notifications'=>$notifications

        ];



        return ApiResponse::make(null, $results);

    }
    public function markRead($id){
        $notification=DatabaseNotification::find($id);
        $notification->markAsRead();
        return ApiResponse::make(__('messages.notificationRead'));
    }

}