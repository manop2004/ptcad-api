<?php

namespace App\Http\Controllers\Onepage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\crmCustomerQuotation;
use App\Mail\crmCustomerDownload;
use App\Mail\crmCustomerGeneral;
use App\Mail\crmMailSale;
use App\Models\TbSetting;

class ExtraxionController extends Controller
{
    public function index(){

        $setting = TbSetting::first();

        return view('onepages.extraxion.main',[
            'setting' => $setting
        ]);

    }
    public function crate(Request $request){

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

         //add to crm
         $campaignid     = $request->campaignid;
         $firstname      = $request->firstname;
         $description    = $request->description;
         $designation    = $request->designation;
         $mobile         = $request->mobile;
         $email          = $request->email;
         $url_path       = $request->url_path;
         $redirect       = $request->redirect;
         $industry       = $request->industry;
         $province       = $request->province;
         $mailtoteam     = $request->mailtoteam;
         $regis_type     = $request->regis_type;
         $urlreference   = $request->urlreference;
         $checkbox01     = $request->checkbox_01;
         $checkbox02     = $request->checkbox_02;

        return $this->crateCRM($designation,$checkbox01,$checkbox02,$campaignid,$firstname,$description,$mobile,$email,$url_path,$redirect ,$industry,$province,$mailtoteam,$regis_type,$urlreference);


    }

