<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbPagesMap
 * 
 * @property int $id
 * @property int|null $page_about
 * @property int|null $page_privacy_policy
 * @property int|null $page_business_policy
 * @property int|null $page_refund_policy
 * @property int|null $page_return_policy
 * @property int|null $page_warranty_policy
 * @property int|null $page_howto_shopping
 * @property int|null $page_howto_register
 * @property int|null $page_membership
 * @property int|null $pages_check_delivery
 * @property int|null $pages_contact_support
 * @property int|null $pages_payment
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class TbPagesMap extends Model
{
	protected $table = 'tb_pages_map';

	protected $casts = [
		'page_about' => 'int',
		'page_privacy_policy' => 'int',
		'page_business_policy' => 'int',
		'page_refund_policy' => 'int',
		'page_return_policy' => 'int',
		'page_warranty_policy' => 'int',
		'page_howto_shopping' => 'int',
		'page_howto_register' => 'int',
		'page_membership' => 'int',
		'pages_check_delivery' => 'int',
		'pages_contact_support' => 'int',
		'pages_payment' => 'int'
	];

	protected $fillable = [
		'page_about',
		'page_privacy_policy',
		'page_business_policy',
		'page_refund_policy',
		'page_return_policy',
		'page_warranty_policy',
		'page_howto_shopping',
		'page_howto_register',
		'page_membership',
		'pages_check_delivery',
		'pages_contact_support',
		'pages_payment',
		'updated_by',
		'created_by'
	];
}
