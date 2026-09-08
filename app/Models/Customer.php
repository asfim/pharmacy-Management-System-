<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Customer
 * 
 * @property int $id
 * @property string $name
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $address
 * @property Carbon|null $dob
 * @property string|null $gender
 * @property string $customer_type
 * @property float $opening_due
 * @property float $credit_limit
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|CouponUsage[] $coupon_usages
 * @property Collection|CustomerAddress[] $customer_addresses
 * @property Collection|CustomerPayment[] $customer_payments
 * @property Collection|HeldBill[] $held_bills
 * @property Collection|OnlineOrder[] $online_orders
 * @property Collection|Prescription[] $prescriptions
 * @property Collection|ProductReview[] $product_reviews
 * @property Collection|Return[] $returns
 * @property Collection|Sale[] $sales
 * @property Collection|SalesReturn[] $sales_returns
 * @property Collection|Wishlist[] $wishlists
 *
 * @package App\Models
 */
class Customer extends Model
{
	protected $table = 'customers';

	protected $casts = [
		'dob' => 'datetime',
		'opening_balance' => 'float',
		'credit_limit' => 'float'
	];

	protected $fillable = [
		'name',
		'phone',
		'email',
		'address',
		'dob',
		'gender',
		'customer_type',
		'opening_balance',
		'credit_limit',
		'notes',
		'status'
	];

	public function coupon_usages()
	{
		return $this->hasMany(CouponUsage::class);
	}

	public function customer_addresses()
	{
		return $this->hasMany(CustomerAddress::class);
	}

	public function customer_payments()
	{
		return $this->hasMany(CustomerPayment::class);
	}

	public function held_bills()
	{
		return $this->hasMany(HeldBill::class);
	}

	public function online_orders()
	{
		return $this->hasMany(OnlineOrder::class);
	}

	public function onlineOrders()
	{
		return $this->hasMany(OnlineOrder::class);
	}

	public function prescriptions()
	{
		return $this->hasMany(Prescription::class);
	}

	public function product_reviews()
	{
		return $this->hasMany(ProductReview::class);
	}

	public function customerReturns()
	{
		return $this->hasMany(SaleReturn::class);
	}

	public function sales()
	{
		return $this->hasMany(Sale::class);
	}

	public function salesReturns()
	{
		return $this->hasMany(SaleReturn::class);
	}

	public function customerPayments()
	{
		return $this->hasMany(CustomerPayment::class);
	}

	public function wishlists()
	{
		return $this->hasMany(Wishlist::class);
	}
}
