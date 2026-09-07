<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ReturnItem
 * 
 * @property int $id
 * @property int $return_id
 * @property int $product_id
 * @property int $quantity
 * @property float $amount
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Product $product
 * @property Return $return
 *
 * @package App\Models
 */
class ReturnItem extends Model
{
	protected $table = 'return_items';

	protected $casts = [
		'return_id' => 'int',
		'product_id' => 'int',
		'quantity' => 'int',
		'amount' => 'float'
	];

	protected $fillable = [
		'return_id',
		'product_id',
		'quantity',
		'amount'
	];

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function return()
	{
		return $this->belongsTo('App\Models\Return');
	}
}
