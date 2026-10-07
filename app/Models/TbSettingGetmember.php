<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbSettingGetmember
 * 
 * @property int $id
 * @property string|null $getmember_thumb
 * @property int $getmember_ref_type
 * @property string|null $getmember_ref_detail
 * @property string|null $getmember_ref_coupon
 * @property int $getmember_recommender_type
 * @property string|null $getmember_recommender_detail
 * @property string|null $getmember_recommender_coupon
 * @property int $getmember_show
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class TbSettingGetmember extends Model
{
	protected $table = 'tb_setting_getmember';

	protected $casts = [
		'getmember_ref_type' => 'int',
		'getmember_recommender_type' => 'int',
		'getmember_show' => 'int'
	];

	protected $fillable = [
		'getmember_thumb',
		'getmember_ref_type',
		'getmember_ref_detail',
		'getmember_ref_coupon',
		'getmember_recommender_type',
		'getmember_recommender_detail',
		'getmember_recommender_coupon',
		'getmember_show',
		'updated_by',
		'created_by'
	];
}
