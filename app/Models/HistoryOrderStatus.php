<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HistoryOrderStatus
 * 
 * @property int $id
 * @property string|null $orderNumber
 * @property string|null $order_status
 * @property string|null $order_message
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class HistoryOrderStatus extends Model
{
	protected $table = 'history_order_status';

	protected $fillable = [
		'orderNumber',
		'order_status',
		'order_message',
		'updated_by',
		'created_by'
	];
}
