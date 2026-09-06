<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PurchaseReturn
 * 
 * @property int $id
 * @property int $purchase_id
 * @property int $supplier_id
 * @property int $branch_id
 * @property Carbon $return_date
 * @property string|null $reason
 * @property float $total
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Branch $branch
 * @property PurchaseInvoice $purchase_invoice
 * @property Supplier $supplier
 * @property Collection|PurchaseReturnItem[] $purchase_return_items
 *
 * @package App\Models
 */
class PurchaseReturn extends Model
{
	protected $table = 'purchase_returns';

	protected $casts = [
		'purchase_id' => 'int',
		'supplier_id' => 'int',
		'branch_id' => 'int',
		'return_date' => 'datetime',
		'total' => 'float'
	];

	protected $fillable = [
		'purchase_id',
		'supplier_id',
		'branch_id',
		'return_date',
		'reason',
		'total',
		'status'
	];

	public function branch()
	{
		return $this->belongsTo(Branch::class);
	}

	public function purchase_invoice()
	{
		return $this->belongsTo(PurchaseInvoice::class, 'purchase_id');
	}

	public function supplier()
	{
		return $this->belongsTo(Supplier::class);
	}

	public function purchase_return_items()
	{
		return $this->hasMany(PurchaseReturnItem::class, 'return_id');
	}
}
