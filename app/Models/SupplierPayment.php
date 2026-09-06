<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SupplierPayment
 * 
 * @property int $id
 * @property int $supplier_id
 * @property int|null $purchase_id
 * @property int $account_id
 * @property float $amount
 * @property string|null $payment_method
 * @property Carbon $date
 * @property string|null $reference
 * @property string|null $note
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Account $account
 * @property PurchaseInvoice|null $purchase_invoice
 * @property Supplier $supplier
 *
 * @package App\Models
 */
class SupplierPayment extends Model
{
	protected $table = 'supplier_payments';

	protected $casts = [
		'supplier_id' => 'int',
		'purchase_id' => 'int',
		'account_id' => 'int',
		'amount' => 'float',
		'date' => 'datetime'
	];

	protected $fillable = [
		'supplier_id',
		'purchase_id',
		'account_id',
		'amount',
		'payment_method',
		'date',
		'reference',
		'note'
	];

	public function account()
	{
		return $this->belongsTo(Account::class);
	}

	public function purchase_invoice()
	{
		return $this->belongsTo(PurchaseInvoice::class, 'purchase_id');
	}

	public function supplier()
	{
		return $this->belongsTo(Supplier::class);
	}
}
