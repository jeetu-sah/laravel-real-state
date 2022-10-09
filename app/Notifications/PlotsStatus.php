<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PlotsStatus extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $msg;
    private $url;
    private $plotId;
    private $info;

    public function __construct($plotDetail)
    {
       $this->info = $plotDetail->msg;
       $this->msg =$this->info['msg'];
       $this->plotId =$this->info['plotId'];
       $this->url = url("admin/plots/plotDetail/$this->plotId");
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
     
        return (new MailMessage)
                    ->line($this->msg)
                    ->action('Click to check Status', $this->url)
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
         return [
            'url' =>$this->url,
            'msg' =>$this->msg,
        ];
    }
}
