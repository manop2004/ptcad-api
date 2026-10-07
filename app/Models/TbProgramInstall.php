<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbProgramInstall
 * 
 * @property int $id
 * @property string|null $install_name
 * @property string|null $install_file
 * @property int|null $programId
 * @property int $show
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property TbProgram|null $tb_program
 *
 * @package App\Models
 */
class TbProgramInstall extends Model
{
	protected $table = 'tb_program_install';

	protected $casts = [
		'programId' => 'int',
		'show' => 'int'
	];

	protected $fillable = [
		'install_name',
		'install_file',
		'programId',
		'show',
		'created_by',
		'updated_by'
	];

	public function tb_program()
	{
		return $this->belongsTo(TbProgram::class, 'programId');
	}
}
