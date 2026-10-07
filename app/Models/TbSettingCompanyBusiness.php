<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbSettingCompanyBusiness
 * 
 * @property int $id
 * @property string|null $business_name
 * @property int $business_show
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class TbSettingCompanyBusiness extends Model
{
	protected $table = 'tb_setting_company_business';

	protected $casts = [
		'business_show' => 'int'
	];

	protected $fillable = [
		'business_name',
		'business_show',
		'updated_by',
		'created_by'
	];

	public function users()
	{
		return $this->hasMany(User::class, 'businessId');
	}
}
