<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


use App\Models\TbSetting;
use App\Models\Ticket;
use App\Models\TicketFile;
use App\Models\TicketProgram;
use App\Models\HistoryTicket;
use App\Models\TbPagesMap;

class TicketController extends Controller
{
    public function TicketForUser(){

        $setting  = TbSetting::first();
        $page     = TbPagesMap::first();
        $historys = HistoryTicket::where('mailStatus',2)->get();


        if(count($historys) != 0){
            foreach($historys as $history){

                $ticket = Ticket::where('code',$history->ticketcode)->first();

                if(!empty($ticket)){
                    $ticketFile         = TicketFile::where('ticketId',$ticket->id)->get();

                    $data = new \stdClass();
                    $data->setting_nameWeb = $setting->setting_nameWeb;
                    $data->setting_logoWeb = $setting->setting_logoWeb;
                    $data->setting_email_bcc = $setting->setting_email_bcc;
                    $data->page            = $page;
                    $data->ticket          = $ticket;
                    $data->ticketFile      = $ticketFile;
                    $data->name            = $ticket->name;
                    $data->subject         = "[Ticket ID : ".$ticket->code."] ".$ticket->name;
                    $data->customer_email  = $ticket->email;

                    if(!empty($ticket->email)){

                        $emailCustomer            = explode(",",$ticket->email);
                        $data->emailCustomer      = $emailCustomer;

                        $emailSupport             = explode(",",$setting->setting_email_support);
                        $data->emailSupport       = $emailSupport;

                        if(!empty($setting->setting_email_support)){
							
							try{
								Mail::send('emails.TicketForUser', ['data' => $data], function ($m) use ($data) {
									$m->to($data->emailCustomer, $data->name)
									->bcc($data->emailSupport,'Support '.$data->setting_nameWeb)
									->replyTo($data->emailSupport, $data->setting_nameWeb)
									->subject($data->subject);

									if(!empty($data->ticketFile)){
										foreach ($data->ticketFile as $file){
											$m->attach(asset('storage/ticket/'.$file->name));
										}
									}
								});
								
								if(Mail::failures()) { $status = 2; $mailStatus = 'ล้มเหลว'; }else{ $status = 1; $mailStatus = 'สำเร็จ'; }
							}catch(\Exception $e){
								// Never reached
								$status = 2;
								$mailStatus = 'ล้มเหลว';
							}
                            
                        }else{
							
							try{
								Mail::send('emails.TicketForUser', ['data' => $data], function ($m) use ($data) {
									$m->to($data->emailCustomer, $data->name)
									->bcc($data->setting_email_bcc,'Support '.$data->setting_nameWeb)
									->replyTo($data->setting_email_bcc, $data->setting_nameWeb)
									->subject($data->subject);

									if(!empty($data->ticketFile)){
										foreach ($data->ticketFile as $file){
											$m->attach(asset('storage/ticket/'.$file->name));
										}
									}
								});
								
								if(Mail::failures()) { $status = 2; $mailStatus = 'ล้มเหลว'; }else{ $status = 1; $mailStatus = 'สำเร็จ'; }
							}catch(\Exception $e){
								// Never reached
								$status = 2;
								$mailStatus = 'ล้มเหลว';
							}
                            
                        }

                        $history                            = HistoryTicket::findOrFail($history->id);
                        $history->mailStatus                = $status;
                        $history->mailRemark                = $mailStatus;
                        $history->updated_by                = 'SYSTEM';
                        $history->created_at                = date('Y-m-d H:i:s');
                        $history->updated_at                = date('Y-m-d H:i:s');
                        $history->save();

                        return 'พบข้อมูล '.count($historys).' รายการ <br/> สถานะ '.$mailStatus ;
                    }
                }

            }
        }else{
            return 'ไม่พบข้อมูล';
        }


    }
}
