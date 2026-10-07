<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UsersCoupon
 * 
 * @property int $id
 * @property string|null $coupon_code
 * @property int|null $userId
 * @property int|null $coupon_use
 * @property int $show
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class UsersCoupon extends Model
{
	protected $table = 'users_coupon';

	protected $casts = [
		'userId' => 'int',
		'coupon_use' => 'int',
		'show' => 'int'
	];

	protected $fillable = [
		'coupon_code',
		'userId',
		'coupon_use',
		'show',
		'updated_by',
		'created_by'
	];
}
