<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HeldBill
 * 
 * @property int $id
 * @property int $branch_id
 * @property int|null $customer_id
 * @property string $cart_reference
 * @property int|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Branch $branch
 * @property Customer|null $customer
 *
 * @package App\Models
 */
class HeldBill extends Model
{
	protected $table = 'held_bills';

	protected $casts = [
		'branch_id' => 'int',
		'customer_id' => 'int',
		'created_by' => 'int'
	];

	protected $fillable = [
		'branch_id',
		'customer_id',
		'cart_reference',
		'created_by'
	];

	public function branch()
	{
		return $this->belongsTo(Branch::class);
	}

	public function customer()
	{
		return $this->belongsTo(Customer::class);
	}
}
