<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TicketFile
 * 
 * @property int $id
 * @property int|null $ticketId
 * @property string|null $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Ticket|null $ticket
 *
 * @package App\Models
 */
class TicketFile extends Model
{
	protected $table = 'ticket_file';

	protected $casts = [
		'ticketId' => 'int'
	];

	protected $fillable = [
		'ticketId',
		'name'
	];

	public function ticket()
	{
		return $this->belongsTo(Ticket::class, 'ticketId');
	}
}
