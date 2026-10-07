<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HistoryPdpa
 * 
 * @property int $id
 * @property int|null $userId
 * @property string|null $fullname
 * @property string|null $tel
 * @property string|null $email
 * @property int $pdpa_news
 * @property int $pdpa_article
 * @property int $pdpa_product
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User|null $user
 *
 * @package App\Models
 */
class HistoryPdpa extends Model
{
	protected $table = 'history_pdpa';

	protected $casts = [
		'userId' => 'int',
		'pdpa_news' => 'int',
		'pdpa_article' => 'int',
		'pdpa_product' => 'int'
	];

	protected $fillable = [
		'userId',
		'fullname',
		'tel',
		'email',
		'pdpa_news',
		'pdpa_article',
		'pdpa_product'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'userId');
	}
}
