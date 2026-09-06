<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AuditLog
 * 
 * @property int $id
 * @property int|null $user_id
 * @property int|null $branch_id
 * @property string $action
 * @property string|null $module
 * @property string|null $table_name
 * @property int|null $record_id
 * @property array|null $old_values_json
 * @property array|null $new_values_json
 * @property string|null $ip
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Branch|null $branch
 * @property User|null $user
 *
 * @package App\Models
 */
class AuditLog extends Model
{
	protected $table = 'audit_logs';

	protected $casts = [
		'user_id' => 'int',
		'branch_id' => 'int',
		'record_id' => 'int',
		'old_values_json' => 'json',
		'new_values_json' => 'json'
	];

	protected $fillable = [
		'user_id',
		'branch_id',
		'action',
		'module',
		'table_name',
		'record_id',
		'old_values_json',
		'new_values_json',
		'ip'
	];

	public function branch()
	{
		return $this->belongsTo(Branch::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
