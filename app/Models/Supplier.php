<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Supplier
 * 
 * @property int $id
 * @property string $company_name
 * @property string|null $contact_person
 * @property string|null $phone
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|PurchaseInvoice[] $purchase_invoices
 * @property Collection|PurchaseReturn[] $purchase_returns
 * @property Collection|SupplierPayment[] $supplier_payments
 *
 * @package App\Models
 */
class Supplier extends Model
{
	protected $table = 'suppliers';

	protected $fillable = [
		'company_name',
		'contact_person',
		'phone',
		'status'
	];

	public function purchase_invoices()
	{
		return $this->hasMany(PurchaseInvoice::class);
	}

	public function purchaseInvoices()
	{
		return $this->hasMany(PurchaseInvoice::class);
	}

	public function purchase_returns()
	{
		return $this->hasMany(PurchaseReturn::class);
	}

	public function supplier_payments()
	{
		return $this->hasMany(SupplierPayment::class);
	}
}
