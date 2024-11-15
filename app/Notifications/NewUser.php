<?php

namespace App\Notifications;

use App\EmailNotificationSetting;
use App\SlackSetting;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;

class NewUser extends BaseNotification
{


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $password;
    private $emailSetting;
    public function __construct($password)
    {
        parent::__construct();
        $this->password = $password;
        $this->emailSetting = EmailNotificationSetting::where('setting_name', 'User Registration/Added by Admin')->first();
    }

    /**
     * Get the notification's delivery channels.
     *t('mail::layout')
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $via = ['database'];

        if ($this->emailSetting->send_email == 'yes' && $notifiable->email_notifications) {
            array_push($via, 'mail');
        } else if (
            request()->has('sendMail') && request('sendMail') == 'yes'
            && request()->has('sendMail') && request('email_notifications') == 1
        ) {
            array_push($via, 'mail');
        }

        if ($this->emailSetting->send_slack == 'yes') {
            array_push($via, 'slack');
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
            ->subject(__('email.newUser.subject') . ' ' . config('app.name') . '!')
            ->greeting(__('email.hello') . ' ' . ucwords($notifiable->name) . '!')
            ->line(__('email.newUser.text'))
            ->line('Email: ' . $notifiable->email)
            ->line('Password:  ' . $this->password)
            ->action(__('email.loginDashboard'), getDomainSpecificUrl(route('login'), $notifiable->company))
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
        return $notifiable->toArray();
    }

    /**
     * Get the Slack representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return SlackMessage
     */
    public function toSlack($notifiable)
    {
        $slack = SlackSetting::first();
        try{
            if (count($notifiable->employee) > 0 && !is_null($notifiable->employee[0]->slack_username)) {
                return (new SlackMessage())
                    ->from(config('app.name'))
                    ->image($slack->slack_logo_url)
                    ->to('@' . $notifiable->employee[0]->slack_username)
                    ->content('Welcome to ' . config('app.name') . '! Your account has been created successfully.');
            }
            return (new SlackMessage())
                ->from(config('app.name'))
                ->image($slack->slack_logo_url)
                ->content('This is a redirected notification. Add slack username for *' . ucwords($notifiable->name) . '*');
        }catch(\Exception $e){
            return false;
        }
       
    }
}
