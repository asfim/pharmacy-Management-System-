<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LeaveRequest
 * 
 * @property int $id
 * @property int $employee_id
 * @property Carbon $start_date
 * @property Carbon $end_date
 * @property string $leave_type
 * @property string $status
 * @property int|null $approved_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Employee $employee
 *
 * @package App\Models
 */
class LeaveRequest extends Model
{
	protected $table = 'leave_requests';

	protected $casts = [
		'employee_id' => 'int',
		'start_date' => 'datetime',
		'end_date' => 'datetime',
		'approved_by' => 'int'
	];

	protected $fillable = [
		'employee_id',
		'start_date',
		'end_date',
		'leave_type',
		'status',
		'approved_by'
	];

	public function employee()
	{
		return $this->belongsTo(Employee::class);
	}
}
