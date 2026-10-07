<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserGetmember
 * 
 * @property int $id
 * @property string|null $userCode
 * @property string|null $userCode_Ref
 * @property string|null $remark
 * @property int $conditionStatus
 * @property string|null $status
 * @property string|null $created_by
 * @property Carbon|null $created_at
 * @property string|null $updated_by
 * @property Carbon|null $updated_at
 * 
 * @property Collection|HistoryMembergetmember[] $history_membergetmembers
 *
 * @package App\Models
 */
class UserGetmember extends Model
{
	protected $table = 'user_getmember';

	protected $casts = [
		'conditionStatus' => 'int'
	];

	protected $fillable = [
		'userCode',
		'userCode_Ref',
		'remark',
		'conditionStatus',
		'status',
		'created_by',
		'updated_by'
	];

	public function history_membergetmembers()
	{
		return $this->hasMany(HistoryMembergetmember::class, 'getmemberId');
	}
}
