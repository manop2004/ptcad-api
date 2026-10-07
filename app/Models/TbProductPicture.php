<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbProductPicture
 * 
 * @property int $id
 * @property int|null $proId
 * @property int|null $detailId
 * @property string|null $picture_name
 * @property int $picture_status
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property TbProductDetail|null $tb_product_detail
 * @property TbProduct|null $tb_product
 *
 * @package App\Models
 */
class TbProductPicture extends Model
{
	protected $table = 'tb_product_picture';

	protected $casts = [
		'proId' => 'int',
		'detailId' => 'int',
		'picture_status' => 'int'
	];

	protected $fillable = [
		'proId',
		'detailId',
		'picture_name',
		'picture_status',
		'updated_by',
		'created_by'
	];

	public function tb_product_detail()
	{
		return $this->belongsTo(TbProductDetail::class, 'detailId');
	}

	public function tb_product()
	{
		return $this->belongsTo(TbProduct::class, 'proId');
	}
}
