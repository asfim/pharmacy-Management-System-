<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Notification
 * 
 * @property int $id
 * @property int|null $user_id
 * @property int|null $customer_id
 * @property string $type
 * @property string $title
 * @property string $message
 * @property string $channel
 * @property string $status
 * @property Carbon|null $read_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Notification extends Model
{
	protected $table = 'notifications';

	protected $casts = [
		'user_id' => 'int',
		'customer_id' => 'int',
		'read_at' => 'datetime'
	];

	protected $fillable = [
		'user_id',
		'customer_id',
		'type',
		'title',
		'message',
		'channel',
		'status',
		'read_at'
	];
}
