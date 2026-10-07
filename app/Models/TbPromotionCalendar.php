<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbPromotionCalendar
 * 
 * @property int $id
 * @property string|null $promo_name
 * @property string|null $promo_link
 * @property string|null $promo_note
 * @property string|null $promo_color
 * @property int $promo_type
 * @property string|null $promo_start_date
 * @property int $promo_start_date_status
 * @property string|null $promo_end_date
 * @property int $promo_end_date_status
 * @property string|null $promo_img
 * @property int $line_notify_group1
 * @property int $line_notify_group2
 * @property int $promo_show
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|HistoryCalandar[] $history_calandars
 *
 * @package App\Models
 */
class TbPromotionCalendar extends Model
{
	protected $table = 'tb_promotion_calendar';

	protected $casts = [
		'promo_type' => 'int',
		'promo_start_date_status' => 'int',
		'promo_end_date_status' => 'int',
		'line_notify_group1' => 'int',
		'line_notify_group2' => 'int',
		'promo_show' => 'int'
	];

	protected $fillable = [
		'promo_name',
		'promo_link',
		'promo_note',
		'promo_color',
		'promo_type',
		'promo_start_date',
		'promo_start_date_status',
		'promo_end_date',
		'promo_end_date_status',
		'promo_img',
		'line_notify_group1',
		'line_notify_group2',
		'promo_show',
		'updated_by',
		'created_by'
	];

	public function history_calandars()
	{
		return $this->hasMany(HistoryCalandar::class, 'promotionId');
	}
}
