<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Income
 * 
 * @property int $id
 * @property int|null $branch_id
 * @property int $account_id
 * @property string $category
 * @property float $amount
 * @property Carbon $income_date
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Account $account
 * @property Branch|null $branch
 *
 * @package App\Models
 */
class Income extends Model
{
	protected $table = 'income';

	protected $casts = [
		'branch_id' => 'int',
		'account_id' => 'int',
		'amount' => 'float',
		'income_date' => 'datetime'
	];

	protected $fillable = [
		'branch_id',
		'account_id',
		'category',
		'amount',
		'income_date',
		'description'
	];

	public function account()
	{
		return $this->belongsTo(Account::class);
	}

	public function branch()
	{
		return $this->belongsTo(Branch::class);
	}
}
