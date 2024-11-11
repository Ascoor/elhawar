<?php

namespace Modules\Accounting\Notifications;

use App\Traits\SmtpSettings;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\Accounting\Entities\DailyRecord;

class NewDailyRecord extends Notification implements ShouldQueue
{
    use Queueable, SmtpSettings;

    private $dailyRecord;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($dailyRecord)
    {
        $this->dailyRecord=$dailyRecord;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject(__('accounting::modules.accounting.dailyrecords'))
                    ->line(__('accounting::modules.accounting.newDailyRecordAdded'))
                    ->line(__('accounting::modules.accounting.journalEntryNo').' : ' .$this->dailyRecord->journalEntryNo )
                    ->line(__('accounting::modules.accounting.date').' : ' .$this->dailyRecord->date )
                    ->action(__('accounting::modules.accounting.preview'), route('admin.accounting.dailyrecords.index',$this->dailyRecord->type))
                    ->line(__('email.thankyouNote'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
