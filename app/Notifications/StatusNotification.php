<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StatusNotification extends Notification
{
    use Queueable;

    // Menampung data yang dikirim dari Controller
    public $title;
    public $message;
    public $type; // 'success' (hijau), 'danger' (merah), atau 'info' (biru)
    public $link;

    /**
     * Create a new notification instance.
     */
    public function __construct($title, $message, $type = 'success', $link = '#')
    {
        $this->title = $title;
        $this->message = $message;
        $this->type = $type;
        $this->link = $link;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // PENTING: Ubah ini menjadi 'database' agar tersimpan di tabel notifikasi
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     * Data ini yang akan masuk ke kolom 'data' di tabel notifications (format JSON).
     *
     * @return array<string, mixed>
     */
   public function toArray($notifiable)
{
    return [
        
        'type' => $this->type,       // success / danger
        'title' => $this->title,     // Judul notif
        'message' => $this->message, // Isi pesan
        'link' => $this->link,       // Link redirect
    ];
}
}