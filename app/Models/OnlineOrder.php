<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OnlineOrder
 * 
 * @property int $id
 * @property string $order_no
 * @property int $customer_id
 * @property int|null $branch_id
 * @property string $status
 * @property string $payment_status
 * @property string $fulfillment_status
 * @property float $subtotal
 * @property float $discount
 * @property float $delivery_charge
 * @property float $vat
 * @property float $total
 * @property int|null $address_id
 * @property bool $prescription_required
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property CustomerAddress|null $customer_address
 * @property Branch|null $branch
 * @property Customer $customer
 * @property Collection|CouponUsage[] $coupon_usages
 * @property Collection|DeliveryOrder[] $delivery_orders
 * @property Collection|OrderItem[] $order_items
 * @property Collection|OrderNote[] $order_notes
 * @property Collection|OrderPayment[] $order_payments
 * @property Collection|OrderPrescription[] $order_prescriptions
 * @property Collection|OrderStatusHistory[] $order_status_histories
 * @property Collection|ProductReview[] $product_reviews
 * @property Collection|Refund[] $refunds
 * @property Collection|Return[] $returns
 *
 * @package App\Models
 */
class OnlineOrder extends Model
{
	protected $table = 'online_orders';

	protected $casts = [
		'customer_id' => 'int',
		'branch_id' => 'int',
		'subtotal' => 'float',
		'discount' => 'float',
		'delivery_charge' => 'float',
		'vat' => 'float',
		'total' => 'float',
		'address_id' => 'int',
		'prescription_required' => 'bool'
	];

	protected $fillable = [
		'order_no',
		'customer_id',
		'branch_id',
		'status',
		'payment_status',
		'fulfillment_status',
		'subtotal',
		'discount',
		'delivery_charge',
		'vat',
		'total',
		'address_id',
		'prescription_required'
	];

	public function customer_address()
	{
		return $this->belongsTo(CustomerAddress::class, 'address_id');
	}

	public function branch()
	{
		return $this->belongsTo(Branch::class);
	}

	public function customer()
	{
		return $this->belongsTo(Customer::class);
	}

	public function coupon_usages()
	{
		return $this->hasMany(CouponUsage::class, 'order_id');
	}

	public function delivery_orders()
	{
		return $this->hasMany(DeliveryOrder::class, 'order_id');
	}

	public function order_items()
	{
		return $this->hasMany(OrderItem::class, 'order_id');
	}

	public function order_notes()
	{
		return $this->hasMany(OrderNote::class, 'order_id');
	}

	public function order_payments()
	{
		return $this->hasMany(OrderPayment::class, 'order_id');
	}

	public function order_prescriptions()
	{
		return $this->hasMany(OrderPrescription::class, 'order_id');
	}

	public function order_status_histories()
	{
		return $this->hasMany(OrderStatusHistory::class, 'order_id');
	}

	public function product_reviews()
	{
		return $this->hasMany(ProductReview::class, 'order_id');
	}

	public function refunds()
	{
		return $this->hasMany(Refund::class, 'order_id');
	}

	public function returns()
	{
		return $this->hasMany('App\Models\Return', 'order_id');
	}
}
