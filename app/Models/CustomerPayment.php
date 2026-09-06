<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CustomerPayment
 * 
 * @property int $id
 * @property int $customer_id
 * @property int|null $sale_id
 * @property int|null $order_id
 * @property int $account_id
 * @property float $amount
 * @property string|null $method
 * @property Carbon $date
 * @property string|null $reference
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Account $account
 * @property Customer $customer
 *
 * @package App\Models
 */
class CustomerPayment extends Model
{
	protected $table = 'customer_payments';

	protected $casts = [
		'customer_id' => 'int',
		'sale_id' => 'int',
		'order_id' => 'int',
		'account_id' => 'int',
		'amount' => 'float',
		'date' => 'datetime'
	];

	protected $fillable = [
		'customer_id',
		'sale_id',
		'order_id',
		'account_id',
		'amount',
		'method',
		'date',
		'reference'
	];

	public function account()
	{
		return $this->belongsTo(Account::class);
	}

	public function customer()
	{
		return $this->belongsTo(Customer::class);
	}
}
