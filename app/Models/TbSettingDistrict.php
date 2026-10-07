<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbSettingDistrict
 * 
 * @property int $id
 * @property int $dis_code
 * @property string|null $dis_name_th
 * @property string|null $dis_name_en
 * @property int|null $amphure_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property TbSettingAmphure|null $tb_setting_amphure
 * @property Collection|TbOrder[] $tb_orders
 * @property Collection|UsersAddress[] $users_addresses
 * @property Collection|UsersAddressReceipt[] $users_address_receipts
 *
 * @package App\Models
 */
class TbSettingDistrict extends Model
{
	protected $table = 'tb_setting_districts';

	protected $casts = [
		'dis_code' => 'int',
		'amphure_id' => 'int'
	];

	protected $fillable = [
		'dis_code',
		'dis_name_th',
		'dis_name_en',
		'amphure_id'
	];

	public function tb_setting_amphure()
	{
		return $this->belongsTo(TbSettingAmphure::class, 'amphure_id');
	}

	public function tb_orders()
	{
		return $this->hasMany(TbOrder::class, 'residence_district');
	}

	public function users_addresses()
	{
		return $this->hasMany(UsersAddress::class, 'district');
	}

	public function users_address_receipts()
	{
		return $this->hasMany(UsersAddressReceipt::class, 'district');
	}
}
