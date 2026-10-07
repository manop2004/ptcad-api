<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
/**
 * Class TbProduct
 * 
 * @property int $id
 * @property int $pro_option
 * @property string|null $pro_name
 * @property string|null $pro_permalink
 * @property string|null $pro_keyword
 * @property string|null $pro_seo_detail
 * @property string|null $pro_related
 * @property int|null $pro_brand
 * @property int|null $pro_type
 * @property int|null $pro_catId
 * @property int|null $pro_catsubId
 * @property string|null $pro_download
 * @property string|null $pro_free_trial
 * @property string|null $pro_codition
 * @property string|null $pro_highlight
 * @property string|null $pro_content
 * @property string|null $pro_feature
 * @property string|null $pro_gift
 * @property int $pro_show
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property TbBrand|null $tb_brand
 * @property TbCategory|null $tb_category
 * @property TbCategorySub|null $tb_category_sub
 * @property TbProductType|null $tb_product_type
 * @property Collection|TbProductDetail[] $tb_product_details
 * @property Collection|TbProductPicture[] $tb_product_pictures
 * @property Collection|TbProductSpecification[] $tb_product_specifications
 *
 * @package App\Models
 */
class TbProduct extends Model
{
	protected $table = 'tb_product';

	protected $casts = [
		'pro_option' => 'int',
		'pro_brand' => 'int',
		'pro_type' => 'int',
		'pro_catId' => 'int',
		'pro_catsubId' => 'int',
		'pro_show' => 'int'
	];

	protected $fillable = [
		'pro_option',
		'pro_name',
		'pro_permalink',
		'pro_keyword',
		'pro_seo_detail',
		'pro_related',
		'pro_brand',
		'pro_type',
		'pro_catId',
		'pro_catsubId',
		'pro_download',
		'pro_free_trial',
		'pro_codition',
		'pro_highlight',
		'pro_content',
		'pro_feature',
		'pro_gift',
		'pro_show',
		'updated_by',
		'created_by'
	];

	public function tb_brand()
	{
		return $this->belongsTo(TbBrand::class, 'pro_brand');
	}

	public function tb_category()
	{
		return $this->belongsTo(TbCategory::class, 'pro_catId');
	}

	public function tb_category_sub()
	{
		return $this->belongsTo(TbCategorySub::class, 'pro_catsubId');
	}

	public function tb_product_type()
	{
		return $this->belongsTo(TbProductType::class, 'pro_type');
	}

	public function tb_product_details()
	{
		return $this->hasMany(TbProductDetail::class, 'proId');
	}

	public function tb_product_pictures()
	{
		return $this->hasMany(TbProductPicture::class, 'proId');
	}

	public function tb_product_specifications()
	{
		return $this->hasMany(TbProductSpecification::class, 'proId');
	}

}
