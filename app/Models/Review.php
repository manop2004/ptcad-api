<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    /**
     * ชื่อตารางในฐานข้อมูล
     */
    protected $table = 'reviews';

    /**
     * คอลัมน์ที่อนุญาตให้แก้ไขได้ (mass assignment)
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'order_id',
        'rating',
        'review_text',
        'image_url',
        'video_url',
        'review_approved',
        'approval_id',
        'approval_at',
        // created_at และ updated_at Laravel จะจัดการให้เอง
    ];

    /**
     * กำหนดการแปลงชนิดข้อมูล (ถ้าต้องการให้ rating เป็น float)
     */
    protected $casts = [
        'rating' => 'float',
        'approval_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * ความสัมพันธ์กับตาราง review_images
     * (หนึ่ง Review มีได้หลาย ReviewImage)
     */
    public function images()
    {
        return $this->hasMany(ReviewImage::class, 'review_id');
    }
}
