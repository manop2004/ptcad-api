<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbSettingBank
 * 
 * @property int $id
 * @property string|null $bank_logo
 * @property string|null $bank_name
 * @property int $bank_show
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|TbOrderPayment[] $tb_order_payments
 * @property Collection|TbPaymentBank[] $tb_payment_banks
 *
 * @package App\Models
 */
class TbSettingBank extends Model
{
	protected $table = 'tb_setting_bank';

	protected $casts = [
		'bank_show' => 'int'
	];

	protected $fillable = [
		'bank_logo',
		'bank_name',
		'bank_show',
		'updated_by',
		'created_by'
	];

	public function tb_order_payments()
	{
		return $this->hasMany(TbOrderPayment::class, 'payment_bank');
	}

	public function tb_payment_banks()
	{
		return $this->hasMany(TbPaymentBank::class, 'bankId');
	}
}
