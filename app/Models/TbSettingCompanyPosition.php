<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbSettingCompanyPosition
 * 
 * @property int $id
 * @property string|null $position_name
 * @property int $position_show
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class TbSettingCompanyPosition extends Model
{
	protected $table = 'tb_setting_company_position';

	protected $casts = [
		'position_show' => 'int'
	];

	protected $fillable = [
		'position_name',
		'position_show',
		'updated_by',
		'created_by'
	];

	public function users()
	{
		return $this->hasMany(User::class, 'positionId');
	}
}
