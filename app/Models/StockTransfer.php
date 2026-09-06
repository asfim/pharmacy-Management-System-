<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StockTransfer
 * 
 * @property int $id
 * @property int $source_branch_id
 * @property int $destination_branch_id
 * @property string $transfer_no
 * @property string $status
 * @property Carbon|null $shipped_at
 * @property Carbon|null $received_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Branch $branch
 * @property Collection|StockTransferItem[] $stock_transfer_items
 *
 * @package App\Models
 */
class StockTransfer extends Model
{
	protected $table = 'stock_transfers';

	protected $casts = [
		'source_branch_id' => 'int',
		'destination_branch_id' => 'int',
		'shipped_at' => 'datetime',
		'received_at' => 'datetime'
	];

	protected $fillable = [
		'source_branch_id',
		'destination_branch_id',
		'transfer_no',
		'status',
		'shipped_at',
		'received_at'
	];

	public function branch()
	{
		return $this->belongsTo(Branch::class, 'source_branch_id');
	}

	public function stock_transfer_items()
	{
		return $this->hasMany(StockTransferItem::class, 'transfer_id');
	}
}
