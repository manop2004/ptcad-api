<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbSettingInstallment
 * 
 * @property int $id
 * @property string|null $installment_img
 * @property string|null $installment_name
 * @property string|null $installment_detail
 * @property int $installment_show
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class TbSettingInstallment extends Model
{
	protected $table = 'tb_setting_installment';

	protected $casts = [
		'installment_show' => 'int'
	];

	protected $fillable = [
		'installment_img',
		'installment_name',
		'installment_detail',
		'installment_show',
		'updated_by',
		'created_by'
	];
}
