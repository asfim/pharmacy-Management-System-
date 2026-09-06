<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Doctor
 * 
 * @property int $id
 * @property string $name
 * @property string|null $degree
 * @property string|null $specialization
 * @property string|null $bmdc_no
 * @property string|null $chamber
 * @property string|null $hospital_clinic
 * @property string|null $phone
 * @property string|null $email
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Prescription[] $prescriptions
 *
 * @package App\Models
 */
class Doctor extends Model
{
	protected $table = 'doctors';

	protected $fillable = [
		'name',
		'degree',
		'specialization',
		'bmdc_no',
		'chamber',
		'hospital_clinic',
		'phone',
		'email',
		'status'
	];

	public function prescriptions()
	{
		return $this->hasMany(Prescription::class);
	}
}
