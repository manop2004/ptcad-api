<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbProductSpecification
 * 
 * @property int $id
 * @property int|null $proId
 * @property string|null $spec_name
 * @property string|null $spec_detail
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property TbProduct|null $tb_product
 *
 * @package App\Models
 */
class TbProductSpecification extends Model
{
	protected $table = 'tb_product_specification';

	protected $casts = [
		'proId' => 'int'
	];

	protected $fillable = [
		'proId',
		'spec_name',
		'spec_detail',
		'updated_by',
		'created_by'
	];

	public function tb_product()
	{
		return $this->belongsTo(TbProduct::class, 'proId');
	}
}
