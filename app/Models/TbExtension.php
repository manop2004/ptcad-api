<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbExtension
 * 
 * @property int $id
 * @property string|null $ext_googleWebmaster
 * @property string|null $ext_googleAnalytics
 * @property string|null $ext_googleAdsense
 * @property string|null $ext_histats
 * @property int $ext_captcha_status
 * @property string|null $ext_captcha
 * @property int $ext_lineNotify_status
 * @property string|null $ext_lineNotify
 * @property int $ext_google_status
 * @property string|null $ext_google_clientId
 * @property string|null $ext_google_clientSecret
 * @property int $ext_facebook_status
 * @property string|null $ext_facebook_clientId
 * @property string|null $ext_facebook_clientSecret
 * @property string|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 *
 * @package App\Models
 */
class TbExtension extends Model
{
	protected $table = 'tb_extensions';

	protected $casts = [
		'ext_captcha_status' => 'int',
		'ext_lineNotify_status' => 'int',
		'ext_google_status' => 'int',
		'ext_facebook_status' => 'int'
	];

	protected $fillable = [
		'ext_googleWebmaster',
		'ext_googleAnalytics',
		'ext_googleAdsense',
		'ext_histats',
		'ext_captcha_status',
		'ext_captcha',
		'ext_lineNotify_status',
		'ext_lineNotify',
		'ext_google_status',
		'ext_google_clientId',
		'ext_google_clientSecret',
		'ext_facebook_status',
		'ext_facebook_clientId',
		'ext_facebook_clientSecret',
		'updated_by',
		'created_by'
	];
}
