<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HistoryQuotationStatus
 * 
 * @property int $id
 * @property int|null $quotationId
 * @property string|null $remark
 * @property string|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property TbQuotation|null $tb_quotation
 *
 * @package App\Models
 */
class HistoryQuotationStatus extends Model
{
	protected $table = 'history_quotation_status';

	protected $casts = [
		'quotationId' => 'int'
	];

	protected $fillable = [
		'quotationId',
		'remark',
		'created_by'
	];

	public function tb_quotation()
	{
		return $this->belongsTo(TbQuotation::class, 'quotationId');
	}
}
