<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HistorySendMail
 * 
 * @property int $id
 * @property int|null $userId
 * @property string|null $remark
 * @property string|null $status
 * @property string|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User|null $user
 *
 * @package App\Models
 */
class HistorySendMail extends Model
{
	protected $table = 'history_send_mail';

	protected $casts = [
		'userId' => 'int'
	];

	protected $fillable = [
		'userId',
		'remark',
		'status',
		'created_by'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'userId');
	}
}
