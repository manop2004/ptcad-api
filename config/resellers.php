<?php

/**
 * config/resellers.php
 *
 * รายชื่อ reseller ทั้งหมดที่ใช้หน้า "ทดลองใช้ PTCAD" เวอร์ชันของตัวเอง
 * เพิ่ม reseller ใหม่ในอนาคต แค่เพิ่ม array ใหม่ในนี้ ไม่ต้องสร้างไฟล์ Controller ใหม่
 *
 * slug           = ใช้ในลิงก์ เช่น /reseller/amido/trial
 * name           = ชื่อที่โชว์ในอีเมล/แคมเปญ
 * notify_emails  = อีเมลทีม reseller ที่จะรับแจ้งเตือนลูกค้าใหม่ (array, ใส่ได้หลายอีเมล)
 * use_crm        = true = เก็บ Lead เข้า CRM ด้วย, false = ไม่เก็บ (ส่งแค่อีเมล 2 ทาง)
 * campaign_id    = เลข Campaign ID ของระบบ Lead API (ใส่เฉพาะตอน use_crm = true)
 *                   ต้องขอเลขนี้จากผู้ดูแลระบบ Lead API ก่อน ไม่ใช่สร้างเองใน vtiger ตรงๆ
 */

return [

    // ===== รอบนี้ (Amido) - ใช้งานจริง =====
    'amido' => [
        'name'          => 'Amido',
        'notify_emails' => ['chaiwat@amidothai.com', 'Sales@amidothai.com', 'Mkt@amidothai.com'],
        'use_crm'       => true,
        'campaign_id'   => 12447, // Campaign "ดาวน์โหลด_ทดลองใช้_Amido" ใน vtiger
    ],

    // ===== เพิ่ม reseller รายอื่นทีหลังได้ตามแบบนี้ (ยังไม่เปิดใช้ตอนนี้) =====
    // 'kanyway' => [
    //     'name'          => 'Kanyway',
    //     'notify_emails' => ['chaiwat@kanyway.com'],
    //     'use_crm'       => false,
    //     'campaign_id'   => null,
    // ],
    // 'tripleugroup' => [
    //     'name'          => 'Tripleugroup',
    //     'notify_emails' => ['PTCADbytripleugroup@gmail.com', 'Tripleugroup.company@gmail.com'],
    //     'use_crm'       => false,
    //     'campaign_id'   => null,
    // ],

];