<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbOrderPayment
 * 
 * @property int $id
 * @property int|null $orderId
 * @property string|null $payment_slip
 * @property int|null $payment_bank
 * @property string|null $payment_bank_number
 * @property Carbon|null $payment_date
 * @property string|null $payment_time
 * @property string|null $payment_total
 * @property string|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property TbOrder|null $tb_order
 * @property TbSettingBank|null $tb_setting_bank
 *
 * @package App\Models
 */
class TbOrderPayment extends Model
{
	protected $table = 'tb_order_payment';

	protected $casts = [
		'orderId' => 'int',
		'payment_bank' => 'int'
	];

	protected $dates = [
		'payment_date'
	];

	protected $fillable = [
		'orderId',
		'payment_slip',
		'payment_bank',
		'payment_bank_number',
		'payment_date',
		'payment_time',
		'payment_total',
		'created_by'
	];

	public function tb_order()
	{
		return $this->belongsTo(TbOrder::class, 'orderId');
	}

	public function tb_setting_bank()
	{
		return $this->belongsTo(TbSettingBank::class, 'payment_bank');
	}
}
