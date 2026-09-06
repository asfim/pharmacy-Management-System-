<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StockTransferItem
 * 
 * @property int $id
 * @property int $transfer_id
 * @property int $product_id
 * @property int|null $batch_id
 * @property int $quantity
 * @property int $received_quantity
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Batch|null $batch
 * @property Product $product
 * @property StockTransfer $stock_transfer
 *
 * @package App\Models
 */
class StockTransferItem extends Model
{
	protected $table = 'stock_transfer_items';

	protected $casts = [
		'transfer_id' => 'int',
		'product_id' => 'int',
		'batch_id' => 'int',
		'quantity' => 'int',
		'received_quantity' => 'int'
	];

	protected $fillable = [
		'transfer_id',
		'product_id',
		'batch_id',
		'quantity',
		'received_quantity'
	];

	public function batch()
	{
		return $this->belongsTo(Batch::class);
	}

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function stock_transfer()
	{
		return $this->belongsTo(StockTransfer::class, 'transfer_id');
	}
}
