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

                // If branch_id is not already set
                if (empty($model->branch_id)) {
                    if ($user->hasAnyRole(['Super Admin', 'Admin'])) {
                        $selectedBranchId = session('selected_branch_id');
                        if ($selectedBranchId && $selectedBranchId !== 'all') {
                            $model->branch_id = $selectedBranchId;
                        }
                    } else if ($user->employee && $user->employee->branch_id) {
                        $model->branch_id = $user->employee->branch_id;
                    }
                }
            }
        });
    }
}
