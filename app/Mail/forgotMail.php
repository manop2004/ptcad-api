<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\TbSetting;

class forgotMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $setting = TbSetting::select('setting_nameWeb')->first();
        return $this->subject('กู้รหัสผ่านบัญชีผู้ใช้ '.$setting->setting_nameWeb.' ของคุณ')->view('emails.forgotMember');
    }
}
