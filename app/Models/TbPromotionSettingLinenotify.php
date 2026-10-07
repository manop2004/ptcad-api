<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbPromotionSettingLinenotify
 * 
 * @property int $id
 * @property string|null $groupname
 * @property string|null $token_linenotify
 * @property int $grouptype1
 * @property int $grouptype2
 * @property int $show
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class TbPromotionSettingLinenotify extends Model
{
	protected $table = 'tb_promotion_setting_linenotify';

	protected $casts = [
		'grouptype1' => 'int',
		'grouptype2' => 'int',
		'show' => 'int'
	];

	protected $fillable = [
		'groupname',
		'token_linenotify',
		'grouptype1',
		'grouptype2',
		'show',
		'created_by',
		'updated_by'
	];
}
