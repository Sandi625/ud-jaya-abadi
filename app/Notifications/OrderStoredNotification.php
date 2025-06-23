<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class OrderStoredNotification extends Notification
{
    use Queueable;

    protected $pesanan;

    public function __construct($pesanan)
    {
        $this->pesanan = $pesanan;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Pesanan baru telah disimpan!')
                    ->line('Nama Pemesan: ' . $this->pesanan->nama)
                    ->line('Email: ' . $this->pesanan->email)
                    ->line('Nomor Telp: ' . $this->pesanan->nomor_telp)
                    ->line('Paket: ' . $this->pesanan->paket->nama)
                    ->action('Lihat Pesanan', url('/admin/pesanan')) // Sesuaikan URL sesuai kebutuhan
                    ->line('Terima kasih telah menggunakan layanan kami!');
    }

    public function toArray($notifiable)
    {
        return [
            'pesanan_id' => $this->pesanan->id,
        ];
    }
}
