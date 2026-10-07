<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbSettingTransport
 * 
 * @property int $id
 * @property string|null $transport_img
 * @property string|null $transport_name
 * @property string|null $transport_link
 * @property string|null $transport_value
 * @property int $transport_show
 * @property string|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|TbOrder[] $tb_orders
 *
 * @package App\Models
 */
class TbSettingTransport extends Model
{
	protected $table = 'tb_setting_transport';

	protected $casts = [
		'transport_show' => 'int'
	];

	protected $fillable = [
		'transport_img',
		'transport_name',
		'transport_link',
		'transport_value',
		'transport_show',
		'updated_by'
	];

	public function tb_orders()
	{
		return $this->hasMany(TbOrder::class, 'transportId');
	}
}
