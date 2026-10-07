<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbRecommendProductCategory
 * 
 * @property int $id
 * @property int $option_type
 * @property int $categoryId
 * @property string|null $recommend_product
 * @property string|null $thumb
 * @property int $show
 * @property int $sort
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class TbRecommendProductCategory extends Model
{
	protected $table = 'tb_recommend_product_category';

	protected $casts = [
		'option_type' => 'int',
		'categoryId' => 'int',
		'show' => 'int',
		'sort' => 'int'
	];

	protected $fillable = [
		'option_type',
		'categoryId',
		'recommend_product',
		'thumb',
		'show',
		'sort',
		'updated_by',
		'created_by'
	];
}
