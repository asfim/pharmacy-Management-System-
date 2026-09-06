<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SalaryPayment
 * 
 * @property int $id
 * @property int $payroll_id
 * @property int $account_id
 * @property float $amount
 * @property Carbon $payment_date
 * @property string|null $reference
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Account $account
 * @property Payroll $payroll
 *
 * @package App\Models
 */
class SalaryPayment extends Model
{
	protected $table = 'salary_payments';

	protected $casts = [
		'payroll_id' => 'int',
		'account_id' => 'int',
		'amount' => 'float',
		'payment_date' => 'datetime'
	];

	protected $fillable = [
		'payroll_id',
		'account_id',
		'amount',
		'payment_date',
		'reference'
	];

	public function account()
	{
		return $this->belongsTo(Account::class);
	}

	public function payroll()
	{
		return $this->belongsTo(Payroll::class);
	}
}
