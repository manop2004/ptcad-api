<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbLevel
 * 
 * @property int $id
 * @property string|null $name
 * @property int|null $number
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|TbLevelMenu[] $tb_level_menus
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class TbLevel extends Model
{
	protected $table = 'tb_level';

	protected $casts = [
		'number' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'name',
		'number',
		'status'
	];

	public function tb_level_menus()
	{
		return $this->hasMany(TbLevelMenu::class, 'level');
	}

	public function users()
	{
		return $this->hasMany(User::class, 'level');
	}
}
