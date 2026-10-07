<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbQuotationSetting
 * 
 * @property int $id
 * @property string|null $tax_id
 * @property string|null $company_name
 * @property string|null $company_address
 * @property string|null $company_tel
 * @property string|null $company_fax
 * @property string|null $company_vat
 * @property string|null $company_withheld
 * @property string|null $quotation_note
 * @property string|null $quotation_transfer
 * @property string|null $quotation_payment
 * @property string|null $logo_company
 * @property int $show
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class TbQuotationSetting extends Model
{
	protected $table = 'tb_quotation_setting';

	protected $casts = [
		'show' => 'int'
	];

	protected $fillable = [
		'tax_id',
		'company_name',
		'company_address',
		'company_tel',
		'company_fax',
		'company_vat',
		'company_withheld',
		'quotation_note',
		'quotation_transfer',
		'quotation_payment',
		'logo_company',
		'show',
		'updated_by',
		'created_by'
	];
}
