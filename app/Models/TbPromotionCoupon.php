<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbPromotionCoupon
 * 
 * @property int $id
 * @property string|null $coupon_code
 * @property string|null $coupon_name
 * @property string|null $coupon_img
 * @property string|null $coupon_des
 * @property int $coupon_type
 * @property string|null $coupon_discount
 * @property string|null $coupon_date_exp
 * @property string|null $min_order_amount
 * @property string|null $max_order_amount
 * @property int $status_product_not_sale
 * @property string|null $participating_products
 * @property string|null $non_participating_products
 * @property int $participating_categorie_type
 * @property string|null $participating_categorie
 * @property int $non_participating_categorie_type
 * @property string|null $non_participating_categorie
 * @property string|null $coupon_limit
 * @property string|null $coupon_limit_people
 * @property int $show
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class TbPromotionCoupon extends Model
{
	protected $table = 'tb_promotion_coupon';

	protected $casts = [
		'coupon_type' => 'int',
		'status_product_not_sale' => 'int',
		'participating_categorie_type' => 'int',
		'non_participating_categorie_type' => 'int',
		'show' => 'int'
	];

	protected $fillable = [
		'coupon_code',
		'coupon_name',
		'coupon_img',
		'coupon_des',
		'coupon_type',
		'coupon_discount',
		'coupon_date_exp',
		'min_order_amount',
		'max_order_amount',
		'status_product_not_sale',
		'participating_products',
		'non_participating_products',
		'participating_categorie_type',
		'participating_categorie',
		'non_participating_categorie_type',
		'non_participating_categorie',
		'coupon_limit',
		'coupon_limit_people',
		'show',
		'updated_by',
		'created_by'
	];
}
