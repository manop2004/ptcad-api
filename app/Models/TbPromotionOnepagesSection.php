<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbPromotionOnepagesSection
 * 
 * @property int $id
 * @property int|null $onepageId
 * @property string|null $name
 * @property string|null $bgColor
 * @property string|null $section
 * @property string|null $sort
 * @property string|null $detail
 * @property string|null $images
 * @property int $show
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property TbPromotionOnepage|null $tb_promotion_onepage
 *
 * @package App\Models
 */
class TbPromotionOnepagesSection extends Model
{
	protected $table = 'tb_promotion_onepages_section';

	protected $casts = [
		'onepageId' => 'int',
		'show' => 'int'
	];

	protected $fillable = [
		'onepageId',
		'name',
		'bgColor',
		'section',
		'sort',
		'detail',
		'images',
		'show',
		'created_by',
		'updated_by'
	];

	public function tb_promotion_onepage()
	{
		return $this->belongsTo(TbPromotionOnepage::class, 'onepageId');
	}
}
