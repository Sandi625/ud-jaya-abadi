<?php

// app/Notifications/PesananBaruNotification.php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PesananBaruNotification extends Notification
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Pesanan Baru Masuk')
            ->greeting('Hai Admin,')
            ->line('Ada pesanan baru yang masuk.')
            ->line('Nama: ' . $this->data['nama'])
            ->line('Email: ' . $this->data['email'])
            ->line('No. Telp: ' . $this->data['nomor_telp'])
            ->line('Tanggal Pesan: ' . $this->data['tanggal_pesan'])
            ->line('Tanggal Keberangkatan: ' . $this->data['tanggal_keberangkatan'])
            ->line('Jumlah Peserta: ' . $this->data['jumlah_peserta'])
            ->line('Silakan cek sistem untuk info lengkap.');
    }
}
