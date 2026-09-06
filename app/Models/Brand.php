<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Brand
 * 
 * @property int $id
 * @property string $name
 * @property int|null $manufacturer_id
 * @property string|null $country
 * @property string|null $contact
 * @property string|null $website
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Manufacturer|null $manufacturer
 * @property Collection|Product[] $products
 *
 * @package App\Models
 */
class Brand extends Model
{
	protected $table = 'brands';

	protected $casts = [
		'manufacturer_id' => 'int'
	];

	protected $fillable = [
		'name',
		'manufacturer_id',
		'country',
		'contact',
		'website',
		'status'
	];

	public function manufacturer()
	{
		return $this->belongsTo(Manufacturer::class);
	}

	public function products()
	{
		return $this->hasMany(Product::class);
	}
}
