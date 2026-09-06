<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesReturnItem
 * 
 * @property int $id
 * @property int $return_id
 * @property int $product_id
 * @property int|null $batch_id
 * @property int $quantity
 * @property float $refund_amount
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Batch|null $batch
 * @property Product $product
 * @property SalesReturn $sales_return
 *
 * @package App\Models
 */
class SalesReturnItem extends Model
{
	protected $table = 'sales_return_items';

	protected $casts = [
		'return_id' => 'int',
		'product_id' => 'int',
		'batch_id' => 'int',
		'quantity' => 'int',
		'refund_amount' => 'float'
	];

	protected $fillable = [
		'return_id',
		'product_id',
		'batch_id',
		'quantity',
		'refund_amount'
	];

	public function batch()
	{
		return $this->belongsTo(Batch::class);
	}

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function sales_return()
	{
		return $this->belongsTo(SalesReturn::class, 'return_id');
	}
}
