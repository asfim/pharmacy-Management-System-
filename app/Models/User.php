<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User
 * 
 * @property int $id
 * @property int|null $employee_id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string $status
 * @property Carbon|null $last_login_at
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Employee|null $employee
 * @property Collection|AuditLog[] $audit_logs
 * @property Collection|Blog[] $blogs
 * @property Collection|LoginHistory[] $login_histories
 * @property Collection|OrderNote[] $order_notes
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;
	protected $table = 'users';

	protected $casts = [
		'employee_id' => 'int',
		'email_verified_at' => 'datetime',
		'last_login_at' => 'datetime'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'employee_id',
		'name',
		'email',
		'email_verified_at',
		'password',
		'status',
		'last_login_at',
		'remember_token'
	];

	public function employee()
	{
		return $this->belongsTo(Employee::class);
	}

	public function audit_logs()
	{
		return $this->hasMany(AuditLog::class);
	}

	public function blogs()
	{
		return $this->hasMany(Blog::class, 'author_id');
	}

	public function login_histories()
	{
		return $this->hasMany(LoginHistory::class);
	}

	public function order_notes()
	{
		return $this->hasMany(OrderNote::class);
	}
}
