<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PurchaseReturnItem
 * 
 * @property int $id
 * @property int $return_id
 * @property int $product_id
 * @property int|null $batch_id
 * @property int $quantity
 * @property float $amount
 * @property string|null $reason
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Batch|null $batch
 * @property Product $product
 * @property PurchaseReturn $purchase_return
 *
 * @package App\Models
 */
class PurchaseReturnItem extends Model
{
	protected $table = 'purchase_return_items';

	protected $casts = [
		'return_id' => 'int',
		'product_id' => 'int',
		'batch_id' => 'int',
		'quantity' => 'int',
		'amount' => 'float'
	];

	protected $fillable = [
		'return_id',
		'product_id',
		'batch_id',
		'quantity',
		'amount',
		'reason'
	];

	public function batch()
	{
		return $this->belongsTo(Batch::class);
	}

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function purchase_return()
	{
		return $this->belongsTo(PurchaseReturn::class, 'return_id');
	}
}
