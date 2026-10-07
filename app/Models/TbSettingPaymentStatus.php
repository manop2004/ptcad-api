<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbSettingPaymentStatus
 * 
 * @property int $id
 * @property string|null $status_name
 * @property int $status_value
 * @property string|null $status_color
 * @property string|null $status_des
 * @property int|null $show
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|TbOrder[] $tb_orders
 *
 * @package App\Models
 */
class TbSettingPaymentStatus extends Model
{
	protected $table = 'tb_setting_payment_status';

	protected $casts = [
		'status_value' => 'int',
		'show' => 'int'
	];

	protected $fillable = [
		'status_name',
		'status_value',
		'status_color',
		'status_des',
		'show'
	];

	public function tb_orders()
	{
		return $this->hasMany(TbOrder::class, 'payment_status');
	}
}
