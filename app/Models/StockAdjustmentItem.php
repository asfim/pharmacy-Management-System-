<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StockAdjustmentItem
 * 
 * @property int $id
 * @property int $adjustment_id
 * @property int $product_id
 * @property int|null $batch_id
 * @property int $system_qty
 * @property int $physical_qty
 * @property int $difference_qty
 * @property string|null $reason
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property StockAdjustment $stock_adjustment
 * @property Batch|null $batch
 * @property Product $product
 *
 * @package App\Models
 */
class StockAdjustmentItem extends Model
{
	protected $table = 'stock_adjustment_items';

	protected $casts = [
		'adjustment_id' => 'int',
		'product_id' => 'int',
		'batch_id' => 'int',
		'system_qty' => 'int',
		'physical_qty' => 'int',
		'difference_qty' => 'int'
	];

	protected $fillable = [
		'adjustment_id',
		'product_id',
		'batch_id',
		'system_qty',
		'physical_qty',
		'difference_qty',
		'reason'
	];

	public function stock_adjustment()
	{
		return $this->belongsTo(StockAdjustment::class, 'adjustment_id');
	}

	public function batch()
	{
		return $this->belongsTo(Batch::class);
	}

	public function product()
	{
		return $this->belongsTo(Product::class);
	}
}
