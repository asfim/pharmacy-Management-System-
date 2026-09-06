<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Generic
 * 
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $dosage
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Product[] $products
 *
 * @package App\Models
 */
class Generic extends Model
{
	protected $table = 'generics';

	protected $fillable = [
		'name',
		'description',
		'dosage',
		'status'
	];

	public function products()
	{
		return $this->hasMany(Product::class);
	}
}
