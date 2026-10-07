<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbPromotionEmailtemplate
 * 
 * @property int $id
 * @property string|null $email_title
 * @property string|null $email_content
 * @property string|null $email_link
 * @property int $show
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class TbPromotionEmailtemplate extends Model
{
	protected $table = 'tb_promotion_emailtemplate';

	protected $casts = [
		'show' => 'int'
	];

	protected $fillable = [
		'email_title',
		'email_content',
		'email_link',
		'show',
		'updated_by',
		'created_by'
	];
}
