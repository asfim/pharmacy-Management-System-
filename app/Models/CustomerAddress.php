<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CustomerAddress
 * 
 * @property int $id
 * @property int $customer_id
 * @property string $name
 * @property string $phone
 * @property string $address_line
 * @property string|null $city
 * @property string|null $zone
 * @property string|null $postal_code
 * @property bool $is_default
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Customer $customer
 * @property Collection|DeliveryOrder[] $delivery_orders
 * @property Collection|OnlineOrder[] $online_orders
 *
 * @package App\Models
 */
class CustomerAddress extends Model
{
	protected $table = 'customer_addresses';

	protected $casts = [
		'customer_id' => 'int',
		'is_default' => 'bool'
	];

	protected $fillable = [
		'customer_id',
		'name',
		'phone',
		'address_line',
		'city',
		'zone',
		'postal_code',
		'is_default'
	];

	public function customer()
	{
		return $this->belongsTo(Customer::class);
	}

	public function delivery_orders()
	{
		return $this->hasMany(DeliveryOrder::class, 'address_id');
	}

	public function online_orders()
	{
		return $this->hasMany(OnlineOrder::class, 'address_id');
	}
}