    private function crateCRM($designation,$checkbox01,$checkbox02,$campaignid,$firstname,$description,$mobile,$email,$url_path,$redirect ,$industry,$province,$mailtoteam,$regis_type,$urlreference){

        //เชคอีเมลล์ซ้ำใน Campaigns, true = หากซ้ำไม่ให้ลงทะเบียน , false = ซ้ำลงทะเบียนได้
        $checkemail = false;
        // true : ใน Campaign นึงลงได้หลายครั้งแต่จะเก็บข้อมูลใว้ที่ ตาราง app_lead_registered_history
        $landingpage = filter_input(INPUT_POST, 'landingpage')=='false' ? true : false;
        $leadstatus = 'Warm';
        $msg            = '';

        /*
        *กำหนดค่าของอีเมลล์ของ Sales
        *$sales_mailto['mailtoteam'] = email
        */
        $mailtoteam = filter_input(INPUT_POST, 'mailtoteam');

        //ขอใบเสนอราคาผ่านเว็บ
        $sales_mailto['LDP-Extraxion_8baht'] = array('8baht@applicadthai.com','arada@applicadthai.com');
        // $sales_mailto['LDP-Extraxion_8baht'] = array('napassorn_sr@applicadthai.com');

        /*
        *กำหนดค่าของประเภทของการลงทะเบียน เพื่อกำหนดอีเมลล์ที่จะส่งหาลูกค้า
        *$regis_type
        *seminar -- จะส่ง barcode ในเมลล์ให้ลูกค้าด้วย
        *quotation
        *download
        *general -- หากไม่มีการส่งค่ามา หรือส่งมาไม่ถูก จะเป็น general
        */
        $regis_type = filter_input(INPUT_POST, 'regis_type') ? filter_input(INPUT_POST, 'regis_type') : 'general';

        //กำหนด leadstatus,leadfilter ตาม regis_type
        if($regis_type=='quotation'){
            $leadstatus = 'Hot';
            // $leadfilter     = 'Junk';
            $leadfilter = 'Qualified';
        }elseif($regis_type=='seminar'){
            $checkemail = true;//หากเป็นงาน สัมนา ให้เชคอีเมลล์ด้วย
        }

        /*เอาใว้ใส่ค่า - ให้อัตโนมัติหากไม่ได้ส่งค่ามา */
        $firstname          = filter_input(INPUT_POST, 'firstname') ? filter_input(INPUT_POST, 'firstname') : '-';
        $lastname           = filter_input(INPUT_POST, 'lastname') ? filter_input(INPUT_POST, 'lastname') : '-';
        $email              = filter_input(INPUT_POST, 'email') ? filter_input(INPUT_POST, 'email') : '-';
        $company            = filter_input(INPUT_POST, 'company') ? filter_input(INPUT_POST, 'company') : '-';
        $cf_650             = filter_input(INPUT_POST, 'province') ? filter_input(INPUT_POST, 'province') : '-';
        $department         = filter_input(INPUT_POST, 'department') ? filter_input(INPUT_POST, 'department') : '-';
        $lane               = filter_input(INPUT_POST, 'lane') ? filter_input(INPUT_POST, 'lane') : '-';
        $code               = filter_input(INPUT_POST, 'code') ? filter_input(INPUT_POST, 'code') : '-';

        //สำหรับ redirect
        $redirect   = filter_input(INPUT_POST, 'redirect');

        //description
        $description = '';
        if(isset($_POST['description'])){
            foreach($_POST['description'] as $index=>$value){
                $description .=$index.' : '.$value.'';
            }
        }

        if(!empty($checkbox01) && !empty($checkbox02)){
            $checkbox = ' / โปรแกรมที่ต้องการ: - '.$checkbox01.' - '.$checkbox02;
        }else if(!empty($checkbox01) && empty($checkbox02)){
            $checkbox = ' / โปรแกรมที่ต้องการ: - '.$checkbox01;
        }else if(empty($checkbox01) && !empty($checkbox02)){
            $checkbox = ' / โปรแกรมที่ต้องการ: - '.$checkbox02;
        }

        //campaignid
        $campaignid = filter_input(INPUT_POST, 'campaignid');

        $urlreference = filter_input(INPUT_POST, 'urlreference') ? filter_input(INPUT_POST, 'urlreference') : filter_input(INPUT_POST, 'urlreferent');

        //กำหนดค่า
        $params = array(
                'campaignid'        => $campaignid, //ID ของ Campaign
                'firstname'         => $firstname,
                'lastname'          => $lastname,
                'designation'       => $designation, //ตำแหน่ง
                'cf_805'            => $department, //แผนก
                'email'             => $email,
                'company'           => $company,
                'website'           => '-',
                'industry'          => $industry,
                'leadstatus'        => $leadstatus, //leadstatus
                'leadsource'        => 'Marketing Campaign', //leadsource
                'phone'             => '-',
                'mobile'            => $mobile,
                'fax'               => '-',
                'lane'              => $lane,
                'city'              => '-',
                'cf_650'            => $cf_650, //จังหวัด
                'code'              => $code,
                'country'           => '-',
                'description'       => $description.$checkbox.' / pdpa-consent : checked',
                'cf_842'            => $leadfilter , //leads filter
                'cf_659'            => $urlreference, //Url reference
                'assigned'          => '446', // กำหนด $assigned มาโดยตรงโดยไม่อิง Campaign
                'landingpage'       => $landingpage, //ใน Campaign นึงลงได้หลายครั้งแต่จะเก็บข้อมูลใว้ที่ ตาราง app_lead_registered_history
                'checkemail'        => $checkemail, //เชคอีเมลล์ซ้ำใน Campaigns, true = หากซ้ำไม่ให้ลงทะเบียน , false = ซ้ำลงทะเบียนได้
        );

        //ทำการสร้าง Leads
        $result = $this->createlead($params);

        if($checkemail == true){

            $msg = '<p style="color:red">*** คุณลงทะเบียนในแคมเปญนี้แล้ว กรุณาตรวจสอบที่อยู่อีเมล์ของคุณ ***</p>';

            if($redirect){
                $msg .= '<a href="'.$redirect.'" class="btn btn-primary">สำเร็จ</a>';
            }
            echo $this->message_error($msg);
            exit();
        }else{

            if($result[0] == true){

                // ฟังค์ชั่น ส่งเมลล์ เซลล์
                    /*ส่งเมลล์หาลูกค้า*/
                    $name = $firstname.' '.$lastname;
                    $to[] = $email;

                    if($regis_type == "download"){

                        $downloaddes = '- ExtrAXION';
                        $downloadlink = '';
                        $description = ''; //ใส่รายละเอียดเพิ่มเติมได้ $description = '<p>.....</p>';
                        $this->mailtocustomer_download($to,$name,$result,$downloaddes,$downloadlink,$description);

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
                            $description = 'ลิงค์ที่เกี่ยวข้อง : '.$redirect;
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

                    if($regis_type=='download'){

                        $msg .= '
                        <p>ช้อมูลถูกจัดส่งเรียบร้อยแล้ว โปรดตรวจสอบที่อีเมล์ของท่าน<br>
                        ขอขอบพระคุณที่สนใจสินค้าของเราค่ะ
                        </p>
                        ';
                    }
                    if($regis_type=='download-gstartcad'){

                        $msg .= '
                        <p>ช้อมูลถูกจัดส่งเรียบร้อยแล้ว โปรดตรวจสอบที่อีเมล์ของท่าน<br>
                        ขอขอบพระคุณที่สนใจสินค้าของเราค่ะ
                        </p>
                        ';
                    }
                    if($regis_type=='contact'){

                        $msg .= '
                        <p>ข้อมูลถูกส่งไปยังเจ้าหน้าที่แล้วค่ะ</p>
                        ';
                    }

                    $msg .= '</p>';

                    if($redirect){
                        $msg .= '<a href="'.$redirect.'" class="btn btn-primary">Finish</a>';
                    }
                    echo $this->message($msg);
                    exit();

            }else{
                return false;
            }
        }

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

    private function mailtocustomer_download($to,$name='',$result=array(),$downloaddes,$downloadlink='',$description=''){

        //กำหนดคำขึ้นต้นภาษา
        $data               = new \stdClass();
        $data->name         = $name;
        $data->downloaddes  = $downloaddes;
        $data->downloadlink = $downloadlink;
        $data->description  = $description;
        $data->detail_th    = 'ท่านได้ทำการลงทะเบียนดาวน์โหลด ExtrAXION';
        $data->detail_en    = 'You have already registered for downloading ExtrAXION';
        
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


private function message($msg=""){
	$return = "
    <!doctype html>
    <html lang='en'>
      <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
        <meta name='description' content=''>
        <meta name='author' content=''>

        <title>ลงทะเบียนสำเร็จ</title>
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-P9T492V');</script>
        <!-- End Google Tag Manager -->
            <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css' integrity='sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B' crossorigin='anonymous'>
            <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.1.1/css/all.css' integrity='sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ' crossorigin='anonymous'>

        </head>
      <body class='bg-light'>
      <!-- Google Tag Manager (noscript) -->
      <noscript><iframe src='https://www.googletagmanager.com/ns.html?id=GTM-P9T492V'
      height='0' width='0' style='display:none;visibility:hidden'></iframe></noscript>
      <!-- End Google Tag Manager (noscript) -->
            <div class='container mt-5'>

            <div class='row justify-content-md-center'>
              <div class='col-sm-8'>

                        <div class='card'>
                          <div class='card-body'>
                           <h5 class='card-title text-success'><i class='fas fa-check-circle'></i> ขอบพระคุณมากค่ะ  ทางเราจะติดต่อกลับพร้อมข้อเสนอที่ดีที่สุดให้กับคุณ</h5>
                           ".$msg."
                          </div>
                        </div>

                </div>
            </div>

            </div>
      </body>
    </html>
";
return $return;
}

private function message_error($msg=""){
	$return ="
<!doctype html>
<html lang='en'>
  <head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <meta name='description' content=''>
    <meta name='author' content=''>

    <title>ลงทะเบียนไม่สำเร็จ</title>

    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-P9T492V');</script>
<!-- End Google Tag Manager -->

		<link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css' integrity='sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B' crossorigin='anonymous'>
		<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.1.1/css/all.css' integrity='sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ' crossorigin='anonymous'>
  </head>
  <body class='bg-light'>
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src='https://www.googletagmanager.com/ns.html?id=GTM-P9T492V'
  height='0' width='0' style='display:none;visibility:hidden'></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->
		<div class='container mt-5'>

		<div class='row justify-content-md-center'>
		  <div class='col-sm-6'>

					<div class='card'>
					  <div class='card-body'>
					   <h5 class='card-title text-danger'><i class='fas fa-check-circle'></i> ลงทะเบียนไม่สำเร็จ</h5>
					   ".$msg."
					  </div>
					</div>

			</div>
		</div>

		</div>
  </body>
</html>
";
return $return;

}

}
