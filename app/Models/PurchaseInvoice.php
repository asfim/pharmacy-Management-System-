<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PurchaseInvoice
 * 
 * @property int $id
 * @property string $invoice_no
 * @property int $supplier_id
 * @property int $branch_id
 * @property Carbon $purchase_date
 * @property float $subtotal
 * @property float $discount
 * @property float $vat
 * @property float $total
 * @property float $paid
 * @property float $due
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Branch $branch
 * @property Supplier $supplier
 * @property Collection|PurchaseItem[] $purchase_items
 * @property Collection|PurchaseReturn[] $purchase_returns
 * @property Collection|SupplierPayment[] $supplier_payments
 *
 * @package App\Models
 */
class PurchaseInvoice extends Model
{
	protected $table = 'purchase_invoices';

	protected $casts = [
		'supplier_id' => 'int',
		'branch_id' => 'int',
		'purchase_date' => 'datetime',
		'subtotal' => 'float',
		'discount' => 'float',
		'vat' => 'float',
		'total' => 'float',
		'paid' => 'float',
		'due' => 'float'
	];

	protected $fillable = [
		'invoice_no',
		'supplier_id',
		'branch_id',
		'purchase_date',
		'subtotal',
		'discount',
		'vat',
		'total',
		'paid',
		'due',
		'status'
	];

	public function branch()
	{
		return $this->belongsTo(Branch::class);
	}

	public function supplier()
	{
		return $this->belongsTo(Supplier::class);
	}

	public function purchase_items()
	{
		return $this->hasMany(PurchaseItem::class, 'purchase_id');
	}

	public function purchase_returns()
	{
		return $this->hasMany(PurchaseReturn::class, 'purchase_id');
	}

	public function supplier_payments()
	{
		return $this->hasMany(SupplierPayment::class, 'purchase_id');
	}
}
