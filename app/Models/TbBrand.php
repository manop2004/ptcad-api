<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbBrand
 * 
 * @property int $id
 * @property string|null $brand_name
 * @property string|null $brand_permalink
 * @property string|null $brand_img
 * @property int $brand_recommend
 * @property int $brand_show
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|TbProduct[] $tb_products
 *
 * @package App\Models
 */
class TbBrand extends Model
{
	protected $table = 'tb_brand';

	protected $casts = [
		'brand_recommend' => 'int',
		'brand_show' => 'int'
	];

	protected $fillable = [
		'brand_name',
		'brand_permalink',
		'brand_img',
		'brand_recommend',
		'brand_show',
		'updated_by',
		'created_by'
	];

	public function tb_products()
	{
		return $this->hasMany(TbProduct::class, 'pro_brand');
	}
}
