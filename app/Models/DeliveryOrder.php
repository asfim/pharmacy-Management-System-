<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DeliveryOrder
 * 
 * @property int $id
 * @property int $order_id
 * @property int|null $delivery_staff_id
 * @property int|null $address_id
 * @property float $delivery_charge
 * @property string|null $zone
 * @property string $status
 * @property Carbon|null $assigned_at
 * @property Carbon|null $delivered_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property CustomerAddress|null $customer_address
 * @property Employee|null $employee
 * @property OnlineOrder $online_order
 *
 * @package App\Models
 */
class DeliveryOrder extends Model
{
	protected $table = 'delivery_orders';

	protected $casts = [
		'order_id' => 'int',
		'delivery_staff_id' => 'int',
		'address_id' => 'int',
		'delivery_charge' => 'float',
		'assigned_at' => 'datetime',
		'delivered_at' => 'datetime'
	];

	protected $fillable = [
		'order_id',
		'delivery_staff_id',
		'address_id',
		'delivery_charge',
		'zone',
		'status',
		'assigned_at',
		'delivered_at'
	];

	public function customer_address()
	{
		return $this->belongsTo(CustomerAddress::class, 'address_id');
	}

	public function employee()
	{
		return $this->belongsTo(Employee::class, 'delivery_staff_id');
	}

	public function online_order()
	{
		return $this->belongsTo(OnlineOrder::class, 'order_id');
	}
}
