<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbArticle
 * 
 * @property int $id
 * @property string|null $art_name
 * @property string|null $art_keyword
 * @property string|null $art_detail
 * @property int $art_author
 * @property string|null $art_seo_detail
 * @property string|null $art_parmalink
 * @property string|null $art_thumb
 * @property int $art_show
 * @property int $art_recommend
 * @property int $art_view
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class TbArticle extends Model
{
	protected $table = 'tb_article';

	protected $casts = [
		'art_author' => 'int',
		'art_show' => 'int',
		'art_recommend' => 'int',
		'art_view' => 'int'
	];

	protected $fillable = [
		'art_name',
		'art_keyword',
		'art_detail',
		'art_author',
		'art_seo_detail',
		'art_parmalink',
		'art_thumb',
		'art_show',
		'art_recommend',
		'art_view',
		'updated_by',
		'created_by'
	];
}
