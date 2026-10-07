<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbQuotation
 * 
 * @property int $id
 * @property string|null $quotationNumber
 * @property string|null $quotationDate
 * @property string|null $quotationDateExp
 * @property int $type
 * @property string|null $user_code
 * @property int|null $userId
 * @property string|null $name
 * @property string|null $lastname
 * @property string|null $company
 * @property string|null $tax
 * @property string|null $address
 * @property int $province
 * @property int $amphures
 * @property int $district
 * @property string|null $zipcode
 * @property string|null $email
 * @property string|null $tel
 * @property string|null $message
 * @property int $productTax
 * @property int $productVat
 * @property string|null $productSku
 * @property string|null $productName
 * @property string|null $productDetail
 * @property string|null $productImg
 * @property string|null $productPrice
 * @property string|null $productPricesale
 * @property string|null $productUnit
 * @property string|null $productTotal
 * @property int $pdpa_news
 * @property int $pdpa_article
 * @property int $pdpa_product
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $staffId
 * 
 * @property User|null $user
 * @property Collection|HistoryQuotation[] $history_quotations
 * @property Collection|HistoryQuotationStatus[] $history_quotation_statuses
 *
 * @package App\Models
 */
class TbQuotation extends Model
{
	protected $table = 'tb_quotation';

	protected $casts = [
		'type' => 'int',
		'userId' => 'int',
		'province' => 'int',
		'amphures' => 'int',
		'district' => 'int',
		'productTax' => 'int',
		'productVat' => 'int',
		'pdpa_news' => 'int',
		'pdpa_article' => 'int',
		'pdpa_product' => 'int',
		'staffId' => 'int'
	];

	protected $fillable = [
		'quotationNumber',
		'quotationDate',
		'quotationDateExp',
		'type',
		'user_code',
		'userId',
		'name',
		'lastname',
		'company',
		'tax',
		'address',
		'province',
		'amphures',
		'district',
		'zipcode',
		'email',
		'tel',
		'message',
		'productTax',
		'productVat',
		'productSku',
		'productName',
		'productDetail',
		'productImg',
		'productPrice',
		'productPricesale',
		'productUnit',
		'productTotal',
		'pdpa_news',
		'pdpa_article',
		'pdpa_product',
		'updated_by',
		'created_by',
		'staffId'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'userId');
	}

	public function history_quotations()
	{
		return $this->hasMany(HistoryQuotation::class, 'quotationId');
	}

	public function history_quotation_statuses()
	{
		return $this->hasMany(HistoryQuotationStatus::class, 'quotationId');
	}
}
