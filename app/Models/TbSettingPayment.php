<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbSettingPayment
 * 
 * @property int $id
 * @property int $bank_transfer_status
 * @property int $credit_card_status
 * @property int $installment_status
 * @property int|null $conditionId
 * @property int $omise_status
 * @property string|null $omise_public_key_for_live
 * @property string|null $omise_secret_key_for_live
 * @property string|null $omise_public_key_for_test
 * @property string|null $omise_secret_key_for_test
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property TbProductCondition|null $tb_product_condition
 *
 * @package App\Models
 */
class TbSettingPayment extends Model
{
	protected $table = 'tb_setting_payment';

	protected $casts = [
		'bank_transfer_status' => 'int',
		'credit_card_status' => 'int',
		'installment_status' => 'int',
		'conditionId' => 'int',
		'omise_status' => 'int'
	];

	protected $hidden = [
		'omise_secret_key_for_live',
		'omise_secret_key_for_test'
	];

	protected $fillable = [
		'bank_transfer_status',
		'credit_card_status',
		'installment_status',
		'conditionId',
		'omise_status',
		'omise_public_key_for_live',
		'omise_secret_key_for_live',
		'omise_public_key_for_test',
		'omise_secret_key_for_test',
		'updated_by',
		'created_by'
	];

	public function tb_product_condition()
	{
		return $this->belongsTo(TbProductCondition::class, 'conditionId');
	}
}
