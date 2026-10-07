<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Models\TbSetting;

use App\Mail\crmCustomerQuotation;
use App\Mail\crmCustomerDownload;
use App\Mail\crmCustomerGeneral;
use App\Mail\crmMailSale;

class CrmapplicadthaiController extends Controller
{

    private function validateDefult($request){

        $request->validate(
            [
                'firstname' => 'required',
                'mobile' => 'required',
                'email' => 'required|email',
            ],
            [
                'firstname.required' => 'กรุณากรอกข้อมูล',
                'mobile.required' => 'กรุณากรอกข้อมูล',
                'email.required' => 'กรุณากรอกข้อมูล',
                'email.email' => 'รูปแบบอีเมลไม่ถูกต้องกรุณาตรวจสอบอีเมล',
            ]
        );

    }

    private function validateAdobe($request){

        $request->validate(
            [
                'firstname' => 'required',
                'designation' => 'required',
                'mobile' => 'required',
                'email' => 'required|email',
            ],
            [
                'firstname.required' => 'กรุณากรอกข้อมูล',
                'designation.required' => 'กรุณากรอกข้อมูล',
                'mobile.required' => 'กรุณากรอกข้อมูล',
                'email.required' => 'กรุณากรอกข้อมูล',
                'email.email' => 'รูปแบบอีเมลไม่ถูกต้องกรุณาตรวจสอบอีเมล',
            ]
        );

    }

    private function validateExtraxion($request){

        $request->validate(
            [
                'firstname' => 'required',
                'mobile' => 'required',
                'designation' => 'required',
                'email' => 'required|email',
            ],
            [
                'firstname.required' => 'กรุณากรอกข้อมูล',
                'mobile.required' => 'กรุณากรอกข้อมูล',
                'designation.required' => 'กรุณากรอกข้อมูล',
                'email.required' => 'กรุณากรอกข้อมูล',
                'email.email' => 'รูปแบบอีเมลไม่ถูกต้องกรุณาตรวจสอบอีเมล',
            ]
        );

    }

    private function validateGstarcad($request){

        $request->validate(
            [
                'firstname' => 'required',
                'email' => 'required|email',
                'designation' => 'required',
                'mobile' => 'required',
            ],
            [
                'firstname.required' => 'กรุณากรอกข้อมูล',
                'email.required' => 'กรุณากรอกข้อมูล',
                'email.email' => 'รูปแบบอีเมลไม่ถูกต้องกรุณาตรวจสอบข้อมูล!',
                'designation.required' => 'กรุณาเลือกข้อมูล',
                'mobile.required' => 'กรุณากรอกข้อมูล',
            ]
        );

    }

    public function crate(Request $request){

        if($request->page == 'adobe'){

           $this->validateAdobe($request);

        }else if($request->page == 'extraxion'){

            $this->validateExtraxion($request);

        }else if($request->page == 'gstarcad'){

            $this->validateGstarcad($request);

        }else{

            $this->validateDefult($request);

        }

        //add to crm
        $campaignid     = $request->campaignid;
        $mailtoteam     = $request->mailtoteam;
        $regis_type     = $request->regis_type;
        $firstname      = $request->firstname ? $request->firstname : $request->name;
        $lastname       = $request->lastname ? $request->lastname : '-';
        $email          = $request->email;
        $mobile         = $request->tel;
        $description    = $request->description;
        $designation    = $request->designation;
        $department     = $request->department;
        $industry       = $request->industry ? $request->industry : $request->industry;
        $company        = $request->company;
        $code           = $request->code;
        $cf_650         = $request->cf_650;
        $lane           = $request->lane;
        $mobile         = $request->mobile;
        $website        = $request->website;
        $phone          = $request->phone;
        $fax            = $request->fax;
        $city           = $request->city;
        $country        = $request->country;
        //set defult
        $assigned       = $request->assigned;
        $redirect       = $request->redirect;
        $og_keywords    = $request->og_keywords;
        $og_description = $request->og_description;
        $og_image       = $request->og_image;
        $urlreference   = $request->urlreference;
        $checkemail     = $request->checkemail;

        return $this->crateCRM($checkemail,$og_keywords,$og_description,$og_image,$campaignid,$mailtoteam,$regis_type,$firstname,$lastname,$email,$description,$designation,$department,$code,$industry,$company,$cf_650,$lane,$mobile,$website,$phone,$fax,$city,$country,$assigned,$urlreference,$redirect);

    }

