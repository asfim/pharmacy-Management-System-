<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DamageWastage
 * 
 * @property int $id
 * @property int $branch_id
 * @property int $product_id
 * @property int|null $batch_id
 * @property int $quantity
 * @property string|null $reason
 * @property float $cost
 * @property Carbon $date
 * @property int|null $approved_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Batch|null $batch
 * @property Branch $branch
 * @property Product $product
 *
 * @package App\Models
 */
class DamageWastage extends Model
{
	protected $table = 'damage_wastage';

	protected $casts = [
		'branch_id' => 'int',
		'product_id' => 'int',
		'batch_id' => 'int',
		'quantity' => 'int',
		'cost' => 'float',
		'date' => 'datetime',
		'approved_by' => 'int'
	];

	protected $fillable = [
		'branch_id',
		'product_id',
		'batch_id',
		'quantity',
		'reason',
		'cost',
		'date',
		'approved_by'
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
