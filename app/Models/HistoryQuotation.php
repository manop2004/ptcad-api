<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HistoryQuotation
 * 
 * @property int $id
 * @property string|null $name_file
 * @property string|null $year
 * @property int|null $userId
 * @property int|null $quotationId
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $crateby
 * 
 * @property TbQuotation|null $tb_quotation
 * @property User|null $user
 *
 * @package App\Models
 */
class HistoryQuotation extends Model
{
	protected $table = 'history_quotation';

	protected $casts = [
		'userId' => 'int',
		'quotationId' => 'int'
	];

	protected $fillable = [
		'name_file',
		'year',
		'userId',
		'quotationId',
		'crateby'
	];

	public function tb_quotation()
	{
		return $this->belongsTo(TbQuotation::class, 'quotationId');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'userId');
	}
}
