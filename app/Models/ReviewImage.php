<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewImage extends Model
{
    use HasFactory;

    /**
     * ชื่อตารางในฐานข้อมูล
     */
    protected $table = 'review_images';

    /**
     * คอลัมน์ที่อนุญาตให้แก้ไขได้
     */
    protected $fillable = [
        'review_id',
        'image_url',
    ];

    /**
     * ตามโครงสร้าง มีแค่ created_at แต่ไม่มี updated_at
     * จึงปิดการทำงาน timestamps ของ Laravel
     */
    public $timestamps = false;

    /**
     * หากต้องการให้ Laravel จัดการ created_at อัตโนมัติ
     * (แต่เนื่องจากตารางนี้ไม่มี updated_at)
     * สามารถทำแบบนี้ได้:
     *
     * const CREATED_AT = 'created_at';
     * const UPDATED_AT = null;
     */

    /**
     * ความสัมพันธ์กับตาราง reviews
     * (หนึ่ง ReviewImage สังกัด Review ใด Review หนึ่ง)
     */
    public function review()
    {
        return $this->belongsTo(Review::class, 'review_id');
    }
}
