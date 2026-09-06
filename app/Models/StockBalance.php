<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StockBalance
 * 
 * @property int $id
 * @property int $branch_id
 * @property int $product_id
 * @property int|null $batch_id
 * @property int|null $location_id
 * @property int $qty_on_hand
 * @property int $reserved_qty
 * @property int $damaged_qty
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Batch|null $batch
 * @property Branch $branch
 * @property Location|null $location
 * @property Product $product
 *
 * @package App\Models
 */
class StockBalance extends Model
{
	protected $table = 'stock_balances';

	protected $casts = [
		'branch_id' => 'int',
		'product_id' => 'int',
		'batch_id' => 'int',
		'location_id' => 'int',
		'qty_on_hand' => 'int',
		'reserved_qty' => 'int',
		'damaged_qty' => 'int'
	];

	protected $fillable = [
		'branch_id',
		'product_id',
		'batch_id',
		'location_id',
		'qty_on_hand',
		'reserved_qty',
		'damaged_qty'
	];

	public function batch()
	{
		return $this->belongsTo(Batch::class);
	}

	public function branch()
	{
		return $this->belongsTo(Branch::class);
	}

	public function location()
	{
		return $this->belongsTo(Location::class);
	}

	public function product()
	{
		return $this->belongsTo(Product::class);
	}
}
