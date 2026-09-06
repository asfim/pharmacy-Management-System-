<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Manufacturer
 * 
 * @property int $id
 * @property string $company_name
 * @property string|null $address
 * @property string|null $contact_person
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $website
 * @property string|null $license_info
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Brand[] $brands
 * @property Collection|Product[] $products
 *
 * @package App\Models
 */
class Manufacturer extends Model
{
	protected $table = 'manufacturers';

	protected $fillable = [
		'company_name',
		'address',
		'contact_person',
		'phone',
		'email',
		'website',
		'license_info',
		'status'
	];

	public function brands()
	{
		return $this->hasMany(Brand::class);
	}

	public function products()
	{
		return $this->hasMany(Product::class);
	}
}