    public function crateCRM($checkemail,$og_keywords,$og_description,$og_image,$campaignid,$mailtoteam,$regis_type,$firstname,$lastname,$email,$description,$designation,$department,$code,$industry,$company,$cf_650,$lane,$mobile,$website,$phone,$fax,$city,$country,$assigned,$urlreference,$redirect){

        $sales_mailto['Test_Web_master'] = array('napassorn_sr@applicadthai.com');
        $sales_mailto['dowload_gstartcad_free_trial_8b'] = array('webmaster@applicadthai.com','arada@applicadthai.com', 'amnaj@applicadthai.com');
        $sales_mailto['LDP_GstarCAD_on_8baht'] = array('webmaster@applicadthai.com','yukonthorn_ta@applicadthai.com', 'amnaj@applicadthai.com');
        $sales_mailto['LDP-ADOBE_8baht'] = array('webmaster@applicadthai.com','8baht@applicadthai.com','arada@applicadthai.com');
        $sales_mailto['LDP-Extraxion_8baht'] = array('webmaster@applicadthai.com','8baht@applicadthai.com','arada@applicadthai.com');

        $checkemail     = $checkemail ? $checkemail : false;
        // true : ใน Campaign นึงลงได้หลายครั้งแต่จะเก็บข้อมูลใว้ที่ ตาราง app_lead_registered_history
        $landingpage    = filter_input(INPUT_POST, 'landingpage')=='false' ? true : false;
        $leadstatus     = $regis_type == 'quotation' ? 'Hot' : 'Warm';
        $leadfilter     = $regis_type == 'quotation' ? 'Qualified' : 'Non-Qualified';
        // $leadfilter     = 'Junk';

        /*เอาใว้ใส่ค่า - ให้อัตโนมัติหากไม่ได้ส่งค่ามา */
        $firstname      = $firstname ? $firstname : '-';
        $lastname       = $lastname ? $lastname : '-';
        $designation    = $designation ? $designation : '-';
        $department     = $department ? $department : '-';
        $email          = $email ? $email : '-';
        $company        = $company ? $company : '-';
        $website        = $website ? $website : '-';
        $industry       = $industry ? $industry : '-';
        $phone          = $phone ? $phone : '-';
        $mobile         = $mobile ? $mobile : '-';
        $fax            = $fax ? $fax : '-';
        $lane           = $lane ? $lane : '-';
        $city           = $city ? $city : '-';
        $cf_650         = $cf_650 ? $cf_650 : '-';
        $code           = $code ? $code : '-';
        $country        = $country ? $country : '-';
        $assigned       = $assigned ? $assigned : '75';

        $urlreference   = $urlreference ? $urlreference : $urlreference;
        //สำหรับ redirect
        $redirect       = $redirect;
        $msg            = $description;

        //กำหนดค่า
        $params = array(
            'campaignid'        => $campaignid, //ID ของ Campaign
            'firstname'         => $firstname,
            'lastname'          => $lastname,
            'designation'       => $designation, //ตำแหน่ง
            'cf_805'            => $department, //แผนก
            'email'             => $email,
            'company'           => $company,
            'website'           => $website,
            'industry'          => $industry,
            'leadstatus'        => $leadstatus, //leadstatus
            'leadsource'        => 'Marketing Campaign', //leadsource
            'phone'             => $phone,
            'mobile'            => $mobile,
            'fax'               => $fax,
            'lane'              => $lane,
            'city'              => $city,
            'cf_650'            => $cf_650, //จังหวัด
            'code'              => $code,
            'country'           => $country,
            'description'       => json_encode( $msg, JSON_UNESCAPED_UNICODE ),
            'cf_842'            => $leadfilter , //leads filter
            'cf_659'            => $urlreference, //Url reference
            //'assigned'          => $assigned, // กำหนด $assigned มาโดยตรงโดยไม่อิง Campaign
            'landingpage'       => $landingpage, //ใน Campaign นึงลงได้หลายครั้งแต่จะเก็บข้อมูลใว้ที่ ตาราง app_lead_registered_history
            'checkemail'        => $checkemail, //เชคอีเมลล์ซ้ำใน Campaigns, true = หากซ้ำไม่ให้ลงทะเบียน , false = ซ้ำลงทะเบียนได้
        );

        if($checkemail == true){
            $existingLeads =  $this->ExistingLeads($email,$campaignid);
            if(!empty($existingLeads)){

                $msg = '<p style="color:red">*** คุณลงทะเบียนในแคมเปญนี้แล้ว กรุณาตรวจสอบอีเมล์ของคุณ ***</p>';

                if($redirect){
                    $msg .= '<br/><a href="'.$redirect.'" class="btn btn-primary">ย้อนกลับหน้าหลัก</a>';
                }

                $page_name = 'คุณลงทะเบียนในแคมเปญนี้แล้ว | ';

                return view('layouts.temp_thankyou',[
                    'title' => $page_name,
                    'og_site_name' => $page_name,
                    'og_title' => $page_name,
                    'og_keywords' => $og_keywords,
                    'og_description' => $og_description,
                    'og_url' => $redirect,
                    'og_image' => $og_image,
                    'msg' => $msg,
                ]);

            }
        }

        //ทำการสร้าง Leads
        $result = $this->createlead($params);

        if($result[0] == true){

            // ฟังค์ชั่น ส่งเมลล์ เซลล์
            /*ส่งเมลล์หาลูกค้า*/
            $name = $firstname.' '.$lastname;
            $to[] = $email;

            if($regis_type == "download-gstar"){

                $downloaddes    = '- GstarCAD 2025 SP0 Bu241023';
                $downloadlink   = 'https://app-service.synology.me:8080/sharing/icJd9DLsQ';
                $description    = ''; //ใส่รายละเอียดเพิ่มเติมได้ $description = '<p>.....</p>';
                $detail_th      = 'ท่านได้ทำการลงทะเบียนดาวน์โหลด GstarCAD 2025 SP0 Bu241023';
                $detail_en      = 'You have already registered for downloading GstarCAD 2025 SP0 Bu241023';
                $this->mailtocustomer_download($to,$name,$result,$downloaddes,$downloadlink,$description,$detail_th,$detail_en);

            }else if($regis_type == "quotation"){

                $description = ''; //ใส่รายละเอียดเพิ่มเติมได้ $description = '<p>.....</p>';
                $this->mailtocustomer_quotation($to,$name,$result,$description);

            }else{

                $description = ''; //ใส่รายละเอียดเพิ่มเติมได้ $description = '<p>.....</p>';
                $this->mailtocustomer_general($to,$name,$result,$description);

            }
			
            /*ส่งเมลล์หา Sales*/
			
            if(isset($sales_mailto[$mailtoteam])){
                $description = ''; //ใส่รายละเอียดเพิ่มเติมได้ $description = '<p>.....</p>';
                if($redirect){
                    $description = 'ลิ้งค์ที่เกี่ยวข้อง : '.$redirect;
                }
                //หากลงทะเบียนซ้ำในหน้า Landingpage เดียวกัน
                if(!isset($result[19])&&$landingpage==true){
                    $result[22] = $result[0];
                    $result[23] = '-';
                    $result[24] = $result[1];
                    $description .= '<p style="color:red">*** ลูกค้าท่านนี้ลงทะเบียนซ้ำในหน้า Landingpage เดียวกัน เช่น ขอใบเสนอราคา แล้วมาดาวน์โหลดโปรแกรมต่อ เป็นต้น ให้คลิกดูรายละเอียดการลงทะเบียนในแท็บ Register History On Same Campaign ในหน้า Leads Detail ***</p>';
                }
                // ฟังค์ชั่น ส่งเมลล์ เซลล์

                $this->mailtosales($sales_mailto[$mailtoteam],$params,$result[22],$result[23],$result[24],$description);
            }
			
			$msg = '<p>ขอขอบคุณที่ท่านให้ความสนใจในผลิตภัณฑ์ของเรา<br>บริษัทฯ ได้รับข้อมูลของท่านแล้ว ทางเราจะติดต่อกลับให้เร็วที่สุด</p>';
			
			if($redirect){
				$msg .= '<br/><a href="'.$redirect.'" class="btn btn-primary">ย้อนกลับหน้าหลัก</a>';
			}
            
            $page_name = 'ขอบคุณสำหรับการลงทะเบียน | ';

            return view('layouts.temp_thankyou',[
                'title' => $page_name,
                'og_site_name' => $page_name,
                'og_title' => $page_name,
                'og_keywords' => $og_keywords,
                'og_description' => $og_description,
                'og_url' => $redirect,
                'og_image' => $og_image,
                'msg' => $msg,
            ]);

        }else{

            $msg .= '<p style="color:red">*** คุณลงทะเบียนไม่สำเร็จ กรุณาตรวจสอบข้อมูลและทำการลงทะเบียนใหม่อีกครั้ง ***</p>';

            if($redirect){
                $msg .= '<br/><a href="'.$redirect.'" class="btn button-thankyou">ย้อนกลับหน้าหลัก</a>';
            }

            $page_name = 'ลงทะเบียนไม่สำเร็จ | ';

            return view('layouts.temp_thankyou',[
                'title' => $page_name,
                'og_site_name' => $page_name,
                'og_title' => $page_name,
                'og_keywords' => $og_keywords,
                'og_description' => $og_description,
                'og_url' => $redirect,
                'og_image' => $og_image,
                'msg' => $msg,
            ]);
        }

    }

