<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductReview
 * 
 * @property int $id
 * @property int $product_id
 * @property int $customer_id
 * @property int|null $order_id
 * @property int $rating
 * @property string|null $review_text
 * @property string $status
 * @property int|null $approved_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Customer $customer
 * @property OnlineOrder|null $online_order
 * @property Product $product
 *
 * @package App\Models
 */
class ProductReview extends Model
{
	protected $table = 'product_reviews';

	protected $casts = [
		'product_id' => 'int',
		'customer_id' => 'int',
		'order_id' => 'int',
		'rating' => 'int',
		'approved_by' => 'int'
	];

	protected $fillable = [
		'product_id',
		'customer_id',
		'order_id',
		'rating',
		'review_text',
		'status',
		'approved_by'
	];

	public function customer()
	{
		return $this->belongsTo(Customer::class);
	}

	public function online_order()
	{
		return $this->belongsTo(OnlineOrder::class, 'order_id');
	}

	public function product()
	{
		return $this->belongsTo(Product::class);
	}
}
