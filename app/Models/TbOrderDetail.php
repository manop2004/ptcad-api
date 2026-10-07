<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbOrderDetail
 * 
 * @property int $id
 * @property int|null $orderId
 * @property string|null $product_sku
 * @property string|null $product_name
 * @property string|null $product_detail
 * @property string|null $product_img
 * @property string|null $product_price
 * @property string|null $product_price_sale
 * @property int|null $product_unit
 * @property string|null $product_price_total
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property TbOrder|null $tb_order
 *
 * @package App\Models
 */
class TbOrderDetail extends Model
{
	protected $table = 'tb_order_detail';

	protected $casts = [
		'orderId' => 'int',
		'product_unit' => 'int'
	];

	protected $fillable = [
		'orderId',
		'product_sku',
		'product_name',
		'product_detail',
		'product_img',
		'product_price',
		'product_price_sale',
		'product_unit',
		'product_price_total'
	];

	public function tb_order()
	{
		return $this->belongsTo(TbOrder::class, 'orderId');
	}
}
