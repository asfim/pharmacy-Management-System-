<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Prescription
 * 
 * @property int $id
 * @property string $prescription_no
 * @property int $customer_id
 * @property int|null $doctor_id
 * @property Carbon $prescription_date
 * @property string|null $image_file
 * @property string $verification_status
 * @property int|null $verified_by
 * @property Carbon|null $verified_at
 * @property string|null $notes
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Customer $customer
 * @property Doctor|null $doctor
 * @property Collection|OrderPrescription[] $order_prescriptions
 * @property Collection|PrescriptionItem[] $prescription_items
 *
 * @package App\Models
 */
class Prescription extends Model
{
	protected $table = 'prescriptions';

	protected $casts = [
		'customer_id' => 'int',
		'doctor_id' => 'int',
		'prescription_date' => 'datetime',
		'verified_by' => 'int',
		'verified_at' => 'datetime'
	];

	protected $fillable = [
		'prescription_no',
		'customer_id',
		'doctor_id',
		'prescription_date',
		'image_file',
		'verification_status',
		'verified_by',
		'verified_at',
		'notes'
	];

	public function customer()
	{
		return $this->belongsTo(Customer::class);
	}

	public function doctor()
	{
		return $this->belongsTo(Doctor::class);
	}

	public function order_prescriptions()
	{
		return $this->hasMany(OrderPrescription::class);
	}

	public function prescription_items()
	{
		return $this->hasMany(PrescriptionItem::class);
	}
}
