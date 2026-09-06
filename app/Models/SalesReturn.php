<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesReturn
 * 
 * @property int $id
 * @property int $sale_id
 * @property int|null $customer_id
 * @property int $branch_id
 * @property Carbon $return_date
 * @property float $refund_amount
 * @property string|null $reason
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Branch $branch
 * @property Customer|null $customer
 * @property Sale $sale
 * @property Collection|SalesReturnItem[] $sales_return_items
 *
 * @package App\Models
 */
class SalesReturn extends Model
{
	protected $table = 'sales_returns';

	protected $casts = [
		'sale_id' => 'int',
		'customer_id' => 'int',
		'branch_id' => 'int',
		'return_date' => 'datetime',
		'refund_amount' => 'float'
	];

	protected $fillable = [
		'sale_id',
		'customer_id',
		'branch_id',
		'return_date',
		'refund_amount',
		'reason',
		'status'
	];

	public function branch()
	{
		return $this->belongsTo(Branch::class);
	}

	public function customer()
	{
		return $this->belongsTo(Customer::class);
	}

	public function sale()
	{
		return $this->belongsTo(Sale::class);
	}

	public function sales_return_items()
	{
		return $this->hasMany(SalesReturnItem::class, 'return_id');
	}
}
