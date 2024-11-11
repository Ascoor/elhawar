<?php

namespace App\Observers;

use App\Notification;

class NotificationObserver
{
    /**
     * Handle the notification "created" event.
     *
     * @param  \App\Notification  $notification
     * @return void
     */

    public function saving(Notification $notification)
    {
        $notification->company_id = 1;
    }

}
