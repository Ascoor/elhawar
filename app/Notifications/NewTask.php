<?php

namespace App\Notifications;

use App\EmailNotificationSetting;
use App\PushNotificationSetting;
use App\SlackSetting;
use App\Task;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\OneSignal\OneSignalChannel;
use NotificationChannels\OneSignal\OneSignalMessage;

class NewTask extends BaseNotification
{


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $task;
    private $user;
    private $emailSetting;

    public function __construct(Task $task)
    {
        parent::__construct();
        $this->task = $task;
        $this->emailSetting = EmailNotificationSetting::where('setting_name', 'User Assign to Task')->first();
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
        $url = url('/');
        if($this->task->due_date){
        $content = ucfirst($this->task->heading) . '<p>
            <b style="color: green">' . __('app.dueOn') . ' : ' . $this->task->due_date->format('d M, Y') . '</b>
        </p>';
        }
        else{
            $content = ucfirst($this->task->heading) . '<p>
            <b style="color: green">' . __('app.dueOn') . ' : ' . '--' . '</b>
        </p>';
        }

        $smtp = \App\SmtpSetting::first();
            return (new MailMessage)
                ->from($smtp->mail_from_email , $smtp->mail_from_name)
            ->subject(__('email.newTask.subject') . ' - ' . config('app.name') . '!')
            ->greeting(__('email.hello') . ' ' . ucwords($notifiable->name) . '!')
            ->markdown('mail.task.created', ['url' => getDomainSpecificUrl($url, $notifiable->company), 'content' => $content]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return $this->task->toArray();
    }

    /**
     * Get the Slack representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return SlackMessage
     */
    public function toSlack($notifiable)
    {
        $content = ucfirst($this->task->heading) . '<p>
            <b style="color: green">' . __('app.dueDate') . ': ' . $this->task->due_date->format('d M, Y') . '</b>
        </p>';
        $slack = SlackSetting::first();
        $dueDate = '-';
        if($this->task->due_date){
            $dueDate =  $this->task->due_date->format('d M, Y');
        }
        if (count($notifiable->employee) > 0 && (!is_null($notifiable->employee[0]->slack_username) && ($notifiable->employee[0]->slack_username != ''))) {
            return (new SlackMessage())
                ->from(config('app.name'))
                ->image($slack->slack_logo_url)
                ->to('@' . $notifiable->employee[0]->slack_username)
                ->content('*' . __('email.newTask.subject') . '*' . "\n" . ucfirst($this->task->heading) . "\n" . __('app.dueDate') . ': ' . $dueDate);
        }
        return (new SlackMessage())
            ->from(config('app.name'))
            ->image($slack->slack_logo_url)
            ->content('This is a redirected notification. Add slack username for *' . ucwords($notifiable->name) . '*');
    }

    public function toOneSignal($notifiable)
    {
        return OneSignalMessage::create()
            ->subject(__('email.newTask.subject'))
            ->body($this->task->heading);
    }
}
