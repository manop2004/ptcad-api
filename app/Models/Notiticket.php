<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Notiticket
 * 
 * @property int $id
 * @property int $userid
 * @property int $last_ticketid
 *
 * @package App\Models
 */
class Notiticket extends Model
{
	protected $table = 'noti_ticket';

	protected $casts = [
		'userid' => 'int',
		'last_ticketid' => 'int'
	];

	protected $fillable = [
		'userid',
		'last_ticketid'
	];
}