    public function getProvince(){
        // [Mock สำหรับโปรเจกต์จบ] เดิมยิง SOAP ไป CRM จริงของบริษัท ตอนนี้ return ว่างแทน
        return [];
    }

    public function getIndustry(){
        // [Mock สำหรับโปรเจกต์จบ] เดิมยิง SOAP ไป CRM จริงของบริษัท ตอนนี้ return ว่างแทน
        return [];
    }

    private function ExistingLeads($email,$campaignid){
        // [Mock สำหรับโปรเจกต์จบ] เดิมเช็คอีเมลซ้ำกับ CRM จริงของบริษัท
        // ตอนนี้ถือว่าไม่เคยลงทะเบียนซ้ำเสมอ (return 'null') เพื่อให้ flow ทำงานต่อได้
        return 'null';
    }

    private function createlead($params=array()){
        // [Mock สำหรับโปรเจกต์จบ] เดิมยิง SOAP สร้าง Lead ไป CRM จริงของบริษัท
        // ตอนนี้จำลองว่าสร้างสำเร็จเสมอ โดยไม่ยิง request ออกไปจริง
        \Log::info('[Mock CRM] createlead called', $params);
        return [true, 'MOCK-LEAD-' . uniqid()];
    }

    private function mailtocustomer_quotation($to,$name='',$result=array(),$description=''){

        //กำหนดคำขึ้นต้นภาษา
        $data               = new \stdClass();
        $data->dear         = "เรียน คุณ ";
        $data->name         = $name;
        $data->description  = $description;

		try{
			Mail::to($to)->later(now()->addMinutes(5), new crmCustomerQuotation($data));
		}catch(\Exception $e){
			// Never reached
		}

    }

