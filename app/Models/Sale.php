<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Sale
 * 
 * @property int $id
 * @property string $invoice_no
 * @property int $branch_id
 * @property int|null $customer_id
 * @property int|null $employee_id
 * @property Carbon $sale_date
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
 * @property Customer|null $customer
 * @property Employee|null $employee
 * @property Collection|SaleItem[] $sale_items
 * @property Collection|SalePayment[] $sale_payments
 * @property Collection|SalesReturn[] $sales_returns
 *
 * @package App\Models
 */
class Sale extends Model
{
	protected $table = 'sales';

	protected $casts = [
		'branch_id' => 'int',
		'customer_id' => 'int',
		'employee_id' => 'int',
		'sale_date' => 'datetime',
		'subtotal' => 'float',
		'discount' => 'float',
		'vat' => 'float',
		'total' => 'float',
		'paid' => 'float',
		'due' => 'float'
	];

	protected $fillable = [
		'invoice_no',
		'branch_id',
		'customer_id',
		'employee_id',
		'sale_date',
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

	public function customer()
	{
		return $this->belongsTo(Customer::class);
	}

	public function employee()
	{
		return $this->belongsTo(Employee::class);
	}

	public function sale_items()
	{
		return $this->hasMany(SaleItem::class);
	}

	public function items()
	{
		return $this->hasMany(SaleItem::class);
	}

	public function sale_payments()
	{
		return $this->hasMany(SalePayment::class);
	}

	public function sales_returns()
	{
		return $this->hasMany(SalesReturn::class);
	}
}
