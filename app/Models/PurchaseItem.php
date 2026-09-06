<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PurchaseItem
 * 
 * @property int $id
 * @property int $purchase_id
 * @property int $product_id
 * @property int|null $batch_id
 * @property int $quantity
 * @property int $free_quantity
 * @property float $purchase_price
 * @property float $discount
 * @property float $vat
 * @property float $total
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Batch|null $batch
 * @property Product $product
 * @property PurchaseInvoice $purchase_invoice
 *
 * @package App\Models
 */
class PurchaseItem extends Model
{
	protected $table = 'purchase_items';

	protected $casts = [
		'purchase_id' => 'int',
		'product_id' => 'int',
		'batch_id' => 'int',
		'quantity' => 'int',
		'free_quantity' => 'int',
		'purchase_price' => 'float',
		'discount' => 'float',
		'vat' => 'float',
		'total' => 'float'
	];

	protected $fillable = [
		'purchase_id',
		'product_id',
		'batch_id',
		'quantity',
		'free_quantity',
		'purchase_price',
		'discount',
		'vat',
		'total'
	];

	public function batch()
	{
		return $this->belongsTo(Batch::class);
	}

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function purchase_invoice()
	{
		return $this->belongsTo(PurchaseInvoice::class, 'purchase_id');
	}
}
