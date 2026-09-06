<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderStatusHistory
 * 
 * @property int $id
 * @property int $order_id
 * @property string|null $old_status
 * @property string $new_status
 * @property int|null $changed_by
 * @property string|null $note
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property OnlineOrder $online_order
 *
 * @package App\Models
 */
class OrderStatusHistory extends Model
{
	protected $table = 'order_status_history';

	protected $casts = [
		'order_id' => 'int',
		'changed_by' => 'int'
	];

	protected $fillable = [
		'order_id',
		'old_status',
		'new_status',
		'changed_by',
		'note'
	];

	public function online_order()
	{
		return $this->belongsTo(OnlineOrder::class, 'order_id');
	}
}
