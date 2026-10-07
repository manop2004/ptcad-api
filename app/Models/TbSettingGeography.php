<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbSettingGeography
 * 
 * @property int $id
 * @property string|null $geo_name_th
 * @property string|null $geo_name_en
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|TbSettingProvince[] $tb_setting_provinces
 *
 * @package App\Models
 */
class TbSettingGeography extends Model
{
	protected $table = 'tb_setting_geographies';

	protected $fillable = [
		'geo_name_th',
		'geo_name_en'
	];

	public function tb_setting_provinces()
	{
		return $this->hasMany(TbSettingProvince::class, 'geography_id');
	}
}
