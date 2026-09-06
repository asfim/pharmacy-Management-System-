<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Expense
 * 
 * @property int $id
 * @property int|null $branch_id
 * @property int $category_id
 * @property int $account_id
 * @property float $amount
 * @property Carbon $expense_date
 * @property string|null $description
 * @property string|null $attachment
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Account $account
 * @property Branch|null $branch
 * @property ExpenseCategory $expense_category
 *
 * @package App\Models
 */
class Expense extends Model
{
	protected $table = 'expenses';

	protected $casts = [
		'branch_id' => 'int',
		'category_id' => 'int',
		'account_id' => 'int',
		'amount' => 'float',
		'expense_date' => 'datetime'
	];

	protected $fillable = [
		'branch_id',
		'category_id',
		'account_id',
		'amount',
		'expense_date',
		'description',
		'attachment'
	];

	public function account()
	{
		return $this->belongsTo(Account::class);
	}

	public function branch()
	{
		return $this->belongsTo(Branch::class);
	}

	public function expense_category()
	{
		return $this->belongsTo(ExpenseCategory::class, 'category_id');
	}
}
