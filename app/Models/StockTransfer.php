<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

/**
 * Class StockTransfer
 * 
 * @property int $id
 * @property int $source_branch_id
 * @property int $destination_branch_id
 * @property string $transfer_no
 * @property string $status
 * @property Carbon|null $shipped_at
 * @property Carbon|null $received_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Branch $branch
 * @property Collection|StockTransferItem[] $stock_transfer_items
 *
 * @package App\Models
 */
class StockTransfer extends Model
{
	protected $table = 'stock_transfers';

	protected $casts = [
		'source_branch_id' => 'int',
		'destination_branch_id' => 'int',
		'shipped_at' => 'datetime',
		'received_at' => 'datetime'
	];

	protected $fillable = [
		'source_branch_id',
		'destination_branch_id',
		'transfer_no',
		'status',
		'shipped_at',
		'received_at'
	];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('branch_transfer', function (Builder $builder) {
            if (Auth::check()) {
                $user = Auth::user();
                
                if ($user->hasAnyRole(['Super Admin', 'Admin'])) {
                    $selectedBranchId = session('selected_branch_id');
                    if ($selectedBranchId && $selectedBranchId !== 'all') {
                        $builder->where(function ($q) use ($selectedBranchId) {
                            $q->where('source_branch_id', $selectedBranchId)
                              ->orWhere('destination_branch_id', $selectedBranchId);
                        });
                    }
                } else if ($user->employee && $user->employee->branch_id) {
                    $branchId = $user->employee->branch_id;
                    $builder->where(function ($q) use ($branchId) {
                        $q->where('source_branch_id', $branchId)
                          ->orWhere('destination_branch_id', $branchId);
                    });
                }
            }
        });

        static::creating(function ($model) {
            if (Auth::check()) {
                $user = Auth::user();
                if (empty($model->source_branch_id)) {
                    if ($user->hasAnyRole(['Super Admin', 'Admin'])) {
                        $selectedBranchId = session('selected_branch_id');
                        if ($selectedBranchId && $selectedBranchId !== 'all') {
                            $model->source_branch_id = $selectedBranchId;
                        }
                    } else if ($user->employee && $user->employee->branch_id) {
                        $model->source_branch_id = $user->employee->branch_id;
                    }
                }
            }
        });
    }

	public function branch()
	{
		return $this->belongsTo(Branch::class, 'source_branch_id');
	}

	public function stock_transfer_items()
	{
		return $this->hasMany(StockTransferItem::class, 'transfer_id');
	}
}
