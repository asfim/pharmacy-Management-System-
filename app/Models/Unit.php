<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Unit
 * 
 * @property int $id
 * @property string $name
 * @property string|null $symbol
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Product[] $products
 *
 * @package App\Models
 */
class Unit extends Model
{
	protected $table = 'units';

	protected $fillable = [
		'name',
		'symbol',
		'status'
	];

	public function products()
	{
		return $this->hasMany(Product::class);
	}
}
