<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbPromotionOnepage
 * 
 * @property int $id
 * @property string|null $name
 * @property string|null $campaignid
 * @property string $assigned
 * @property string|null $parmalink
 * @property string|null $mailtoteam
 * @property string|null $regis_type
 * @property string|null $checkemail
 * @property string|null $og_keywords
 * @property string|null $og_description
 * @property string|null $og_image
 * @property int $show
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|TbPromotionOnepagesForm[] $tb_promotion_onepages_forms
 * @property Collection|TbPromotionOnepagesSetting[] $tb_promotion_onepages_settings
 *
 * @package App\Models
 */
class TbPromotionOnepage extends Model
{
	protected $table = 'tb_promotion_onepages';

	protected $casts = [
		'show' => 'int'
	];

	protected $fillable = [
		'name',
		'campaignid',
		'assigned',
		'parmalink',
		'mailtoteam',
		'regis_type',
		'checkemail',
		'og_keywords',
		'og_description',
		'og_image',
		'show',
		'created_by',
		'updated_by'
	];

	public function tb_promotion_onepages_forms()
	{
		return $this->hasMany(TbPromotionOnepagesForm::class, 'onepageId');
	}

	public function tb_promotion_onepages_settings()
	{
		return $this->hasMany(TbPromotionOnepagesSetting::class, 'onepageId');
	}
}
