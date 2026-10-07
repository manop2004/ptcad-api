<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbSoftware
 * 
 * @property int $id
 * @property int|null $userId
 * @property string|null $serial_number
 * @property string|null $productCode
 * @property Carbon|null $date_start
 * @property Carbon|null $date_exp
 * @property string|null $price
 * @property string|null $note
 * @property int $show
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User|null $user
 * @property Collection|TbSoftwareNotify[] $tb_software_notifies
 *
 * @package App\Models
 */
class TbSoftware extends Model
{
	protected $table = 'tb_software';

	protected $casts = [
		'userId' => 'int',
		'show' => 'int'
	];

	protected $dates = [
		'date_start',
		'date_exp'
	];

	protected $fillable = [
		'userId',
		'serial_number',
		'productCode',
		'date_start',
		'date_exp',
		'price',
		'note',
		'show',
		'created_by',
		'updated_by'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'userId');
	}

	public function tb_software_notifies()
	{
		return $this->hasMany(TbSoftwareNotify::class, 'softwareId');
	}
}
