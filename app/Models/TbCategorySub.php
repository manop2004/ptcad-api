<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbCategorySub
 * 
 * @property int $id
 * @property string|null $categorysub_name
 * @property string|null $categorysub_permalink
 * @property int|null $category_id
 * @property string|null $categorysub_note
 * @property string|null $categorysub_sort
 * @property int $categorysub_option
 * @property int $categorysub_show
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property TbCategory|null $tb_category
 * @property Collection|TbProduct[] $tb_products
 *
 * @package App\Models
 */
class TbCategorySub extends Model
{
	protected $table = 'tb_category_sub';

	protected $casts = [
		'category_id' => 'int',
		'categorysub_option' => 'int',
		'categorysub_show' => 'int'
	];

	protected $fillable = [
		'categorysub_name',
		'categorysub_permalink',
		'category_id',
		'categorysub_note',
		'categorysub_sort',
		'categorysub_option',
		'categorysub_show',
		'updated_by',
		'created_by'
	];

	public function tb_category()
	{
		return $this->belongsTo(TbCategory::class, 'category_id');
	}

	public function tb_products()
	{
		return $this->hasMany(TbProduct::class, 'pro_catsubId');
	}
}
