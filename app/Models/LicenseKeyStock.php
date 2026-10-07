<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LicenseKeyStock extends Model
{
    protected $table = 'tb_license_key_stock';

    protected $fillable = [
        'detail_sku',
        'license_key',
        'status',
        'orderId',
        'used_at',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'used_at' => 'datetime',
    ];

    const STATUS_AVAILABLE = 1;
    const STATUS_USED      = 2;

    public function tb_order()
    {
        return $this->belongsTo(TbOrder::class, 'orderId');
    }
}