<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbSetting
 * 
 * @property int $id
 * @property string|null $setting_logoWeb
 * @property string|null $setting_logoWeb_mobile
 * @property string|null $setting_iconWeb
 * @property string|null $setting_coverShare
 * @property string|null $setting_nameWeb
 * @property string|null $setting_detail
 * @property string|null $setting_keyword
 * @property string|null $setting_DBD
 * @property int $setting_ssl
 * @property string|null $setting_address
 * @property string|null $setting_companyTime
 * @property string|null $setting_websiteTime
 * @property string|null $setting_telContact
 * @property string|null $setting_faxContact
 * @property string|null $setting_emailContact
 * @property string|null $setting_email_bcc
 * @property string|null $setting_email_support
 * @property string|null $setting_idLine
 * @property string|null $setting_LinkYoutube
 * @property string|null $setting_LinkTwitter
 * @property string|null $setting_LinkInstagram
 * @property string|null $setting_LinkFacebook
 * @property int $setting_birthday
 * @property string|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class TbSetting extends Model
{
	protected $table = 'tb_setting';

	protected $casts = [
		'setting_ssl' => 'int',
		'setting_birthday' => 'int'
	];

	protected $fillable = [
		'setting_logoWeb',
		'setting_logoWeb_mobile',
		'setting_iconWeb',
		'setting_coverShare',
		'setting_nameWeb',
		'setting_detail',
		'setting_keyword',
		'setting_DBD',
		'setting_ssl',
		'setting_address',
		'setting_companyTime',
		'setting_websiteTime',
		'setting_telContact',
		'setting_faxContact',
		'setting_emailContact',
		'setting_email_bcc',
		'setting_email_support',
		'setting_idLine',
		'setting_LinkYoutube',
		'setting_LinkTwitter',
		'setting_LinkInstagram',
		'setting_LinkFacebook',
		'setting_birthday',
		'updated_by'
	];
}
