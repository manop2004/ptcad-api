<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbType
 * 
 * @property int $id
 * @property string|null $type_name
 * @property string|null $type_vat
 * @property string|null $type_withholding
 * @property int $type_show
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|TbCategory[] $tb_categories
 *
 * @package App\Models
 */
class TbType extends Model
{
	protected $table = 'tb_type';

	protected $casts = [
		'type_show' => 'int'
	];

	protected $fillable = [
		'type_name',
		'type_vat',
		'type_withholding',
		'type_show',
		'updated_by',
		'created_by'
	];

	public function tb_categories()
	{
		return $this->hasMany(TbCategory::class, 'category_type');
	}
}
