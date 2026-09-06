<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Coupon
 * 
 * @property int $id
 * @property string $code
 * @property string $type
 * @property float $value
 * @property float $min_order
 * @property float|null $max_discount
 * @property Carbon|null $start_at
 * @property Carbon|null $end_at
 * @property int|null $usage_limit
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|CouponUsage[] $coupon_usages
 *
 * @package App\Models
 */
class Coupon extends Model
{
	protected $table = 'coupons';

	protected $casts = [
		'value' => 'float',
		'min_order' => 'float',
		'max_discount' => 'float',
		'start_at' => 'datetime',
		'end_at' => 'datetime',
		'usage_limit' => 'int'
	];

	protected $fillable = [
		'code',
		'type',
		'value',
		'min_order',
		'max_discount',
		'start_at',
		'end_at',
		'usage_limit',
		'status'
	];

	public function coupon_usages()
	{
		return $this->hasMany(CouponUsage::class);
	}
}
