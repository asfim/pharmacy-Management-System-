<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CouponUsage
 * 
 * @property int $id
 * @property int $coupon_id
 * @property int $customer_id
 * @property int $order_id
 * @property float $discount_amount
 * @property Carbon $used_at
 * 
 * @property Coupon $coupon
 * @property Customer $customer
 * @property OnlineOrder $online_order
 *
 * @package App\Models
 */
class CouponUsage extends Model
{
	protected $table = 'coupon_usages';
	public $timestamps = false;

	protected $casts = [
		'coupon_id' => 'int',
		'customer_id' => 'int',
		'order_id' => 'int',
		'discount_amount' => 'float',
		'used_at' => 'datetime'
	];

	protected $fillable = [
		'coupon_id',
		'customer_id',
		'order_id',
		'discount_amount',
		'used_at'
	];

	public function coupon()
	{
		return $this->belongsTo(Coupon::class);
	}

	public function customer()
	{
		return $this->belongsTo(Customer::class);
	}

	public function online_order()
	{
		return $this->belongsTo(OnlineOrder::class, 'order_id');
	}
}
