<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbProductCondition
 * 
 * @property int $id
 * @property string|null $condition_img
 * @property string|null $condition_name
 * @property string|null $condition_des
 * @property int $condition_show
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|TbSettingPayment[] $tb_setting_payments
 *
 * @package App\Models
 */
class TbProductCondition extends Model
{
	protected $table = 'tb_product_condition';

	protected $casts = [
		'condition_show' => 'int'
	];

	protected $fillable = [
		'condition_img',
		'condition_name',
		'condition_des',
		'condition_show',
		'updated_by',
		'created_by'
	];

	public function tb_setting_payments()
	{
		return $this->hasMany(TbSettingPayment::class, 'conditionId');
	}
}
