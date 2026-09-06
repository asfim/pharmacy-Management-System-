<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductImage
 * 
 * @property int $id
 * @property int $product_id
 * @property string $image_url
 * @property bool $is_primary
 * @property int $sort_order
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Product $product
 *
 * @package App\Models
 */
class ProductImage extends Model
{
	protected $table = 'product_images';

	protected $casts = [
		'product_id' => 'int',
		'is_primary' => 'bool',
		'sort_order' => 'int'
	];

	protected $fillable = [
		'product_id',
		'image_url',
		'is_primary',
		'sort_order'
	];

	public function product()
	{
		return $this->belongsTo(Product::class);
	}
}
