<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\TbSetting;

class getmemberToNewMember extends Mailable
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
        return $this->subject('คุณได้รับของขวัญต้อนรับสมาชิกใหม่ | '.$setting->setting_nameWeb)->view('emails.getmemberToNewMember');
    }
}
