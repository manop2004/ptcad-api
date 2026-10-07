<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * รัน migration นี้ด้วยคำสั่ง: php artisan migrate
     * ถ้าไม่แน่ใจว่าตาราง settings/hero_banners ชื่อจริงว่าอะไร
     * เช็คได้จาก Model: App\Models\TbSetting และ App\Models\TbHeroBanner
     * (เปิดไฟล์ Model ดู $table property ถ้ามีกำหนดไว้ ถ้าไม่มีจะใช้ชื่อตาราง
     * แบบ snake_case พหูพจน์ตามชื่อ Model โดย default ของ Laravel)
     */
    public function up(): void
    {
        // ปุ่ม "Remote" ในหน้าแรก ส่วน SUPPORT
        Schema::table('tb_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('tb_settings', 'setting_remoteLink')) {
                $table->string('setting_remoteLink')->nullable()->after('setting_idLine');
            }
        });

        // ลิงก์ปุ่มต่างๆในหน้าแรก ที่ยัง hardcode อยู่ ให้แก้ได้จาก Hero Banner settings
        Schema::table('tb_hero_banners', function (Blueprint $table) {
            if (!Schema::hasColumn('tb_hero_banners', 'member_access_link')) {
                $table->string('member_access_link')->nullable();
            }
            if (!Schema::hasColumn('tb_hero_banners', 'trial_download_link')) {
                $table->string('trial_download_link')->nullable();
            }
            if (!Schema::hasColumn('tb_hero_banners', 'business_quote_link')) {
                $table->string('business_quote_link')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('tb_settings', function (Blueprint $table) {
            $table->dropColumn('setting_remoteLink');
        });

        Schema::table('tb_hero_banners', function (Blueprint $table) {
            $table->dropColumn(['member_access_link', 'trial_download_link', 'business_quote_link']);
        });
    }
};
