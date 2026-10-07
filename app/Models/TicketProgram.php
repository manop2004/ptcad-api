<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TicketProgram
 * 
 * @property int $id
 * @property string|null $name
 * @property int $show
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class TicketProgram extends Model
{
	protected $table = 'ticket_program';

	protected $casts = [
		'show' => 'int'
	];

	protected $fillable = [
		'name',
		'show',
		'created_by',
		'updated_by'
	];
}
