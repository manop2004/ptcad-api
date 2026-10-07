<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HistoryTicket
 * 
 * @property int $id
 * @property string|null $ticketcode
 * @property string|null $remark
 * @property int $mailStatus
 * @property string|null $mailRemark
 * @property string|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class HistoryTicket extends Model
{
	protected $table = 'history_ticket';

	protected $casts = [
		'mailStatus' => 'int'
	];

	protected $fillable = [
		'ticketcode',
		'remark',
		'mailStatus',
		'mailRemark',
		'updated_by'
	];
	
	public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticketId', 'id');
    }
}
