<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HistoryMembergetmember
 * 
 * @property int $id
 * @property int|null $getmemberId
 * @property string|null $remark
 * @property string|null $status
 * @property string|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property UserGetmember|null $user_getmember
 *
 * @package App\Models
 */
class HistoryMembergetmember extends Model
{
	protected $table = 'history_membergetmember';

	protected $casts = [
		'getmemberId' => 'int'
	];

	protected $fillable = [
		'getmemberId',
		'remark',
		'status',
		'created_by'
	];

	public function user_getmember()
	{
		return $this->belongsTo(UserGetmember::class, 'getmemberId');
	}
}
