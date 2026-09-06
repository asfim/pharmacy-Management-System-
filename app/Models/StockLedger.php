<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StockLedger
 * 
 * @property int $id
 * @property int $branch_id
 * @property int $product_id
 * @property int|null $batch_id
 * @property string $transaction_type
 * @property string|null $reference_type
 * @property int|null $reference_id
 * @property int $qty_in
 * @property int $qty_out
 * @property int $balance_after
 * @property float $unit_cost
 * @property int|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Batch|null $batch
 * @property Branch $branch
 * @property Product $product
 *
 * @package App\Models
 */
class StockLedger extends Model
{
	protected $table = 'stock_ledger';

	protected $casts = [
		'branch_id' => 'int',
		'product_id' => 'int',
		'batch_id' => 'int',
		'reference_id' => 'int',
		'qty_in' => 'int',
		'qty_out' => 'int',
		'balance_after' => 'int',
		'unit_cost' => 'float',
		'created_by' => 'int'
	];

	protected $fillable = [
		'branch_id',
		'product_id',
		'batch_id',
		'transaction_type',
		'reference_type',
		'reference_id',
		'qty_in',
		'qty_out',
		'balance_after',
		'unit_cost',
		'created_by'
	];

	public function batch()
	{
		return $this->belongsTo(Batch::class);
	}

	public function branch()
	{
		return $this->belongsTo(Branch::class);
	}

	public function product()
	{
		return $this->belongsTo(Product::class);
	}
}
