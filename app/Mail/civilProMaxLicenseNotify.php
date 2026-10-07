<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class civilProMaxLicenseNotify extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject('ส่งมอบ License Key - Civil ProMax (Order: ' . $this->data->order->orderNumber . ')')
            ->view('emails.civilPromaxLicenseNotify');
    }
}