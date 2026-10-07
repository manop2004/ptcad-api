<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbTypeSetting
 * 
 * @property int $id
 * @property int $vat
 * @property int $status
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class TbTypeSetting extends Model
{
	protected $table = 'tb_type_setting';

	protected $casts = [
		'vat' => 'int',
		'show' => 'int'
	];

	protected $fillable = [
		'vat',
		'show',
		'created_by',
		'updated_by'
	];
}
