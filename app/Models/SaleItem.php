<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SaleItem
 * 
 * @property int $id
 * @property int $sale_id
 * @property int $product_id
 * @property int|null $batch_id
 * @property int $quantity
 * @property float $price
 * @property float $discount
 * @property float $vat
 * @property float $total
 * @property float $cost_price
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Batch|null $batch
 * @property Product $product
 * @property Sale $sale
 *
 * @package App\Models
 */
class SaleItem extends Model
{
	protected $table = 'sale_items';

	protected $casts = [
		'sale_id' => 'int',
		'product_id' => 'int',
		'batch_id' => 'int',
		'quantity' => 'int',
		'price' => 'float',
		'discount' => 'float',
		'vat' => 'float',
		'total' => 'float',
		'cost_price' => 'float'
	];

	protected $fillable = [
		'sale_id',
		'product_id',
		'batch_id',
		'quantity',
		'price',
		'discount',
		'vat',
		'total',
		'cost_price'
	];

	public function batch()
	{
		return $this->belongsTo(Batch::class);
	}

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function sale()
	{
		return $this->belongsTo(Sale::class);
	}
}
