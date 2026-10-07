<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\TbSetting;

class verifyEmailChangeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $setting = TbSetting::select('setting_nameWeb')->first();

        // [เพิ่มใหม่] เปลี่ยน Subject ตามบริบท — สมัครสมาชิก vs เปลี่ยนอีเมล
        $isRegister = ($this->data['context'] ?? 'change') === 'register';
        $subject = $isRegister
            ? 'ยืนยันการสมัครสมาชิก ' . $setting->setting_nameWeb
            : 'ยืนยันการเปลี่ยนอีเมลบัญชี ' . $setting->setting_nameWeb . ' ของคุณ';

        return $this->subject($subject)->view('emails.verifyEmailChange');
    }
}