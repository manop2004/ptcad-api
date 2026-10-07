<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbPromotionOnepagesSetting
 * 
 * @property int $id
 * @property int|null $onepageId
 * @property string|null $formName
 * @property int $checklabel
 * @property string|null $formDetail
 * @property string|null $formPDPA
 * @property int $checkpdpa
 * @property string|null $bgColor
 * @property string|null $pdpaColor
 * @property string|null $fontColor
 * @property string|null $radiusForm
 * @property int $radiusTopright
 * @property int $radiusBottomright
 * @property int $radiusTopleft
 * @property int $radiusBottomleft
 * @property string|null $bgButton
 * @property string|null $wordButton
 * @property string|null $widthButton
 * @property string|null $colorButton
 * @property string|null $imageButton
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property TbPromotionOnepage|null $tb_promotion_onepage
 *
 * @package App\Models
 */
class TbPromotionOnepagesSetting extends Model
{
	protected $table = 'tb_promotion_onepages_setting';

	protected $casts = [
		'onepageId' => 'int',
		'checklabel' => 'int',
		'checkpdpa' => 'int',
		'radiusTopright' => 'int',
		'radiusBottomright' => 'int',
		'radiusTopleft' => 'int',
		'radiusBottomleft' => 'int'
	];

	protected $fillable = [
		'onepageId',
		'formName',
		'checklabel',
		'formDetail',
		'formPDPA',
		'checkpdpa',
		'bgColor',
		'pdpaColor',
		'fontColor',
		'radiusForm',
		'radiusTopright',
		'radiusBottomright',
		'radiusTopleft',
		'radiusBottomleft',
		'bgButton',
		'wordButton',
		'widthButton',
		'colorButton',
		'imageButton',
		'created_by',
		'updated_by'
	];

	public function tb_promotion_onepage()
	{
		return $this->belongsTo(TbPromotionOnepage::class, 'onepageId');
	}
}
