<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbSettingPopup
 * 
 * @property int $id
 * @property int $popup_type
 * @property string|null $popup_detail
 * @property string|null $popup_img
 * @property int $sizeModel
 * @property int $popup_show
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class TbSettingPopup extends Model
{
	protected $table = 'tb_setting_popup';

	protected $casts = [
		'popup_type' => 'int',
		'sizeModel' => 'int',
		'popup_show' => 'int'
	];

	protected $fillable = [
		'popup_type',
		'popup_detail',
		'popup_img',
		'sizeModel',
		'popup_show',
		'updated_by',
		'created_by'
	];
}
