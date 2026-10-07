<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbPagesRedirect
 * 
 * @property int $id
 * @property string|null $redirect_old
 * @property string|null $redirect_new
 * @property int $redirect_show
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class TbPagesRedirect extends Model
{
	protected $table = 'tb_pages_redirect';

	protected $casts = [
		'redirect_show' => 'int'
	];

	protected $fillable = [
		'redirect_old',
		'redirect_new',
		'redirect_show',
		'updated_by',
		'created_by'
	];
}
