<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Batch
 * 
 * @property int $id
 * @property int $product_id
 * @property string $batch_no
 * @property Carbon|null $manufacturing_date
 * @property Carbon|null $expiry_date
 * @property float $purchase_price
 * @property float $sale_price
 * @property int $quantity
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Product $product
 * @property Collection|DamageWastage[] $damage_wastages
 * @property Collection|PurchaseItem[] $purchase_items
 * @property Collection|PurchaseReturnItem[] $purchase_return_items
 * @property Collection|SaleItem[] $sale_items
 * @property Collection|SalesReturnItem[] $sales_return_items
 * @property Collection|StockAdjustmentItem[] $stock_adjustment_items
 * @property Collection|StockBalance[] $stock_balances
 * @property Collection|StockLedger[] $stock_ledgers
 * @property Collection|StockTransferItem[] $stock_transfer_items
 *
 * @package App\Models
 */
class Batch extends Model
{
	protected $table = 'batches';

	protected $casts = [
		'product_id' => 'int',
		'manufacturing_date' => 'datetime',
		'expiry_date' => 'datetime',
		'purchase_price' => 'float',
		'sale_price' => 'float',
		'quantity' => 'int'
	];

	protected $fillable = [
		'product_id',
		'batch_no',
		'manufacturing_date',
		'expiry_date',
		'purchase_price',
		'sale_price',
		'quantity'
	];

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function damage_wastages()
	{
		return $this->hasMany(DamageWastage::class);
	}

	public function purchase_items()
	{
		return $this->hasMany(PurchaseItem::class);
	}

	public function purchase_return_items()
	{
		return $this->hasMany(PurchaseReturnItem::class);
	}

	public function sale_items()
	{
		return $this->hasMany(SaleItem::class);
	}

	public function sales_return_items()
	{
		return $this->hasMany(SalesReturnItem::class);
	}

	public function stock_adjustment_items()
	{
		return $this->hasMany(StockAdjustmentItem::class);
	}

	public function stock_balances()
	{
		return $this->hasMany(StockBalance::class);
	}

	public function stock_ledgers()
	{
		return $this->hasMany(StockLedger::class);
	}

	public function stock_transfer_items()
	{
		return $this->hasMany(StockTransferItem::class);
	}
}
