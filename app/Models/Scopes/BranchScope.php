<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class BranchScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (Auth::check()) {
            $user = Auth::user();

            // If user is a super admin or admin, they can see everything unless they selected a specific branch
            if ($user->hasAnyRole(['Super Admin', 'Admin'])) {
                $selectedBranchId = session('selected_branch_id');
                
                if ($selectedBranchId && $selectedBranchId !== 'all') {
                    $builder->where($model->getTable() . '.branch_id', $selectedBranchId);
                }
                
                return;
            }

            // For regular users, force query to their assigned branch
            if ($user->employee && $user->employee->branch_id) {
                $builder->where($model->getTable() . '.branch_id', $user->employee->branch_id);
            }
        }
    }
}
