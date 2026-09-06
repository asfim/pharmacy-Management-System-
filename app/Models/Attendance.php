<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Attendance
 * 
 * @property int $id
 * @property int $employee_id
 * @property Carbon $date
 * @property string $status
 * @property Carbon|null $check_in
 * @property Carbon|null $check_out
 * @property string|null $note
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Employee $employee
 *
 * @package App\Models
 */
class Attendance extends Model
{
	protected $table = 'attendance';

	protected $casts = [
		'employee_id' => 'int',
		'date' => 'datetime',
		'check_in' => 'datetime',
		'check_out' => 'datetime'
	];

	protected $fillable = [
		'employee_id',
		'date',
		'status',
		'check_in',
		'check_out',
		'note'
	];

	public function employee()
	{
		return $this->belongsTo(Employee::class);
	}
}
