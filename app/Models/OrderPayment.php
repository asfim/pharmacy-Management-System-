<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderPayment
 * 
 * @property int $id
 * @property int $order_id
 * @property int|null $account_id
 * @property string|null $gateway
 * @property string|null $transaction_id
 * @property float $amount
 * @property string $status
 * @property Carbon|null $paid_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Account|null $account
 * @property OnlineOrder $online_order
 * @property Collection|Refund[] $refunds
 *
 * @package App\Models
 */
class OrderPayment extends Model
{
	protected $table = 'order_payments';

	protected $casts = [
		'order_id' => 'int',
		'account_id' => 'int',
		'amount' => 'float',
		'paid_at' => 'datetime'
	];

	protected $fillable = [
		'order_id',
		'account_id',
		'gateway',
		'transaction_id',
		'amount',
		'status',
		'paid_at'
	];

	public function account()
	{
		return $this->belongsTo(Account::class);
	}

	public function online_order()
	{
		return $this->belongsTo(OnlineOrder::class, 'order_id');
	}

	public function refunds()
	{
		return $this->hasMany(Refund::class, 'payment_id');
	}
}
