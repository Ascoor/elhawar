<?php

namespace App\Notifications;

use App\Issue;
use App\OfflinePlanChange;
use Illuminate\Notifications\Messages\MailMessage;

class OfflinePackageChangeConfirmation extends BaseNotification
{


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $planChange;
    public function __construct(OfflinePlanChange $planChange)
    {
        parent::__construct();
        $this->planChange = $planChange;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $via = array();
        if ($notifiable->email_notifications) {
            array_push($via, 'mail');
        }
        return $via;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $smtp = \App\SmtpSetting::first();
            return (new MailMessage)
                ->from($smtp->mail_from_email , $smtp->mail_from_name)
            ->subject(__('email.offlinePackageChangeVerify.subject'))
            ->greeting(__('email.hello') . '!')
            ->line(__('email.offlinePackageChangeVerify.text'))
            ->line(__('email.offlinePackageChangeVerify.message', ['package' => $this->planChange->package->name . ' (' . $this->planChange->package_type . ')']))
            ->line(__('email.thankyouNote'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return $this->planChange->toArray();
    }
}
