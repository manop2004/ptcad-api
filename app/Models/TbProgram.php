<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbProgram
 * 
 * @property int $id
 * @property string|null $program_name
 * @property string|null $program_note
 * @property int $show
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|TbProgramInstall[] $tb_program_installs
 *
 * @package App\Models
 */
class TbProgram extends Model
{
	protected $table = 'tb_program';

	protected $casts = [
		'show' => 'int'
	];

	protected $fillable = [
		'program_name',
		'program_note',
		'show',
		'created_by',
		'updated_by'
	];

	public function tb_program_installs()
	{
		return $this->hasMany(TbProgramInstall::class, 'programId');
	}
}