    private function mailtocustomer_download($to,$name='',$result=array(),$downloaddes,$downloadlink='',$description='',$detail_th='',$detail_en=''){

        //กำหนดคำขึ้นต้นภาษา
        $data               = new \stdClass();
        $data->name         = $name;
        $data->downloaddes  = $downloaddes;
        $data->downloadlink = $downloadlink;
        $data->description  = $description;
        $data->detail_th    = $detail_th;
        $data->detail_en    = $detail_en;
        
		try{
			Mail::to($to)->later(now()->addMinutes(5), new crmCustomerDownload($data));
		}catch(\Exception $e){
			// Never reached
		}

    }

    private function mailtocustomer_general($to,$name='',$result=array(),$description=''){

        //กำหนดคำขึ้นต้นภาษา
        $data               = new \stdClass();
        $data->dear         = '';
        $data->name         = $name;
        $data->description  = $description;

		try{
			Mail::to($to)->later(now()->addMinutes(5), new crmCustomerGeneral($data));
		}catch(\Exception $e){
			// Never reached
		}
    }

    private function mailtosales($to,$result,$id='',$no='',$campaignname='',$description=''){

        $data                = new \stdClass();
        $data->id            = $id;
        $data->no            = $no;
        $data->campaignname  = $campaignname;
        $data->description   = $description;
        $data->result        = $result;
        
		try{
			Mail::to($to)->later(now()->addMinutes(5), new crmMailSale($data));
		}catch(\Exception $e){
			// Never reached
		}
    }

}
