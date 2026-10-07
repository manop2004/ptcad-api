<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HistoryCalandar
 * 
 * @property int $id
 * @property int|null $promotionId
 * @property int $groupType
 * @property string $groupName
 * @property string $token_notify
 * @property string|null $send_message_startDate
 * @property int $send_status_startDate
 * @property string|null $send_message_EndDate
 * @property int $send_status_EndDate
 * @property int $show
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property TbPromotionCalendar|null $tb_promotion_calendar
 *
 * @package App\Models
 */
class HistoryCalandar extends Model
{
	protected $table = 'history_calandar';

	protected $casts = [
		'promotionId' => 'int',
		'groupType' => 'int',
		'send_status_startDate' => 'int',
		'send_status_EndDate' => 'int',
		'show' => 'int'
	];

	protected $fillable = [
		'promotionId',
		'groupType',
		'groupName',
		'token_notify',
		'send_message_startDate',
		'send_status_startDate',
		'send_message_EndDate',
		'send_status_EndDate',
		'show'
	];

	public function tb_promotion_calendar()
	{
		return $this->belongsTo(TbPromotionCalendar::class, 'promotionId');
	}
}
