<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderItem
 * 
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property int $quantity
 * @property float $unit_price
 * @property float $discount
 * @property float $vat
 * @property float $total
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property OnlineOrder $online_order
 * @property Product $product
 *
 * @package App\Models
 */
class OrderItem extends Model
{
	protected $table = 'order_items';

	protected $casts = [
		'order_id' => 'int',
		'product_id' => 'int',
		'quantity' => 'int',
		'unit_price' => 'float',
		'discount' => 'float',
		'vat' => 'float',
		'total' => 'float'
	];

	protected $fillable = [
		'order_id',
		'product_id',
		'quantity',
		'unit_price',
		'discount',
		'vat',
		'total'
	];

	public function online_order()
	{
		return $this->belongsTo(OnlineOrder::class, 'order_id');
	}

	public function product()
	{
		return $this->belongsTo(Product::class);
	}
}
