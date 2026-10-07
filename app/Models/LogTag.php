<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LogTag
 * 
 * @property int $id
 * @property string|null $value
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 *
 * @package App\Models
 */
class LogTag extends Model
{
	protected $table = 'log_tags';

	protected $fillable = [
		'value',
		'created_by',
		'updated_by'
	];
}
