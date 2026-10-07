<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TbOrder
 * 
 * @property int $id
 * @property string|null $orderNumber
 * @property string|null $userCode
 * @property string|null $residence_name
 * @property string|null $residence_lastname
 * @property string|null $residence_tel
 * @property string|null $residence_address
 * @property int|null $residence_province
 * @property int|null $residence_amphures
 * @property int|null $residence_district
 * @property string|null $residence_zipcode
 * @property string|null $residence_massage
 * @property int|null $statusReceipts
 * @property string|null $receipt_type
 * @property string|null $receipt_tax
 * @property string|null $receipt_company
 * @property string|null $receipt_branch
 * @property string|null $receipt_name
 * @property string|null $receipt_lastname
 * @property string|null $receipt_tel
 * @property string|null $receipt_address
 * @property int|null $receipt_province
 * @property int|null $receipt_amphures
 * @property int|null $receipt_district
 * @property string|null $receipt_zipcode
 * @property string|null $subtotal
 * @property string|null $priceVAT
 * @property string|null $priceWithholding
 * @property string|null $priceNettotal
 * @property string|null $conditionType
 * @property string|null $conditionValue
 * @property string|null $conditionName
 * @property string|null $totaldiscount
 * @property string|null $totalCart
 * @property int|null $payment_type
 * @property string|null $chargeId
 * @property string|null $installmentType
 * @property string|null $installmentTerm
 * @property string|null $statusCode
 * @property int|null $payment_status
 * @property int $orderSuccessful
 * @property string|null $payment_massage
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $transportId
 * @property string|null $tracking
 * @property string|null $transport_link
 * @property string|null $tracking_remark
 * @property string|null $tracking_updated_by
 * @property string|null $tracking_updated_at
 * @property int|null $staffOf
 * @property string|null $staff_remark
 * @property string|null $staff_updated_by
 * @property string|null $staff_updated_at
 * 
 * @property TbSettingPaymentStatus|null $tb_setting_payment_status
 * @property TbSettingAmphure|null $tb_setting_amphure
 * @property TbSettingDistrict|null $tb_setting_district
 * @property TbSettingProvince|null $tb_setting_province
 * @property User|null $user
 * @property TbSettingTransport|null $tb_setting_transport
 * @property Collection|TbOrderDetail[] $tb_order_details
 * @property Collection|TbOrderPayment[] $tb_order_payments
 * @property Collection|TbSoftwareNotify[] $tb_software_notifies
 *
 * @package App\Models
 */
class TbOrder extends Model
{
	protected $table = 'tb_order';

	protected $casts = [
		'residence_province' => 'int',
		'residence_amphures' => 'int',
		'residence_district' => 'int',
		'statusReceipts' => 'int',
		'receipt_province' => 'int',
		'receipt_amphures' => 'int',
		'receipt_district' => 'int',
		'payment_type' => 'int',
		'payment_status' => 'int',
		'orderSuccessful' => 'int',
		'transportId' => 'int',
		'staffOf' => 'int'
	];

	protected $fillable = [
		'orderNumber',
		'userCode',
		'residence_name',
		'residence_lastname',
		'residence_tel',
		'residence_address',
		'residence_province',
		'residence_amphures',
		'residence_district',
		'residence_zipcode',
		'residence_massage',
		'statusReceipts',
		'receipt_type',
		'receipt_tax',
		'receipt_company',
		'receipt_branch',
		'receipt_name',
		'receipt_lastname',
		'receipt_tel',
		'receipt_address',
		'receipt_province',
		'receipt_amphures',
		'receipt_district',
		'receipt_zipcode',
		'subtotal',
		'priceVAT',
		'priceWithholding',
		'priceNettotal',
		'conditionType',
		'conditionValue',
		'conditionName',
		'totaldiscount',
		'totalCart',
		'payment_type',
		'chargeId',
		'installmentType',
		'installmentTerm',
		'statusCode',
		'payment_status',
		'orderSuccessful',
		'payment_massage',
		'transportId',
		'tracking',
		'transport_link',
		'tracking_remark',
		'tracking_updated_by',
		'tracking_updated_at',
		'staffOf',
		'staff_remark',
		'staff_updated_by',
		'staff_updated_at'
	];

	public function tb_setting_payment_status()
	{
		return $this->belongsTo(TbSettingPaymentStatus::class, 'payment_status');
	}

	public function tb_setting_amphure()
	{
		return $this->belongsTo(TbSettingAmphure::class, 'residence_amphures');
	}

	public function tb_setting_district()
	{
		return $this->belongsTo(TbSettingDistrict::class, 'residence_district');
	}

	public function tb_setting_province()
	{
		return $this->belongsTo(TbSettingProvince::class, 'residence_province');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'staffOf');
	}

	public function tb_setting_transport()
	{
		return $this->belongsTo(TbSettingTransport::class, 'transportId');
	}

	public function tb_order_details()
	{
		return $this->hasMany(TbOrderDetail::class, 'orderId');
	}

	public function tb_order_payments()
	{
		return $this->hasMany(TbOrderPayment::class, 'orderId');
	}

	public function tb_software_notifies()
	{
		return $this->hasMany(TbSoftwareNotify::class, 'orderId');
	}

	public function tb_receipt_amphures()
	{
		return $this->belongsTo(TbSettingAmphure::class, 'receipt_amphures');
	}

	public function tb_receipt_district()
	{
		return $this->belongsTo(TbSettingDistrict::class, 'receipt_district');
	}

	public function tb_receipt_province()
	{
		return $this->belongsTo(TbSettingProvince::class, 'receipt_province');
	}
}
