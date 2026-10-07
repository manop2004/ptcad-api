<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbPaymentBank
 * 
 * @property int $id
 * @property int|null $bankId
 * @property string|null $bank_name
 * @property string|null $bank_number
 * @property string|null $bank_branch
 * @property int $bank_show
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property TbSettingBank|null $tb_setting_bank
 *
 * @package App\Models
 */
class TbPaymentBank extends Model
{
	protected $table = 'tb_payment_bank';

	protected $casts = [
		'bankId' => 'int',
		'bank_show' => 'int'
	];

	protected $fillable = [
		'bankId',
		'bank_name',
		'bank_number',
		'bank_branch',
		'bank_show',
		'updated_by',
		'created_by'
	];

	public function tb_setting_bank()
	{
		return $this->belongsTo(TbSettingBank::class, 'bankId');
	}
}
