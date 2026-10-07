<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbRecommendProduct
 * 
 * @property int $id
 * @property string|null $recommend_name
 * @property string|null $recommend_product
 * @property string|null $sort
 * @property int $show
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class TbRecommendProduct extends Model
{
	protected $table = 'tb_recommend_product';

	protected $casts = [
		'show' => 'int'
	];

	protected $fillable = [
		'recommend_name',
		'recommend_product',
		'sort',
		'show',
		'updated_by',
		'created_by'
	];
}
