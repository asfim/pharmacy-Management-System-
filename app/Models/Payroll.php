<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Payroll
 * 
 * @property int $id
 * @property int $employee_id
 * @property int $branch_id
 * @property string $month
 * @property float $basic_salary
 * @property float $allowance
 * @property float $bonus
 * @property float $overtime
 * @property float $deductions
 * @property float $advance
 * @property float $absent_deduction
 * @property float $net_salary
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Branch $branch
 * @property Employee $employee
 * @property Collection|SalaryPayment[] $salary_payments
 *
 * @package App\Models
 */
class Payroll extends Model
{
	protected $table = 'payroll';

	protected $casts = [
		'employee_id' => 'int',
		'branch_id' => 'int',
		'basic_salary' => 'float',
		'allowance' => 'float',
		'bonus' => 'float',
		'overtime' => 'float',
		'deductions' => 'float',
		'advance' => 'float',
		'absent_deduction' => 'float',
		'net_salary' => 'float'
	];

	protected $fillable = [
		'employee_id',
		'branch_id',
		'month',
		'basic_salary',
		'allowance',
		'bonus',
		'overtime',
		'deductions',
		'advance',
		'absent_deduction',
		'net_salary',
		'status'
	];

	public function branch()
	{
		return $this->belongsTo(Branch::class);
	}

	public function employee()
	{
		return $this->belongsTo(Employee::class);
	}

	public function salary_payments()
	{
		return $this->hasMany(SalaryPayment::class);
	}
}
