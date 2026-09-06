<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PrescriptionItem
 * 
 * @property int $id
 * @property int $prescription_id
 * @property int|null $product_id
 * @property string|null $dose
 * @property string|null $frequency
 * @property string|null $duration
 * @property string|null $instructions
 * @property int $quantity
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Prescription $prescription
 * @property Product|null $product
 *
 * @package App\Models
 */
class PrescriptionItem extends Model
{
	protected $table = 'prescription_items';

	protected $casts = [
		'prescription_id' => 'int',
		'product_id' => 'int',
		'quantity' => 'int'
	];

	protected $fillable = [
		'prescription_id',
		'product_id',
		'dose',
		'frequency',
		'duration',
		'instructions',
		'quantity'
	];

	public function prescription()
	{
		return $this->belongsTo(Prescription::class);
	}

	public function product()
	{
		return $this->belongsTo(Product::class);
	}
}
