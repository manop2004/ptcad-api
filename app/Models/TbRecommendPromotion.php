<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbRecommendPromotion
 * 
 * @property int $id
 * @property string|null $recommend_type
 * @property string|null $recommend_link
 * @property string|null $recommend_note
 * @property string|null $recommend_thumb
 * @property string|null $recommend_sort
 * @property int $show
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class TbRecommendPromotion extends Model
{
	protected $table = 'tb_recommend_promotion';

	protected $casts = [
		'show' => 'int'
	];

	protected $fillable = [
		'recommend_type',
		'recommend_link',
		'recommend_note',
		'recommend_thumb',
		'recommend_sort',
		'show',
		'updated_by',
		'created_by'
	];
}
