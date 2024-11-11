<?php

namespace Modules\Sms\Http\Traits;


trait WhatsappMessageTrait
{
    public function toWhatsapp($notifiable, $messageBody)
    {
        $settings = sms_setting();
    
        if (!$settings->whatsapp_status) {
            return true;
        }
    
        // تحقق من البيانات
        if (!$notifiable->country || !$notifiable->mobile) {
            return false; // أو تسجيل رسالة خطأ
        }
    
        $toNumber = '+'.$notifiable->country->phonecode.$notifiable->mobile;
        $fromNumber = $settings->whatapp_from_number;
    
        // تحقق من إعدادات Twilio
        if (!$settings->account_sid || !$settings->auth_token || !$fromNumber) {
            return false; // أو تسجيل رسالة خطأ
        }
    
        $twilio = new \Twilio\Rest\Client($settings->account_sid, $settings->auth_token);
    
        $twilio->messages
            ->create(
                "whatsapp:$toNumber", // to 
                [
                    "from" => "whatsapp:$fromNumber",
                    "body" => $messageBody
                ]
            );
    }
}    
