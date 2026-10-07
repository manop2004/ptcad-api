<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbSettingHotsearch
 * 
 * @property int $id
 * @property string|null $hotsearch_name
 * @property string|null $hotsearch_url
 * @property int $hotsearch_show
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class TbSettingHotsearch extends Model
{
	protected $table = 'tb_setting_hotsearch';

	protected $casts = [
		'hotsearch_show' => 'int'
	];

	protected $fillable = [
		'hotsearch_name',
		'hotsearch_url',
		'hotsearch_show',
		'updated_by',
		'created_by'
	];
}
