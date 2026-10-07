<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbPage
 * 
 * @property int $id
 * @property int $pages_type
 * @property string|null $pages_name
 * @property string|null $page_detail
 * @property string|null $pages_keyword
 * @property string|null $page_seo_detail
 * @property string|null $page_parmalink
 * @property int $page_show
 * @property int $page_recommend
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class TbPage extends Model
{
	protected $table = 'tb_pages';

	protected $casts = [
		'pages_type' => 'int',
		'page_show' => 'int',
		'page_recommend' => 'int'
	];

	protected $fillable = [
		'pages_type',
		'pages_name',
		'page_detail',
		'pages_keyword',
		'page_seo_detail',
		'page_parmalink',
		'page_show',
		'page_recommend',
		'updated_by',
		'created_by'
	];
}
