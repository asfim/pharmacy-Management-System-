<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Return
 * 
 * @property int $id
 * @property int $order_id
 * @property int $customer_id
 * @property string|null $reason
 * @property string $status
 * @property int|null $approved_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Customer $customer
 * @property OnlineOrder $online_order
 * @property Collection|ReturnItem[] $return_items
 *
 * @package App\Models
 */
class Return extends Model
{
	protected $table = 'returns';

	protected $casts = [
		'order_id' => 'int',
		'customer_id' => 'int',
		'approved_by' => 'int'
	];

	protected $fillable = [
		'order_id',
		'customer_id',
		'reason',
		'status',
		'approved_by'
	];

	public function customer()
	{
		return $this->belongsTo(Customer::class);
	}

	public function online_order()
	{
		return $this->belongsTo(OnlineOrder::class, 'order_id');
	}

	public function return_items()
	{
		return $this->hasMany(ReturnItem::class);
	}
}
