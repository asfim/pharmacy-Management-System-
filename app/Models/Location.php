<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Location
 * 
 * @property int $id
 * @property int $branch_id
 * @property string|null $rack
 * @property string|null $shelf
 * @property string|null $cabinet
 * @property string|null $row
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Branch $branch
 * @property Collection|StockBalance[] $stock_balances
 *
 * @package App\Models
 */
class Location extends Model
{
	protected $table = 'locations';

	protected $casts = [
		'branch_id' => 'int'
	];

	protected $fillable = [
		'branch_id',
		'rack',
		'shelf',
		'cabinet',
		'row',
		'status'
	];

	public function branch()
	{
		return $this->belongsTo(Branch::class);
	}

	public function stock_balances()
	{
		return $this->hasMany(StockBalance::class);
	}
}
