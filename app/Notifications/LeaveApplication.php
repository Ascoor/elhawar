<?php

namespace App\Notifications;

use App\EmailNotificationSetting;
use App\Leave;
use App\Traits\SmtpSettings;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class LeaveApplication extends BaseNotification
{


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $leave;
    private $emailSetting;
    public function __construct(Leave $leave)
    {
        parent::__construct();
        $this->leave = $leave;
        $this->emailSetting = EmailNotificationSetting::where('setting_name', 'New Leave Application')->first();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $via = ['database'];

        if ($this->emailSetting->send_email == 'yes' && $notifiable->email_notifications) {
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
        $user = $notifiable;
        $url = url('/');

        $smtp = \App\SmtpSetting::first();
            return (new MailMessage)
                ->from($smtp->mail_from_email , $smtp->mail_from_name)
            ->subject(__('email.leave.applied') . ' - ' . config('app.name'))
            ->greeting(__('email.hello') . ' ' . ucwords($user->name) . '!')
            ->line(__('email.leave.applied') . ':- ')
            ->line(__('app.date') . ': ' . $this->leave->leave_date->format('d M, Y'))
            ->line(__('app.status') . ': ' . ucwords($this->leave->status))
            ->action(__('email.loginDashboard'), getDomainSpecificUrl(url('/login'), $notifiable->company))
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
        return $this->leave->toArray();
    }
}
