<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Holiday
 * 
 * @property int $id
 * @property string $name
 * @property Carbon $date
 *
 * @package App\Models
 */
class Holiday extends Model
{
	protected $table = 'holiday';

	protected $casts = [
	];

	protected $fillable = [
		'name'
	];
}
