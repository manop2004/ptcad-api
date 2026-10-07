<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbLevelMenu
 * 
 * @property int $id
 * @property int|null $level
 * @property int $l_artlicle
 * @property int $l_promotion
 * @property int $l_software
 * @property int $l_program
 * @property int $l_banner
 * @property int $l_page
 * @property int $l_category
 * @property int $l_customcode
 * @property int $l_setting
 * @property int $l_recommend
 * @property int $l_user
 * @property int $l_user_Action
 * @property int $l_user_staff_Action
 * @property int $l_bank
 * @property int $l_membergetmember
 * @property int $l_membergetmember_setting
 * @property int $l_quotation
 * @property int $l_quotation_setting
 * @property int $l_product
 * @property int $l_product_Import
 * @property int $l_product_Export
 * @property int $l_product_Action
 * @property int|null $l_ticket
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property TbLevel|null $tb_level
 *
 * @package App\Models
 */
class TbLevelMenu extends Model
{
	protected $table = 'tb_level_menu';

	protected $casts = [
		'level' => 'int',
		'l_artlicle' => 'int',
		'l_promotion' => 'int',
		'l_software' => 'int',
		'l_program' => 'int',
		'l_banner' => 'int',
		'l_page' => 'int',
		'l_category' => 'int',
		'l_customcode' => 'int',
		'l_setting' => 'int',
		'l_recommend' => 'int',
		'l_user' => 'int',
		'l_user_Action' => 'int',
		'l_user_staff_Action' => 'int',
		'l_bank' => 'int',
		'l_membergetmember' => 'int',
		'l_membergetmember_setting' => 'int',
		'l_quotation' => 'int',
		'l_quotation_setting' => 'int',
		'l_product' => 'int',
		'l_product_Import' => 'int',
		'l_product_Export' => 'int',
		'l_product_Action' => 'int',
		'l_ticket' => 'int'
	];

	protected $fillable = [
		'level',
		'l_artlicle',
		'l_promotion',
		'l_software',
		'l_program',
		'l_banner',
		'l_page',
		'l_category',
		'l_customcode',
		'l_setting',
		'l_recommend',
		'l_user',
		'l_user_Action',
		'l_user_staff_Action',
		'l_bank',
		'l_membergetmember',
		'l_membergetmember_setting',
		'l_quotation',
		'l_quotation_setting',
		'l_product',
		'l_product_Import',
		'l_product_Export',
		'l_product_Action',
		'l_ticket'
	];

	public function tb_level()
	{
		return $this->belongsTo(TbLevel::class, 'level');
	}
}
