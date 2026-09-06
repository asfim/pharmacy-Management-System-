<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderNote
 * 
 * @property int $id
 * @property int $order_id
 * @property int|null $user_id
 * @property string $note
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property OnlineOrder $online_order
 * @property User|null $user
 *
 * @package App\Models
 */
class OrderNote extends Model
{
	protected $table = 'order_notes';

	protected $casts = [
		'order_id' => 'int',
		'user_id' => 'int'
	];

	protected $fillable = [
		'order_id',
		'user_id',
		'note'
	];

	public function online_order()
	{
		return $this->belongsTo(OnlineOrder::class, 'order_id');
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
