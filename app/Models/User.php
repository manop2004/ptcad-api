<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * 
 * @property int $id
 * @property int $user_type
 * @property string|null $user_code
 * @property string|null $user_code_friend
 * @property int|null $user_code_friend_status
 * @property string|null $employee_code
 * @property string|null $company_name
 * @property string $name
 * @property string|null $lastname
 * @property string|null $sex
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $displayname
 * @property string|null $img
 * @property string|null $tel
 * @property string|null $hbd_day
 * @property string|null $hbd_month
 * @property string|null $hbd_year
 * @property int $status
 * @property int $pdpa_news
 * @property int $pdpa_article
 * @property int $pdpa_product
 * @property string|null $lastlogin
 * @property string|null $update_by
 * @property string|null $crate_by
 * @property int|null $level
 * @property int|null $businessId
 * @property int|null $positionId
 * @property string|null $google_id
 * @property string|null $facebook_id
 * @property Carbon|null $staff_update_at
 * @property string|null $staff_update_by
 * @property int|null $staffId
 * 
 * @property TbSettingCompanyBusiness|null $tb_setting_company_business
 * @property TbLevel|null $tb_level
 * @property TbSettingCompanyPosition|null $tb_setting_company_position
 * @property HistoryChangeDisplay $history_change_display
 * @property Collection|HistoryPdpa[] $history_pdpas
 * @property Collection|HistoryQuotation[] $history_quotations
 * @property Collection|HistorySendMail[] $history_send_mails
 * @property Collection|TbOrder[] $tb_orders
 * @property Collection|TbQuotation[] $tb_quotations
 * @property Collection|TbSoftware[] $tb_software
 * @property Collection|TbSoftwareNotify[] $tb_software_notifies
 * @property Collection|UsersAddress[] $users_addresses
 * @property Collection|UsersAddressReceipt[] $users_address_receipts
 * @property Collection|UsersCoupon[] $users_coupons
 * @property Collection|UsersLevel[] $users_levels
 *
 * @package App\Models
 */
class User extends Authenticatable
{
	protected $table = 'users';

	protected $casts = [
		'user_type' => 'int',
		'user_code_friend_status' => 'int',
		'status' => 'int',
		'pdpa_news' => 'int',
		'pdpa_article' => 'int',
		'pdpa_product' => 'int',
		'level' => 'int',
		'businessId' => 'int',
		'positionId' => 'int',
		'staffId' => 'int'
	];

	protected $dates = [
		'email_verified_at',
		'staff_update_at'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'user_type',
		'user_code',
		'user_code_friend',
		'user_code_friend_status',
		'employee_code',
		'company_name',
		'name',
		'lastname',
		'sex',
		'email',
		'email_verified_at',
		'password',
		'remember_token',
		'displayname',
		'img',
		'tel',
		'hbd_day',
		'hbd_month',
		'hbd_year',
		'status',
		'pdpa_news',
		'pdpa_article',
		'pdpa_product',
		'lastlogin',
		'update_by',
		'crate_by',
		'level',
		'businessId',
		'positionId',
		'google_id',
		'facebook_id',
		'staff_update_at',
		'staff_update_by',
		'staffId'
	];

	public function tb_setting_company_business()
	{
		return $this->belongsTo(TbSettingCompanyBusiness::class, 'businessId');
	}

	public function tb_level()
	{
		return $this->belongsTo(TbLevel::class, 'level');
	}

	public function tb_setting_company_position()
	{
		return $this->belongsTo(TbSettingCompanyPosition::class, 'positionId');
	}

	public function history_change_display()
	{
		return $this->hasOne(HistoryChangeDisplay::class, 'userId');
	}

	public function history_pdpas()
	{
		return $this->hasMany(HistoryPdpa::class, 'userId');
	}

	public function history_quotations()
	{
		return $this->hasMany(HistoryQuotation::class, 'userId');
	}

	public function history_send_mails()
	{
		return $this->hasMany(HistorySendMail::class, 'userId');
	}

	public function tb_orders()
	{
		return $this->hasMany(TbOrder::class, 'staffOf');
	}

	public function tb_quotations()
	{
		return $this->hasMany(TbQuotation::class, 'userId');
	}

	public function tb_software()
	{
		return $this->hasMany(TbSoftware::class, 'userId');
	}

	public function tb_software_notifies()
	{
		return $this->hasMany(TbSoftwareNotify::class, 'userId');
	}

	public function users_addresses()
	{
		return $this->hasMany(UsersAddress::class, 'userId');
	}

	public function users_address_receipts()
	{
		return $this->hasMany(UsersAddressReceipt::class, 'userId');
	}

	public function users_coupons()
	{
		return $this->hasMany(UsersCoupon::class, 'userId');
	}

	public function users_levels()
	{
		return $this->hasMany(UsersLevel::class, 'UserId');
	}
}
