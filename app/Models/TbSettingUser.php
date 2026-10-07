<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbSettingUser
 * 
 * @property int $id
 * @property int $pdpa_status
 * @property string|null $pdpa_detail
 * @property int $business_status
 * @property int $position_status
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class TbSettingUser extends Model
{
	protected $table = 'tb_setting_user';

	protected $casts = [
		'pdpa_status' => 'int',
		'business_status' => 'int',
		'position_status' => 'int'
	];

	protected $fillable = [
		'pdpa_status',
		'pdpa_detail',
		'business_status',
		'position_status',
		'updated_by',
		'created_by'
	];
}
