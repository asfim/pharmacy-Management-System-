<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 * 
 * @property int $id
 * @property string $name
 * @property string|null $image
 * @property string|null $description
 * @property string $status
 * @property int|null $parent_category_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Category|null $category
 * @property Collection|Category[] $categories
 * @property Collection|Product[] $products
 * @property Collection|SubCategory[] $sub_categories
 *
 * @package App\Models
 */
class Category extends Model
{
	protected $table = 'categories';

	protected $casts = [
		'parent_category_id' => 'int'
	];

	protected $fillable = [
		'name',
		'image',
		'description',
		'status',
		'parent_category_id'
	];

	public function category()
	{
		return $this->belongsTo(Category::class, 'parent_category_id');
	}

	public function categories()
	{
		return $this->hasMany(Category::class, 'parent_category_id');
	}

	public function products()
	{
		return $this->hasMany(Product::class);
	}

	public function sub_categories()
	{
		return $this->hasMany(SubCategory::class);
	}
}
