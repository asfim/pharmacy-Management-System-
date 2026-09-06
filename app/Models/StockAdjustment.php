<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StockAdjustment
 * 
 * @property int $id
 * @property int $branch_id
 * @property Carbon $adjustment_date
 * @property string|null $reason
 * @property int|null $approved_by
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Branch $branch
 * @property Collection|StockAdjustmentItem[] $stock_adjustment_items
 *
 * @package App\Models
 */
class StockAdjustment extends Model
{
	protected $table = 'stock_adjustments';

	protected $casts = [
		'branch_id' => 'int',
		'adjustment_date' => 'datetime',
		'approved_by' => 'int'
	];

	protected $fillable = [
		'branch_id',
		'adjustment_date',
		'reason',
		'approved_by',
		'status'
	];

	public function branch()
	{
		return $this->belongsTo(Branch::class);
	}

	public function stock_adjustment_items()
	{
		return $this->hasMany(StockAdjustmentItem::class, 'adjustment_id');
	}
}
