<?php

namespace App\Notifications;

use Ichtrojan\Otp\Otp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendOtpResetPassword extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $otp;
    public function __construct()
    {
        $this->otp = new Otp;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $generateOTP = $this->otp->generate($notifiable->email, 'numeric', 6, 5);
        return (new MailMessage)
                    ->greeting('Received code OTP verification')
                    ->line('Thank you for choosing Quraan. Use the following OTP to complete your Sign Up procedures. OTP is valid for 5 minutes')
                    ->line('Code: '.$generateOTP->token);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
