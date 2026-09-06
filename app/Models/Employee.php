<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Employee
 * 
 * @property int $id
 * @property int $branch_id
 * @property string $name
 * @property string $phone
 * @property string|null $address
 * @property Carbon|null $joining_date
 * @property float $salary
 * @property int|null $role_id
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Branch $branch
 * @property Collection|Attendance[] $attendances
 * @property Collection|DeliveryOrder[] $delivery_orders
 * @property Collection|LeaveRequest[] $leave_requests
 * @property Collection|Payroll[] $payrolls
 * @property Collection|Sale[] $sales
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Employee extends Model
{
	protected $table = 'employees';

	protected $casts = [
		'branch_id' => 'int',
		'joining_date' => 'datetime',
		'salary' => 'float',
		'role_id' => 'int'
	];

	protected $fillable = [
		'branch_id',
		'name',
		'phone',
		'address',
		'joining_date',
		'salary',
		'role_id',
		'status'
	];

	public function branch()
	{
		return $this->belongsTo(Branch::class);
	}

	public function attendances()
	{
		return $this->hasMany(Attendance::class);
	}

	public function delivery_orders()
	{
		return $this->hasMany(DeliveryOrder::class, 'delivery_staff_id');
	}

	public function leave_requests()
	{
		return $this->hasMany(LeaveRequest::class);
	}

	public function payrolls()
	{
		return $this->hasMany(Payroll::class);
	}

	public function sales()
	{
		return $this->hasMany(Sale::class);
	}

	public function users()
	{
		return $this->hasMany(User::class);
	}
}
