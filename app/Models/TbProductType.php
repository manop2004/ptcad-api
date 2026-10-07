<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbProductType
 * 
 * @property int $id
 * @property string|null $type_name
 * @property int $type_show
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|TbProduct[] $tb_products
 *
 * @package App\Models
 */
class TbProductType extends Model
{
	protected $table = 'tb_product_type';

	protected $casts = [
		'type_show' => 'int'
	];

	protected $fillable = [
		'type_name',
		'type_show',
		'updated_by',
		'created_by'
	];

	public function tb_products()
	{
		return $this->hasMany(TbProduct::class, 'pro_type');
	}
}
