<?php

namespace App\Traits;

use App\Models\Scopes\BranchScope;
use Illuminate\Support\Facades\Auth;

trait BelongsToBranch
{
    /**
     * Boot the trait to add the global scope and creating event.
     */
    protected static function bootBelongsToBranch()
    {
        // Register the global scope
        static::addGlobalScope(new BranchScope);

        // Listen for the creating event
        static::creating(function ($model) {
            if (Auth::check()) {
                $user = Auth::user();

                // If branch_id is not already explicitly set on the model
                if (empty($model->branch_id)) {
                    $selectedBranchId = session('selected_branch_id');
                    $userBranchId = $user->branch_id ?? ($user->employee->branch_id ?? null);

                    if ($userBranchId && !$user->hasRole('Super Admin')) {
                        $model->branch_id = $userBranchId;
                    } elseif ($selectedBranchId && $selectedBranchId !== 'all') {
                        $model->branch_id = $selectedBranchId;
                    } else {
                        $model->branch_id = $userBranchId ?: 1;
                    }
                }
            }
        });
    }
}
