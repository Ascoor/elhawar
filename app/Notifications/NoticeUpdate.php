<?php

namespace App\Notifications;

use App\EmailNotificationSetting;
use App\Notice;
use App\PushNotificationSetting;
use App\SlackSetting;

use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\OneSignal\OneSignalChannel;
use NotificationChannels\OneSignal\OneSignalMessage;

class NoticeUpdate extends BaseNotification
{


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $notice;
    public function __construct(Notice $notice)
    {
        parent::__construct();
        $this->notice = $notice;
        $this->emailSetting = EmailNotificationSetting::where('setting_name', 'New Notice Published')->first();
        $this->pushNotification = PushNotificationSetting::first();
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

        if ($this->emailSetting->send_slack == 'yes') {
            array_push($via, 'slack');
        }

        if ($this->emailSetting->send_push == 'yes' && $this->pushNotification->status == 'active') {
            array_push($via, OneSignalChannel::class);
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
        if ($this->notice->attachment) {
            $smtp = \App\SmtpSetting::first();
            return (new MailMessage)
                ->from($smtp->mail_from_email , $smtp->mail_from_name)
                ->subject(__('email.noticeUpdate.subject') . ' - ' . config('app.name'))
                ->greeting(__('email.hello') . ' ' . ucwords($notifiable->name) . '!')
                ->line(__('email.noticeUpdate.text'))
                ->line(ucfirst($this->notice->heading))
                ->action(__('email.loginDashboard'), url('/'))
                ->line(__('email.thankyouNote'))
                ->attach(public_path() . '/user-uploads/notice-attachment/' . $this->notice->attachment);
        } else {
            $smtp = \App\SmtpSetting::first();
            return (new MailMessage)
                ->from($smtp->mail_from_email , $smtp->mail_from_name)
                ->subject(__('email.noticeUpdate.subject') . ' - ' . config('app.name'))
                ->greeting(__('email.hello') . ' ' . ucwords($notifiable->name) . '!')
                ->line(__('email.noticeUpdate.text'))
                ->line(ucfirst($this->notice->heading))
                ->action(__('email.loginDashboard'), url('/'))
                ->line(__('email.thankyouNote'));
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return $this->notice->toArray();
    }

    /**
     * Get the Slack representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return SlackMessage
     */
    public function toSlack($notifiable)
    {
        $slack = SlackSetting::setting();
        if (count($notifiable->employee) > 0 && (!is_null($notifiable->employee[0]->slack_username) && ($notifiable->employee[0]->slack_username != ''))) {
            return (new SlackMessage())
                ->from(config('app.name'))
                ->image($slack->slack_logo_url)
                ->to('@' . $notifiable->employee[0]->slack_username)
                ->content('*' . __('email.noticeUpdate.subject') . ' : ' . ucfirst($this->notice->heading) . '*' . "\n" . $this->notice->description);
        }
        return (new SlackMessage())
            ->from(config('app.name'))
            ->image($slack->slack_logo_url)
            ->content('This is a redirected notification. Add slack username for *' . ucwords($notifiable->name) . '*');
    }

    public function toOneSignal($notifiable)
    {
        return OneSignalMessage::create()
            ->subject(__('email.noticeUpdate.subject'))
            ->body($this->notice->heading);
    }
}
