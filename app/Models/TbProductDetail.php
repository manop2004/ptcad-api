<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbProductDetail
 * 
 * @property int $id
 * @property int|null $proId
 * @property string|null $detail_sku
 * @property string|null $detail_name
 * @property string|null $detail_other
 * @property int|null $detail_status
 * @property string|null $detail_preorder_day
 * @property string|null $detail_product_weight
 * @property string|null $detail_product_wide
 * @property string|null $detail_product_long
 * @property string|null $detail_product_high
 * @property int $detail_product_contact_sale_status
 * @property string|null $detail_price
 * @property int $detail_price_sale_status
 * @property string|null $detail_price_sale
 * @property int $detail_price_sale_status_date
 * @property string|null $detail_sale_date_start
 * @property string|null $detail_sale_date_end
 * @property int $detail_show
 * @property int $sort
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property TbProductStatus|null $tb_product_status
 * @property TbProduct|null $tb_product
 * @property Collection|TbProductPicture[] $tb_product_pictures
 *
 * @package App\Models
 */
class TbProductDetail extends Model
{
	protected $table = 'tb_product_detail';

	protected $casts = [
		'proId' => 'int',
		'detail_status' => 'int',
		'detail_product_contact_sale_status' => 'int',
		'detail_price_sale_status' => 'int',
		'detail_price_sale_status_date' => 'int',
		'detail_check_stock_status' => 'int',
		'detail_show' => 'int',
		'sort' => 'int'
	];

	protected $fillable = [
		'proId',
		'detail_sku',
		'detail_name',
		'detail_other',
		'detail_status',
		'detail_preorder_day',
		'detail_product_weight',
		'detail_product_wide',
		'detail_product_long',
		'detail_product_high',
		'detail_product_contact_sale_status',
		'detail_price',
		'detail_price_sale_status',
		'detail_price_sale',
		'detail_price_sale_status_date',
		'detail_sale_date_start',
		'detail_sale_date_end',
		'detail_check_stock_status',
		'detail_stock',
		'detail_show',
		'sort',
		'updated_by',
		'created_by'
	];

	public function tb_product_status()
	{
		return $this->belongsTo(TbProductStatus::class, 'detail_status');
	}

	public function tb_product()
	{
		return $this->belongsTo(TbProduct::class, 'proId');
	}

	public function tb_product_pictures()
	{
		return $this->hasMany(TbProductPicture::class, 'detailId');
	}
}
