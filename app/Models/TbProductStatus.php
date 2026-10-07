<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbProductStatus
 * 
 * @property int $id
 * @property string|null $stu_name
 * @property int $stu_preorder
 * @property string|null $stu_color
 * @property int $stu_display
 * @property int $stu_show
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|TbProductDetail[] $tb_product_details
 *
 * @package App\Models
 */
class TbProductStatus extends Model
{
	protected $table = 'tb_product_status';

	protected $casts = [
		'stu_preorder' => 'int',
		'stu_display' => 'int',
		'stu_show' => 'int'
	];

	protected $fillable = [
		'stu_name',
		'stu_preorder',
		'stu_color',
		'stu_display',
		'stu_show'
	];

	public function tb_product_details()
	{
		return $this->hasMany(TbProductDetail::class, 'detail_status');
	}
}
