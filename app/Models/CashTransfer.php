<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CashTransfer
 * 
 * @property int $id
 * @property int $from_account_id
 * @property int $to_account_id
 * @property float $amount
 * @property Carbon $transfer_date
 * @property string|null $note
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Account $account
 *
 * @package App\Models
 */
class CashTransfer extends Model
{
	protected $table = 'cash_transfers';

	protected $casts = [
		'from_account_id' => 'int',
		'to_account_id' => 'int',
		'amount' => 'float',
		'transfer_date' => 'datetime'
	];

	protected $fillable = [
		'from_account_id',
		'to_account_id',
		'amount',
		'transfer_date',
		'note'
	];

	public function account()
	{
		return $this->belongsTo(Account::class, 'to_account_id');
	}
}
