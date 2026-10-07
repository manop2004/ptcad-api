<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HistoryChangeDisplay
 * 
 * @property int|null $userId
 * @property string|null $displayname_new
 * @property string|null $displayname_old
 * @property string|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User|null $user
 *
 * @package App\Models
 */
class HistoryChangeDisplay extends Model
{
	protected $table = 'history_change_display';
	public $incrementing = false;

	protected $casts = [
		'userId' => 'int'
	];

	protected $fillable = [
		'userId',
		'displayname_new',
		'displayname_old',
		'updated_by'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'userId');
	}
}
