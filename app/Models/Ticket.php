<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Ticket
 * 
 * @property int $id
 * @property string|null $code
 * @property string|null $name
 * @property string|null $email
 * @property string|null $tel
 * @property string|null $company
 * @property string|null $subject
 * @property string|null $program
 * @property string|null $message
 * @property string|null $note
 * @property int|null $staffId
 * @property int $status
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User|null $user
 * @property Collection|TicketFile[] $ticket_files
 *
 * @package App\Models
 */
class Ticket extends Model
{
	protected $table = 'ticket';

	protected $casts = [
		'staffId' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'code',
		'name',
		'email',
		'tel',
		'company',
		'subject',
		'program',
		'message',
		'note',
		'staffId',
		'status',
		'created_by',
		'updated_by'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'staffId');
	}

	public function ticket_files()
	{
		return $this->hasMany(TicketFile::class, 'ticketId');
	}
}
