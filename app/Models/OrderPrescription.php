<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderPrescription
 * 
 * @property int $order_id
 * @property int $prescription_id
 * 
 * @property OnlineOrder $online_order
 * @property Prescription $prescription
 *
 * @package App\Models
 */
class OrderPrescription extends Model
{
	protected $table = 'order_prescriptions';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'order_id' => 'int',
		'prescription_id' => 'int'
	];

	public function online_order()
	{
		return $this->belongsTo(OnlineOrder::class, 'order_id');
	}

	public function prescription()
	{
		return $this->belongsTo(Prescription::class);
	}
}
