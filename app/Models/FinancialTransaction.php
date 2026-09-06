<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FinancialTransaction
 * 
 * @property int $id
 * @property int|null $branch_id
 * @property int $account_id
 * @property string $transaction_type
 * @property float $debit
 * @property float $credit
 * @property string|null $reference_type
 * @property int|null $reference_id
 * @property Carbon $transaction_date
 * @property string|null $description
 * @property int|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Account $account
 * @property Branch|null $branch
 *
 * @package App\Models
 */
class FinancialTransaction extends Model
{
	protected $table = 'financial_transactions';

	protected $casts = [
		'branch_id' => 'int',
		'account_id' => 'int',
		'debit' => 'float',
		'credit' => 'float',
		'reference_id' => 'int',
		'transaction_date' => 'datetime',
		'created_by' => 'int'
	];

	protected $fillable = [
		'branch_id',
		'account_id',
		'transaction_type',
		'debit',
		'credit',
		'reference_type',
		'reference_id',
		'transaction_date',
		'description',
		'created_by'
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
