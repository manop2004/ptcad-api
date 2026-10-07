<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbSettingAmphure
 * 
 * @property int $id
 * @property int $amp_code
 * @property string|null $amp_name_th
 * @property string|null $amp_name_en
 * @property int|null $province_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property TbSettingProvince|null $tb_setting_province
 * @property Collection|TbOrder[] $tb_orders
 * @property Collection|TbSettingDistrict[] $tb_setting_districts
 * @property Collection|UsersAddress[] $users_addresses
 * @property Collection|UsersAddressReceipt[] $users_address_receipts
 *
 * @package App\Models
 */
class TbSettingAmphure extends Model
{
	protected $table = 'tb_setting_amphures';

	protected $casts = [
		'amp_code' => 'int',
		'province_id' => 'int'
	];

	protected $fillable = [
		'amp_code',
		'amp_name_th',
		'amp_name_en',
		'province_id'
	];

	public function tb_setting_province()
	{
		return $this->belongsTo(TbSettingProvince::class, 'province_id');
	}

	public function tb_orders()
	{
		return $this->hasMany(TbOrder::class, 'residence_amphures');
	}

	public function tb_setting_districts()
	{
		return $this->hasMany(TbSettingDistrict::class, 'amphure_id');
	}

	public function users_addresses()
	{
		return $this->hasMany(UsersAddress::class, 'amphures');
	}

	public function users_address_receipts()
	{
		return $this->hasMany(UsersAddressReceipt::class, 'amphures');
	}
}
