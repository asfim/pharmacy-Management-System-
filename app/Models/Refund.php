<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Refund
 * 
 * @property int $id
 * @property int $order_id
 * @property int|null $payment_id
 * @property float $amount
 * @property string|null $reason
 * @property string $status
 * @property int|null $processed_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property OnlineOrder $online_order
 * @property OrderPayment|null $order_payment
 *
 * @package App\Models
 */
class Refund extends Model
{
	protected $table = 'refunds';

	protected $casts = [
		'order_id' => 'int',
		'payment_id' => 'int',
		'amount' => 'float',
		'processed_by' => 'int'
	];

	protected $fillable = [
		'order_id',
		'payment_id',
		'amount',
		'reason',
		'status',
		'processed_by'
	];

	public function online_order()
	{
		return $this->belongsTo(OnlineOrder::class, 'order_id');
	}

	public function order_payment()
	{
		return $this->belongsTo(OrderPayment::class, 'payment_id');
	}
}
