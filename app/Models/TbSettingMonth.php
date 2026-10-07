<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbSettingMonth
 * 
 * @property int $id
 * @property string|null $month_no
 * @property string|null $month_name_th
 * @property string|null $month_name_en
 * @property string|null $month_color
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class TbSettingMonth extends Model
{
	protected $table = 'tb_setting_month';

	protected $fillable = [
		'month_no',
		'month_name_th',
		'month_name_en',
		'month_color'
	];
}
