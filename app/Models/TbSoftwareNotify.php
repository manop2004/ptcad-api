<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbSoftwareNotify
 * 
 * @property int $id
 * @property int|null $userId
 * @property int|null $softwareId
 * @property int|null $orderId
 * @property string|null $serial_number
 * @property string|null $productCode
 * @property Carbon|null $date_start
 * @property Carbon|null $date_exp
 * @property string|null $price
 * @property string|null $note
 * @property int $show
 * @property int $status
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property TbOrder|null $tb_order
 * @property TbSoftware|null $tb_software
 * @property User|null $user
 *
 * @package App\Models
 */
class TbSoftwareNotify extends Model
{
	protected $table = 'tb_software_notify';

	protected $casts = [
		'userId' => 'int',
		'softwareId' => 'int',
		'orderId' => 'int',
		'show' => 'int',
		'status' => 'int'
	];

	protected $dates = [
		'date_start',
		'date_exp'
	];

	protected $fillable = [
		'userId',
		'softwareId',
		'orderId',
		'serial_number',
		'productCode',
		'date_start',
		'date_exp',
		'price',
		'note',
		'show',
		'status',
		'created_by',
		'updated_by'
	];

	public function tb_order()
	{
		return $this->belongsTo(TbOrder::class, 'orderId');
	}

	public function tb_software()
	{
		return $this->belongsTo(TbSoftware::class, 'softwareId');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'userId');
	}
}
