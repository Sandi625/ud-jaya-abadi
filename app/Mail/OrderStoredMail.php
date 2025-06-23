<?php
namespace App\Mail;

use App\Models\Pesanan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderStoredMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pesanan;

    public function __construct($pesanan)
    {
        $this->pesanan = $pesanan;
    }

    public function build()
    {
        return $this->from('sandipermadi625@gmail.com')
                    ->subject('Pesanan Baru Telah Masuk')
                    ->markdown('emails.order_stored');
    }
}
