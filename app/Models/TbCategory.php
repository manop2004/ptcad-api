<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbCategory
 * 
 * @property int $id
 * @property string|null $category_name
 * @property string|null $category_permalink
 * @property int|null $category_type
 * @property string|null $category_note
 * @property string|null $category_sort
 * @property int $category_option
 * @property int $category_display_status
 * @property int $category_show
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property TbType|null $tb_type
 * @property Collection|TbCategorySub[] $tb_category_subs
 * @property Collection|TbProduct[] $tb_products
 *
 * @package App\Models
 */
class TbCategory extends Model
{
	protected $table = 'tb_category';

	protected $casts = [
		'category_type' => 'int',
		'category_option' => 'int',
		'category_display_status' => 'int',
		'category_show' => 'int'
	];

	protected $fillable = [
		'category_name',
		'category_permalink',
		'category_type',
		'category_note',
		'category_sort',
		'category_option',
		'category_display_status',
		'category_show',
		'updated_by',
		'created_by'
	];

	public function tb_type()
	{
		return $this->belongsTo(TbType::class, 'category_type');
	}

	public function tb_category_subs()
	{
		return $this->hasMany(TbCategorySub::class, 'category_id');
	}

	public function tb_products()
	{
		return $this->hasMany(TbProduct::class, 'pro_catId');
	}
}
