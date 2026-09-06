<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SubCategory
 * 
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property string|null $image
 * @property string|null $description
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Category $category
 * @property Collection|Product[] $products
 *
 * @package App\Models
 */
class SubCategory extends Model
{
	protected $table = 'sub_categories';

	protected $casts = [
		'category_id' => 'int'
	];

	protected $fillable = [
		'category_id',
		'name',
		'image',
		'description',
		'status'
	];

	public function category()
	{
		return $this->belongsTo(Category::class);
	}

	public function products()
	{
		return $this->hasMany(Product::class);
	}
}
