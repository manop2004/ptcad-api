<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbSettingProvince
 * 
 * @property int $id
 * @property int $prov_code
 * @property string|null $prov_name_th
 * @property string|null $prov_name_en
 * @property int|null $geography_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property TbSettingGeography|null $tb_setting_geography
 * @property Collection|TbOrder[] $tb_orders
 * @property Collection|TbSettingAmphure[] $tb_setting_amphures
 * @property Collection|UsersAddress[] $users_addresses
 * @property Collection|UsersAddressReceipt[] $users_address_receipts
 *
 * @package App\Models
 */
class TbSettingProvince extends Model
{
	protected $table = 'tb_setting_provinces';

	protected $casts = [
		'prov_code' => 'int',
		'geography_id' => 'int'
	];

	protected $fillable = [
		'prov_code',
		'prov_name_th',
		'prov_name_en',
		'geography_id'
	];

	public function tb_setting_geography()
	{
		return $this->belongsTo(TbSettingGeography::class, 'geography_id');
	}

	public function tb_orders()
	{
		return $this->hasMany(TbOrder::class, 'residence_province');
	}

	public function tb_setting_amphures()
	{
		return $this->hasMany(TbSettingAmphure::class, 'province_id');
	}

	public function users_addresses()
	{
		return $this->hasMany(UsersAddress::class, 'province');
	}

	public function users_address_receipts()
	{
		return $this->hasMany(UsersAddressReceipt::class, 'province');
	}
}
