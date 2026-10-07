<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UsersAddressReceipt
 * 
 * @property int $id
 * @property int|null $userId
 * @property int $type
 * @property string|null $taxid
 * @property string|null $company
 * @property string|null $branch
 * @property string|null $name
 * @property string|null $lastname
 * @property string|null $tel
 * @property string|null $address
 * @property int|null $province
 * @property int|null $amphures
 * @property int|null $district
 * @property string|null $zipcode
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property TbSettingAmphure|null $tb_setting_amphure
 * @property TbSettingDistrict|null $tb_setting_district
 * @property TbSettingProvince|null $tb_setting_province
 * @property User|null $user
 *
 * @package App\Models
 */
class UsersAddressReceipt extends Model
{
	protected $table = 'users_address_receipt';

	protected $casts = [
		'userId' => 'int',
		'type' => 'int',
		'province' => 'int',
		'amphures' => 'int',
		'district' => 'int'
	];

	protected $fillable = [
		'userId',
		'type',
		'taxid',
		'company',
		'branch',
		'name',
		'lastname',
		'tel',
		'address',
		'province',
		'amphures',
		'district',
		'zipcode',
		'updated_by',
		'created_by'
	];

	public function tb_setting_amphure()
	{
		return $this->belongsTo(TbSettingAmphure::class, 'amphures');
	}

	public function tb_setting_district()
	{
		return $this->belongsTo(TbSettingDistrict::class, 'district');
	}

	public function tb_setting_province()
	{
		return $this->belongsTo(TbSettingProvince::class, 'province');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'userId');
	}
}
