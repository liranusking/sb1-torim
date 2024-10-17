<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentReminder extends Notification
{
    use Queueable;

    protected $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Appointment Reminder')
            ->line('This is a reminder for your upcoming appointment.')
            ->line('Service: ' . $this->appointment->service->name)
            ->line('Date: ' . $this->appointment->start_time->format('Y-m-d H:i'))
            ->action('View Appointment', url('/appointments/' . $this->appointment->id))
            ->line('Thank you for using our service!');
    }
}