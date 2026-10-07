<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbProductHistoryImportfile
 * 
 * @property int $id
 * @property string|null $Message
 * @property string|null $Month
 * @property string|null $Year
 * @property string|null $file_name
 * @property string|null $note
 * @property string|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class TbProductHistoryImportfile extends Model
{
	protected $table = 'tb_product_history_importfile';

	protected $fillable = [
		'Message',
		'Month',
		'Year',
		'file_name',
		'note',
		'created_by'
	];
}
