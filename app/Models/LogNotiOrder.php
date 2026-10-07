<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LogNotiOrder
 * 
 * @property int $id
 * @property string|null $orderNumber
 * @property string|null $orderMessage
 * @property int $orderReport
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class LogNotiOrder extends Model
{
	protected $table = 'log_noti_order';

	protected $casts = [
		'orderReport' => 'int'
	];

	protected $fillable = [
		'orderNumber',
		'orderMessage',
		'orderReport'
	];
}
