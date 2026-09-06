<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SalePayment
 * 
 * @property int $id
 * @property int $sale_id
 * @property int $account_id
 * @property string|null $method
 * @property float $amount
 * @property string|null $reference
 * @property Carbon|null $paid_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Account $account
 * @property Sale $sale
 *
 * @package App\Models
 */
class SalePayment extends Model
{
	protected $table = 'sale_payments';

	protected $casts = [
		'sale_id' => 'int',
		'account_id' => 'int',
		'amount' => 'float',
		'paid_at' => 'datetime'
	];

	protected $fillable = [
		'sale_id',
		'account_id',
		'method',
		'amount',
		'reference',
		'paid_at'
	];

	public function account()
	{
		return $this->belongsTo(Account::class);
	}

	public function sale()
	{
		return $this->belongsTo(Sale::class);
	}
}
