<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LoginHistory
 * 
 * @property int $id
 * @property int $user_id
 * @property string|null $ip
 * @property string|null $user_agent
 * @property Carbon|null $login_at
 * @property Carbon|null $logout_at
 * @property bool $success
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 *
 * @package App\Models
 */
class LoginHistory extends Model
{
	protected $table = 'login_history';

	protected $casts = [
		'user_id' => 'int',
		'login_at' => 'datetime',
		'logout_at' => 'datetime',
		'success' => 'bool'
	];

	protected $fillable = [
		'user_id',
		'ip',
		'user_agent',
		'login_at',
		'logout_at',
		'success'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
