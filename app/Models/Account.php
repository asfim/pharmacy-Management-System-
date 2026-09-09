<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Account
 * 
 * @property int $id
 * @property int|null $branch_id
 * @property string $name
 * @property string $type
 * @property float $opening_balance
 * @property float $current_balance
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Branch|null $branch
 * @property Collection|CashTransfer[] $cash_transfers
 * @property Collection|CustomerPayment[] $customer_payments
 * @property Collection|Expense[] $expenses
 * @property Collection|FinancialTransaction[] $financial_transactions
 * @property Collection|Income[] $incomes
 * @property Collection|OrderPayment[] $order_payments
 * @property Collection|SalaryPayment[] $salary_payments
 * @property Collection|SalePayment[] $sale_payments
 * @property Collection|SupplierPayment[] $supplier_payments
 *
 * @package App\Models
 */
class Account extends Model
{
	protected $table = 'accounts';

	protected $casts = [
		'branch_id' => 'int',
		'opening_balance' => 'float',
		'current_balance' => 'float'
	];

	protected $fillable = [
		'branch_id',
		'name',
        'account_number',
        'bank_name',
		'type',
		'opening_balance',
		'current_balance',
		'status'
	];

	public function branch()
	{
		return $this->belongsTo(Branch::class);
	}

	public function cash_transfers()
	{
		return $this->hasMany(CashTransfer::class, 'to_account_id');
	}

	public function customer_payments()
	{
		return $this->hasMany(CustomerPayment::class);
	}

	public function expenses()
	{
		return $this->hasMany(Expense::class);
	}

	public function financial_transactions()
	{
		return $this->hasMany(FinancialTransaction::class);
	}

	public function incomes()
	{
		return $this->hasMany(Income::class);
	}

	public function order_payments()
	{
		return $this->hasMany(OrderPayment::class);
	}

	public function salary_payments()
	{
		return $this->hasMany(SalaryPayment::class);
	}

	public function sale_payments()
	{
		return $this->hasMany(SalePayment::class);
	}

	public function supplier_payments()
	{
		return $this->hasMany(SupplierPayment::class);
	}
}
