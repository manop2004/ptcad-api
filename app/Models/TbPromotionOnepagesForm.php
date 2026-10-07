<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbPromotionOnepagesForm
 * 
 * @property int $id
 * @property string|null $field
 * @property string|null $fieldTH
 * @property string|null $type
 * @property string|null $col
 * @property string|null $sort
 * @property int|null $onepageId
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property TbPromotionOnepage|null $tb_promotion_onepage
 *
 * @package App\Models
 */
class TbPromotionOnepagesForm extends Model
{
	protected $table = 'tb_promotion_onepages_form';

	protected $casts = [
		'onepageId' => 'int'
	];

	protected $fillable = [
		'field',
		'fieldTH',
		'type',
		'col',
		'sort',
		'onepageId',
		'created_by',
		'updated_by'
	];

	public function tb_promotion_onepage()
	{
		return $this->belongsTo(TbPromotionOnepage::class, 'onepageId');
	}
}
