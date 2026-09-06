<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Branch
 * 
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string|null $address
 * @property string|null $phone
 * @property bool $is_main
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Account[] $accounts
 * @property Collection|AuditLog[] $audit_logs
 * @property Collection|DamageWastage[] $damage_wastages
 * @property Collection|Employee[] $employees
 * @property Collection|Expense[] $expenses
 * @property Collection|FinancialTransaction[] $financial_transactions
 * @property Collection|HeldBill[] $held_bills
 * @property Collection|Income[] $incomes
 * @property Collection|Location[] $locations
 * @property Collection|OnlineOrder[] $online_orders
 * @property Collection|Payroll[] $payrolls
 * @property Collection|PurchaseInvoice[] $purchase_invoices
 * @property Collection|PurchaseReturn[] $purchase_returns
 * @property Collection|Sale[] $sales
 * @property Collection|SalesReturn[] $sales_returns
 * @property Collection|StockAdjustment[] $stock_adjustments
 * @property Collection|StockBalance[] $stock_balances
 * @property Collection|StockLedger[] $stock_ledgers
 * @property Collection|StockTransfer[] $stock_transfers
 *
 * @package App\Models
 */
class Branch extends Model
{
	protected $table = 'branches';

	protected $casts = [
		'is_main' => 'bool'
	];

	protected $fillable = [
		'code',
		'name',
		'address',
		'phone',
		'is_main',
		'status'
	];

	public function accounts()
	{
		return $this->hasMany(Account::class);
	}

	public function audit_logs()
	{
		return $this->hasMany(AuditLog::class);
	}

	public function damage_wastages()
	{
		return $this->hasMany(DamageWastage::class);
	}

	public function employees()
	{
		return $this->hasMany(Employee::class);
	}

	public function expenses()
	{
		return $this->hasMany(Expense::class);
	}

	public function financial_transactions()
	{
		return $this->hasMany(FinancialTransaction::class);
	}

	public function held_bills()
	{
		return $this->hasMany(HeldBill::class);
	}

	public function incomes()
	{
		return $this->hasMany(Income::class);
	}

	public function locations()
	{
		return $this->hasMany(Location::class);
	}

	public function online_orders()
	{
		return $this->hasMany(OnlineOrder::class);
	}

	public function payrolls()
	{
		return $this->hasMany(Payroll::class);
	}

	public function purchase_invoices()
	{
		return $this->hasMany(PurchaseInvoice::class);
	}

	public function purchase_returns()
	{
		return $this->hasMany(PurchaseReturn::class);
	}

	public function sales()
	{
		return $this->hasMany(Sale::class);
	}

	public function sales_returns()
	{
		return $this->hasMany(SalesReturn::class);
	}

	public function stock_adjustments()
	{
		return $this->hasMany(StockAdjustment::class);
	}

	public function stock_balances()
	{
		return $this->hasMany(StockBalance::class);
	}

	public function stock_ledgers()
	{
		return $this->hasMany(StockLedger::class);
	}

	public function stock_transfers()
	{
		return $this->hasMany(StockTransfer::class, 'source_branch_id');
	}
}
