<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class CustomDBEmployeeNationalIdExpiration
{
    public function send($notifiable, Notification $notification)
    {
        $data = $notification->toDatabase($notifiable);

        return $notifiable->routeNotificationFor('database')->create([
            'id' => $notification->id,

            //customize here
            'Company_id' => $data['company_id'], //<-- comes from toDatabase() Method below

            'type' => get_class($notification),
            'data' => $data,
            'read_at' => null,
        ]);
    }

}
